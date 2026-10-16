<?php
/**
 * Facebook → News importer.
 *
 * Pulls recent posts from the Leeroy Systems Facebook Page through Facebook's
 * official Graph API and saves them as WordPress posts (News), with the post
 * photo as the featured image. Runs hourly, or on demand from
 * wp-admin → Tools → Facebook News.
 *
 * Setup — add to wp-config.php (a Page access token from a Page admin):
 *   define( 'LEEROY_FB_ACCESS_TOKEN', 'EAAB...' );
 * Optional:
 *   define( 'LEEROY_FB_PAGE_ID', '100063566140015' );  // default shown
 *   define( 'LEEROY_FB_IMPORT_STATUS', 'publish' );    // default 'draft'
 *
 * Imported posts are tagged with the Facebook post ID, so nothing is ever
 * imported twice, and edits made in WordPress are never overwritten.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leeroy_fb_settings(): array {
	return [
		'token'  => defined( 'LEEROY_FB_ACCESS_TOKEN' ) ? LEEROY_FB_ACCESS_TOKEN : '',
		'page'   => defined( 'LEEROY_FB_PAGE_ID' ) ? LEEROY_FB_PAGE_ID : '100063566140015',
		'status' => defined( 'LEEROY_FB_IMPORT_STATUS' ) && in_array( LEEROY_FB_IMPORT_STATUS, [ 'draft', 'publish', 'pending' ], true ) ? LEEROY_FB_IMPORT_STATUS : 'draft',
	];
}

/* Hourly schedule — only while a token is configured. */
add_action( 'init', function () {
	$scheduled = wp_next_scheduled( 'leeroy_fb_import' );
	if ( leeroy_fb_settings()['token'] && ! $scheduled ) {
		wp_schedule_event( time() + 60, 'hourly', 'leeroy_fb_import' );
	} elseif ( ! leeroy_fb_settings()['token'] && $scheduled ) {
		wp_clear_scheduled_hook( 'leeroy_fb_import' );
	}
} );
add_action( 'leeroy_fb_import', 'leeroy_fb_run_import' );
add_action( 'switch_theme', function () {
	wp_clear_scheduled_hook( 'leeroy_fb_import' );
} );

/**
 * Fetch recent Page posts and import any we haven't seen.
 *
 * @return array{imported:int, skipped:int, error:string}
 */
function leeroy_fb_run_import(): array {
	$cfg    = leeroy_fb_settings();
	$result = [ 'imported' => 0, 'skipped' => 0, 'error' => '' ];

	if ( ! $cfg['token'] ) {
		$result['error'] = 'No Facebook access token is configured (LEEROY_FB_ACCESS_TOKEN in wp-config.php).';
		return leeroy_fb_log( $result );
	}

	$url = add_query_arg( [
		'fields'       => 'id,message,created_time,full_picture,permalink_url',
		'limit'        => 25,
		'access_token' => $cfg['token'],
	], 'https://graph.facebook.com/' . rawurlencode( $cfg['page'] ) . '/posts' );

	$response = wp_remote_get( $url, [ 'timeout' => 20 ] );
	if ( is_wp_error( $response ) ) {
		$result['error'] = 'Could not reach Facebook: ' . $response->get_error_message();
		return leeroy_fb_log( $result );
	}
	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( ! empty( $body['error'] ) ) {
		$result['error'] = 'Facebook said: ' . ( $body['error']['message'] ?? 'unknown error' );
		return leeroy_fb_log( $result );
	}

	foreach ( (array) ( $body['data'] ?? [] ) as $fb ) {
		$message = trim( (string) ( $fb['message'] ?? '' ) );
		// Only real stories: skip photo-only posts and one-liners.
		if ( empty( $fb['id'] ) || mb_strlen( $message ) < 60 || leeroy_fb_already_imported( $fb['id'] ) ) {
			$result['skipped']++;
			continue;
		}
		if ( leeroy_fb_create_post( $fb, $message, $cfg['status'] ) ) {
			$result['imported']++;
		}
	}

	return leeroy_fb_log( $result );
}

function leeroy_fb_already_imported( string $fb_id ): bool {
	$found = get_posts( [
		'post_type'      => 'post',
		'post_status'    => 'any',
		'meta_key'       => '_leeroy_fb_id',
		'meta_value'     => $fb_id,
		'fields'         => 'ids',
		'posts_per_page' => 1,
	] );
	return ! empty( $found );
}

/** Title = the post's first sentence (or line), kept to a headline length. */
function leeroy_fb_title( string $message ): string {
	$first = preg_split( '/\R/u', $message )[0];
	if ( preg_match( '/^(.{20,110}?[.!?])(\s|$)/u', $first, $m ) ) {
		$first = $m[1];
	}
	$first = trim( preg_replace( '/[#@]\w+/u', '', $first ) );
	return mb_strlen( $first ) > 90 ? rtrim( mb_substr( $first, 0, 87 ) ) . '…' : $first;
}

function leeroy_fb_create_post( array $fb, string $message, string $status ): int {
	$term = term_exists( 'Facebook', 'category' );
	if ( ! $term ) {
		$term = wp_insert_term( 'Facebook', 'category' );
	}

	$content  = wpautop( make_clickable( esc_html( $message ) ) );
	$content .= '<p class="fb-source"><a href="' . esc_url( $fb['permalink_url'] ?? '' ) . '" target="_blank" rel="noopener">View the original post on Facebook</a></p>';

	$post_id = wp_insert_post( [
		'post_title'    => leeroy_fb_title( $message ),
		'post_content'  => $content,
		'post_excerpt'  => wp_trim_words( $message, 30, '…' ),
		'post_status'   => $status,
		'post_date_gmt' => gmdate( 'Y-m-d H:i:s', strtotime( $fb['created_time'] ?? 'now' ) ),
		'post_date'     => get_date_from_gmt( gmdate( 'Y-m-d H:i:s', strtotime( $fb['created_time'] ?? 'now' ) ) ),
		'post_category' => is_wp_error( $term ) ? [] : [ (int) $term['term_id'] ],
	], true );

	if ( is_wp_error( $post_id ) ) {
		return 0;
	}
	update_post_meta( $post_id, '_leeroy_fb_id', sanitize_text_field( $fb['id'] ) );
	update_post_meta( $post_id, '_leeroy_fb_url', esc_url_raw( $fb['permalink_url'] ?? '' ) );

	if ( ! empty( $fb['full_picture'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$tmp = download_url( $fb['full_picture'], 30 );
		if ( ! is_wp_error( $tmp ) ) {
			$file = [ 'name' => 'facebook-' . sanitize_file_name( $fb['id'] ) . '.jpg', 'tmp_name' => $tmp ];
			$att  = media_handle_sideload( $file, $post_id, get_the_title( $post_id ) );
			if ( is_wp_error( $att ) ) {
				wp_delete_file( $tmp );
			} else {
				set_post_thumbnail( $post_id, $att );
			}
		}
	}
	return (int) $post_id;
}

function leeroy_fb_log( array $result ): array {
	update_option( 'leeroy_fb_last_run', [ 'time' => time() ] + $result, false );
	return $result;
}

/* -------------------------------------------------------------------------
 * wp-admin → Tools → Facebook News
 * ---------------------------------------------------------------------- */

add_action( 'admin_menu', function () {
	add_management_page( 'Facebook News', 'Facebook News', 'manage_options', 'leeroy-facebook-news', 'leeroy_fb_admin_page' );
} );

add_action( 'admin_post_leeroy_fb_import_now', function () {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'leeroy_fb_import_now' ) ) {
		wp_die( 'Not allowed.' );
	}
	leeroy_fb_run_import();
	wp_safe_redirect( admin_url( 'tools.php?page=leeroy-facebook-news&ran=1' ) );
	exit;
} );

function leeroy_fb_admin_page() {
	$cfg  = leeroy_fb_settings();
	$last = get_option( 'leeroy_fb_last_run' );
	?>
	<div class="wrap">
		<h1>Facebook News</h1>
		<p>Imports recent posts from the Leeroy Systems Facebook Page as News stories (with their photos). New posts are checked every hour.</p>

		<table class="widefat striped" style="max-width:720px">
			<tbody>
				<tr><th>Facebook Page ID</th><td><code><?php echo esc_html( $cfg['page'] ); ?></code></td></tr>
				<tr><th>Access token</th><td><?php echo $cfg['token'] ? '✅ Configured' : '❌ Not set — add <code>LEEROY_FB_ACCESS_TOKEN</code> to wp-config.php'; ?></td></tr>
				<tr><th>Imported posts are saved as</th><td><strong><?php echo esc_html( 'publish' === $cfg['status'] ? 'Published' : ucfirst( $cfg['status'] ) ); ?></strong><?php echo 'draft' === $cfg['status'] ? ' — review them under Posts and publish the major ones.' : ''; ?></td></tr>
				<tr><th>Last run</th><td>
					<?php if ( $last ) : ?>
						<?php echo esc_html( wp_date( 'j F Y, H:i', $last['time'] ) ); ?> —
						<?php echo (int) $last['imported']; ?> imported, <?php echo (int) $last['skipped']; ?> skipped
						<?php if ( $last['error'] ) : ?><br><span style="color:#b32d2e"><?php echo esc_html( $last['error'] ); ?></span><?php endif; ?>
					<?php else : ?>
						Never
					<?php endif; ?>
				</td></tr>
			</tbody>
		</table>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:20px">
			<input type="hidden" name="action" value="leeroy_fb_import_now">
			<?php wp_nonce_field( 'leeroy_fb_import_now' ); ?>
			<?php submit_button( 'Import from Facebook now', 'primary', 'submit', false, $cfg['token'] ? [] : [ 'disabled' => 'disabled' ] ); ?>
		</form>

		<h2 style="margin-top:30px">How to get the access token</h2>
		<ol style="max-width:720px">
			<li>A Facebook admin of the Leeroy Systems Page signs in at <a href="https://developers.facebook.com/" target="_blank" rel="noopener">developers.facebook.com</a> and creates an app (type “Business”).</li>
			<li>In <strong>Graph API Explorer</strong>, select the app, choose <em>Get Page Access Token</em>, pick the Leeroy Systems Page and grant <code>pages_read_engagement</code> and <code>pages_read_user_content</code>.</li>
			<li>Exchange it for a <strong>long-lived</strong> Page token (Access Token Debugger → “Extend Access Token”).</li>
			<li>Add it to <code>wp-config.php</code>: <code>define( 'LEEROY_FB_ACCESS_TOKEN', 'paste-token-here' );</code></li>
		</ol>
		<p>Posts shorter than about a sentence, and photo-only posts, are skipped. Each imported story links back to the original Facebook post.</p>
	</div>
	<?php
}
