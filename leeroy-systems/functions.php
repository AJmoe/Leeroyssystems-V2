<?php
/**
 * Leeroy Systems theme.
 *
 * A single, self-contained theme: every page's content lives in
 * inc/data.php and the templates, images ship in assets/img, and the
 * contact + careers forms are handled here (no Elementor / CF7 needed).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LEEROY_VERSION', '1.0.0' );
define( 'LEEROY_FORM_TO', 'info@leeroysystems.co.bw' );

require get_template_directory() . '/inc/data.php';
require get_template_directory() . '/inc/icons.php';
require get_template_directory() . '/inc/facebook-import.php';
require get_template_directory() . '/inc/news-seed.php';
require get_template_directory() . '/inc/gallery.php';
require get_template_directory() . '/inc/hardening.php';

// Post galleries are styled by the theme (grid + lightbox), not WordPress's inline CSS.
add_filter( 'use_default_gallery_style', '__return_false' );

/* -------------------------------------------------------------------------
 * Setup
 * ---------------------------------------------------------------------- */

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'style', 'script' ] );
	register_nav_menus( [ 'footer' => 'Footer quick links (optional)' ] );
} );

add_action( 'wp_enqueue_scripts', function () {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'leeroy-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap', [], null );
	wp_enqueue_style( 'leeroy-theme', $uri . '/assets/css/theme.css', [], filemtime( $dir . '/assets/css/theme.css' ) );
	wp_enqueue_script( 'leeroy-theme', $uri . '/assets/js/theme.js', [], filemtime( $dir . '/assets/js/theme.js' ), true );

	if ( leeroy_recaptcha_keys() ) {
		wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js', [], null, true );
	}
} );

// Drop block-library CSS on the front end — no block content is rendered.
add_action( 'wp_enqueue_scripts', function () {
	if ( ! is_singular( 'post' ) ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}, 100 );

/* -------------------------------------------------------------------------
 * Pages: created automatically when the theme is activated, so the site
 * works straight after "Activate" with no content import.
 * ---------------------------------------------------------------------- */

function leeroy_required_pages(): array {
	$pages = [
		'home'      => 'Home',
		'community' => 'Community',
		'news'      => 'News',
		'gallery'   => 'Gallery',
		'careers'   => 'Careers',
	];
	foreach ( leeroy_services() as $slug => $s ) {
		$pages[ $slug ] = $s['title'];
	}
	foreach ( leeroy_projects() as $slug => $p ) {
		$pages[ $slug ] = $p['title'];
	}
	return $pages;
}

function leeroy_install_pages() {
	foreach ( leeroy_required_pages() as $slug => $title ) {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			$id = wp_insert_post( [
				'post_title'  => $title,
				'post_name'   => $slug,
				'post_status' => 'publish',
				'post_type'   => 'page',
			] );
		} else {
			$id = $page->ID;
			if ( 'publish' !== $page->post_status ) {
				wp_update_post( [ 'ID' => $id, 'post_status' => 'publish' ] );
			}
		}
		if ( 'home' === $slug && $id && ! is_wp_error( $id ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $id );
		}
	}
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'leeroy_install_pages' );

/**
 * Content updates can add pages (e.g. new services). Bump this when the
 * page list changes and existing installs create the missing pages once.
 */
define( 'LEEROY_PAGES_VERSION', '4' );
add_action( 'init', function () {
	if ( get_option( 'leeroy_pages_version' ) !== LEEROY_PAGES_VERSION ) {
		leeroy_install_pages();
		update_option( 'leeroy_pages_version', LEEROY_PAGES_VERSION );
	}
} );

/** Old service address from before the company-profile update. */
add_action( 'template_redirect', function () {
	$moved = [ 'service-network' => 'service-iot' ];
	$slug  = leeroy_current_slug();
	if ( isset( $moved[ $slug ] ) ) {
		wp_safe_redirect( leeroy_page_url( $moved[ $slug ] ), 301 );
		exit;
	}
} );

/* -------------------------------------------------------------------------
 * Helpers
 * ---------------------------------------------------------------------- */

function leeroy_img( string $file ): string {
	return get_template_directory_uri() . '/assets/img/' . $file;
}

function leeroy_page_url( string $slug ): string {
	return 'home' === $slug ? home_url( '/' ) : home_url( '/' . $slug . '/' );
}

/** Slug of the current page ('home' for the front page). */
function leeroy_current_slug(): string {
	if ( is_front_page() ) {
		return 'home';
	}
	$obj = get_queried_object();
	return ( $obj instanceof WP_Post ) ? $obj->post_name : '';
}

/* -------------------------------------------------------------------------
 * News — ordinary WordPress posts (Posts → Add New in wp-admin).
 * ---------------------------------------------------------------------- */

define( 'LEEROY_FACEBOOK_PAGE', 'https://www.facebook.com/100063566140015' );

/**
 * Cover image for a news post: the featured image if one is set, otherwise
 * a theme photo named in the "leeroy_cover" custom field, otherwise a default.
 */
function leeroy_post_cover( int $post_id, string $size = 'large' ): string {
	if ( has_post_thumbnail( $post_id ) ) {
		return (string) get_the_post_thumbnail_url( $post_id, $size );
	}
	$file = get_post_meta( $post_id, 'leeroy_cover', true );
	return leeroy_img( $file ? basename( $file ) : 'hq-leeroy.jpg' );
}

/** WordPress's built-in "Hello world!" sample post never appears in News. */
function leeroy_news_excluded(): array {
	$sample = get_page_by_path( 'hello-world', OBJECT, 'post' );
	return $sample ? [ (int) $sample->ID ] : [];
}

function leeroy_reading_time( int $post_id ): string {
	$words = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
	return max( 1, (int) ceil( $words / 200 ) ) . ' min read';
}


/* -------------------------------------------------------------------------
 * SEO + favicons
 * ---------------------------------------------------------------------- */

/** Shorten text to a search-snippet length, ending on a whole word. */
function leeroy_meta_trim( string $text, int $max = 158 ): string {
	$text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( $text ) ) );
	if ( mb_strlen( $text ) <= $max ) {
		return $text;
	}
	$cut = preg_replace( '/\s+\S*$/u', '', mb_substr( $text, 0, $max - 1 ) );
	return rtrim( $cut, ' ,;:.-' ) . '…';
}

/** The gallery album being viewed (?album=slug), if any. */
function leeroy_current_album() {
	if ( 'gallery' !== leeroy_current_slug() || empty( $_GET['album'] ) ) {
		return null;
	}
	$album = get_term_by( 'slug', sanitize_title( wp_unslash( $_GET['album'] ) ), LEEROY_ALBUM_TAX );
	return $album ? $album : null;
}

// One title style everywhere: "Page | Leeroy Systems".
add_filter( 'document_title_separator', function () {
	return '|';
} );

add_filter( 'pre_get_document_title', function ( $title ) {
	$album = leeroy_current_album();
	if ( $album ) {
		return $album->name . ' | Gallery | Leeroy Systems';
	}
	$seo = leeroy_seo_data()[ leeroy_current_slug() ] ?? null;
	return $seo ? $seo['title'] : $title;
} );

// Album pages are distinct pages, so their canonical keeps ?album=.
add_filter( 'get_canonical_url', function ( $url ) {
	$album = leeroy_current_album();
	return $album ? add_query_arg( 'album', $album->slug, $url ) : $url;
} );

// Search results and the 404 page stay out of search engines.
add_filter( 'wp_robots', function ( $robots ) {
	if ( is_search() || is_404() ) {
		$robots['noindex'] = true;
		if ( empty( $robots['nofollow'] ) ) {
			$robots['follow'] = true;
		}
	}
	return $robots;
} );

/** Title, description, image and URL for this request's SEO and social tags. */
function leeroy_meta_for_request(): array {
	$seo  = leeroy_seo_data()[ leeroy_current_slug() ] ?? null;
	$meta = [
		'title'       => wp_get_document_title(),
		'description' => '',
		'image'       => leeroy_img( 'hq-leeroy.jpg' ),
		'url'         => '',
		'type'        => 'website',
	];
	if ( $seo ) {
		$album               = leeroy_current_album();
		$meta['description'] = $seo['description'];
		$meta['url']         = is_front_page() ? home_url( '/' ) : wp_get_canonical_url( get_queried_object_id() );
		if ( $album ) {
			$meta['description'] = $album->description ? $album->description : 'Photos from ' . $album->name . ' in the Leeroy Systems gallery: events, visits, training and community outreach in Botswana.';
		}
	} elseif ( is_singular() ) {
		$id                  = get_queried_object_id();
		$meta['description'] = get_the_excerpt( $id );
		$meta['url']         = get_permalink( $id );
		if ( is_singular( 'post' ) ) {
			$meta['image'] = leeroy_post_cover( $id );
			$meta['type']  = 'article';
		}
	} elseif ( is_category() || is_tag() ) {
		$term                = get_queried_object();
		$meta['description'] = $term->description ? $term->description : 'Leeroy Systems news filed under ' . $term->name . ': projects, partnerships and community stories from Botswana.';
		$link                = get_term_link( $term );
		$meta['url']         = is_wp_error( $link ) ? '' : $link;
	}
	$meta['description'] = leeroy_meta_trim( (string) $meta['description'] );
	return $meta;
}

add_action( 'wp_head', function () {
	if ( ! is_404() && ! is_search() ) {
		$m = leeroy_meta_for_request();
		if ( $m['description'] ) {
			echo '<meta name="description" content="' . esc_attr( $m['description'] ) . '">' . "\n";
		}
		// WordPress prints rel=canonical on singular pages; term archives need their own.
		if ( ( is_category() || is_tag() ) && $m['url'] ) {
			echo '<link rel="canonical" href="' . esc_url( $m['url'] ) . '">' . "\n";
		}
		$og = [
			'og:site_name'   => 'Leeroy Systems',
			'og:locale'      => 'en_GB',
			'og:type'        => $m['type'],
			'og:title'       => $m['title'],
			'og:description' => $m['description'],
		];
		foreach ( $og as $property => $content ) {
			if ( $content ) {
				echo '<meta property="' . esc_attr( $property ) . '" content="' . esc_attr( $content ) . '">' . "\n";
			}
		}
		if ( $m['url'] ) {
			echo '<meta property="og:url" content="' . esc_url( $m['url'] ) . '">' . "\n";
		}
		echo '<meta property="og:image" content="' . esc_url( $m['image'] ) . '">' . "\n";
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( $m['title'] ) . '">' . "\n";
		if ( $m['description'] ) {
			echo '<meta name="twitter:description" content="' . esc_attr( $m['description'] ) . '">' . "\n";
		}
		echo '<meta name="twitter:image" content="' . esc_url( $m['image'] ) . '">' . "\n";
	}
	if ( is_front_page() ) {
		$c      = leeroy_contact();
		$schema = [
			'@context'  => 'https://schema.org',
			'@type'     => 'Organization',
			'name'      => 'Leeroy Systems',
			'url'       => home_url( '/' ),
			'logo'      => leeroy_img( 'logo.png' ),
			'email'     => $c['email'],
			'telephone' => $c['tel'],
			'address'   => [
				'@type'           => 'PostalAddress',
				'streetAddress'   => 'Plot 176, Gaborone International Commerce Park',
				'addressLocality' => 'Gaborone',
				'addressCountry'  => 'BW',
			],
			'sameAs'    => array_values( array_filter( [ $c['facebook'], $c['linkedin'], $c['youtube'] ] ) ),
		];
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
	echo '<meta name="theme-color" content="#223258">' . "\n";
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" href="' . esc_url( leeroy_img( 'favicon.ico' ) ) . '" sizes="any">' . "\n";
		echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( leeroy_img( 'favicon-32x32.png' ) ) . '">' . "\n";
		echo '<link rel="icon" type="image/png" sizes="192x192" href="' . esc_url( leeroy_img( 'favicon-192x192.png' ) ) . '">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . esc_url( leeroy_img( 'apple-touch-icon.png' ) ) . '">' . "\n";
	}
}, 1 );

/* -------------------------------------------------------------------------
 * Forms — contact (3 types) + careers application, sent with wp_mail().
 * Configure SMTP with any mail plugin (e.g. WP Mail SMTP); wp_mail uses it.
 * Optional reCAPTCHA v2: define LEEROY_RECAPTCHA_SITEKEY / _SECRET in
 * wp-config.php (the old WPCF7_RECAPTCHA_* constants also work).
 * ---------------------------------------------------------------------- */

function leeroy_recaptcha_keys(): ?array {
	$site   = defined( 'LEEROY_RECAPTCHA_SITEKEY' ) ? LEEROY_RECAPTCHA_SITEKEY : ( defined( 'WPCF7_RECAPTCHA_SITEKEY' ) ? WPCF7_RECAPTCHA_SITEKEY : '' );
	$secret = defined( 'LEEROY_RECAPTCHA_SECRET' ) ? LEEROY_RECAPTCHA_SECRET : ( defined( 'WPCF7_RECAPTCHA_SECRET' ) ? WPCF7_RECAPTCHA_SECRET : '' );
	return ( $site && $secret ) ? [ 'site' => $site, 'secret' => $secret ] : null;
}

function leeroy_form_definitions(): array {
	return [
		'personal'    => [
			'subject'  => 'New "For Me" inquiry from %s',
			'required' => [ 'name', 'query' ],
			'fields'   => [ 'name' => 'Name', 'contact_pref' => 'Preferred contact', 'email' => 'Email', 'phone' => 'Phone', 'plot_number' => 'Plot number', 'meter_number' => 'Meter number', 'query' => 'Query' ],
		],
		'business'    => [
			'subject'  => 'New business inquiry from %s',
			'required' => [ 'name', 'email', 'message' ],
			'fields'   => [ 'name' => 'Name', 'email' => 'Email', 'phone' => 'Phone', 'organisation' => 'Organisation', 'inquiry_type' => 'Inquiry type', 'message' => 'Message' ],
		],
		'sponsorship' => [
			'subject'  => 'New sponsorship / marketing proposal from %s',
			'required' => [ 'name', 'email', 'request_type', 'message' ],
			'fields'   => [ 'name' => 'Name', 'organisation' => 'Organisation', 'email' => 'Email', 'phone' => 'Phone', 'request_type' => 'Request type', 'project_name' => 'Initiative / campaign', 'message' => 'Message' ],
		],
		'careers'     => [
			'subject'  => 'New job application from %s',
			'required' => [ 'name', 'email', 'position' ],
			'fields'   => [ 'name' => 'Name', 'email' => 'Email', 'phone' => 'Phone', 'position' => 'Position', 'cover' => 'Cover note' ],
		],
	];
}

function leeroy_handle_form() {
	$type    = isset( $_POST['form_type'] ) ? sanitize_key( $_POST['form_type'] ) : '';
	$defs    = leeroy_form_definitions();
	$back    = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back    = remove_query_arg( [ 'form', 'status' ], $back );
	$anchor  = 'careers' === $type ? '#apply' : '#contact';
	$respond = function ( $status ) use ( $back, $type, $anchor ) {
		wp_safe_redirect( add_query_arg( [ 'form' => $type, 'status' => $status ], $back ) . $anchor );
		exit;
	};

	if ( ! isset( $defs[ $type ] ) || ! isset( $_POST['_leeroy_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_leeroy_nonce'] ) ), 'leeroy_form_' . $type ) ) {
		$respond( 'error' );
	}
	// Honeypot: real visitors never see or fill this field.
	if ( ! empty( $_POST['company_website'] ) ) {
		$respond( 'sent' );
	}
	if ( leeroy_form_rate_limited() ) {
		$respond( 'busy' );
	}

	$def    = $defs[ $type ];
	$values = [];
	foreach ( $def['fields'] as $key => $label ) {
		$raw            = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$values[ $key ] = in_array( $key, [ 'query', 'message', 'cover' ], true ) ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
	}
	foreach ( $def['required'] as $key ) {
		if ( '' === $values[ $key ] ) {
			$respond( 'invalid' );
		}
	}
	if ( 'personal' === $type && '' === $values['email'] && '' === $values['phone'] ) {
		$respond( 'invalid' );
	}
	if ( '' !== $values['email'] && ! is_email( $values['email'] ) ) {
		$respond( 'invalid' );
	}

	$keys = leeroy_recaptcha_keys();
	if ( $keys ) {
		$token = isset( $_POST['g-recaptcha-response'] ) ? sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) : '';
		if ( '' === $token ) {
			$respond( 'captcha' );
		}
		$res = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', [
			'body' => [ 'secret' => $keys['secret'], 'response' => $token ],
		] );
		if ( ! is_wp_error( $res ) ) {
			$body = json_decode( wp_remote_retrieve_body( $res ), true );
			if ( empty( $body['success'] ) ) {
				$respond( 'captcha' );
			}
		}
	}

	$attachments = [];
	if ( 'careers' === $type ) {
		if ( empty( $_FILES['cv']['name'] ) || UPLOAD_ERR_OK !== $_FILES['cv']['error'] ) {
			$respond( 'invalid' );
		}
		if ( $_FILES['cv']['size'] > 5 * MB_IN_BYTES ) {
			$respond( 'filesize' );
		}
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$upload = wp_handle_upload( $_FILES['cv'], [
			'test_form' => false,
			'mimes'     => [
				'pdf'  => 'application/pdf',
				'doc'  => 'application/msword',
				'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			],
		] );
		if ( isset( $upload['error'] ) ) {
			$respond( 'filetype' );
		}
		$attachments[] = $upload['file'];
	}

	$lines = [];
	foreach ( $def['fields'] as $key => $label ) {
		if ( '' !== $values[ $key ] ) {
			$lines[] = $label . ': ' . $values[ $key ];
		}
	}
	$lines[] = '';
	$lines[] = '-- Sent from the website form at ' . $back;

	$headers = [];
	if ( '' !== $values['email'] ) {
		$headers[] = 'Reply-To: ' . $values['name'] . ' <' . $values['email'] . '>';
	}

	$sent = wp_mail( LEEROY_FORM_TO, sprintf( $def['subject'], $values['name'] ), implode( "\n", $lines ), $headers, $attachments );

	foreach ( $attachments as $file ) {
		wp_delete_file( $file );
	}

	$respond( $sent ? 'sent' : 'error' );
}
add_action( 'admin_post_nopriv_leeroy_form', 'leeroy_handle_form' );
add_action( 'admin_post_leeroy_form', 'leeroy_handle_form' );

/** Hidden fields + status notice shared by every form. */
function leeroy_form_open( string $type ) {
	echo '<input type="hidden" name="action" value="leeroy_form">';
	echo '<input type="hidden" name="form_type" value="' . esc_attr( $type ) . '">';
	// Written by hand: wp_nonce_field() gives every form the same id attribute.
	echo '<input type="hidden" name="_leeroy_nonce" value="' . esc_attr( wp_create_nonce( 'leeroy_form_' . $type ) ) . '">';
	wp_referer_field();
	echo '<div class="hp-field" aria-hidden="true"><label>Website<input type="text" name="company_website" tabindex="-1" autocomplete="off"></label></div>';
}

function leeroy_form_notice( string $type ) {
	if ( ! isset( $_GET['form'], $_GET['status'] ) || sanitize_key( $_GET['form'] ) !== $type ) {
		return;
	}
	$messages = [
		'sent'     => [ 'ok', 'Thank you — your message has been sent. We\'ll get back to you within 24 hours.' ],
		'invalid'  => [ 'err', 'Please fill in all required fields (and a valid email address) and try again.' ],
		'captcha'  => [ 'err', 'Please tick the "I\'m not a robot" box before submitting.' ],
		'filesize' => [ 'err', 'Your CV is larger than 5 MB. Please upload a smaller file.' ],
		'filetype' => [ 'err', 'Please upload your CV as a PDF, DOC or DOCX file.' ],
		'busy'     => [ 'err', 'You have sent several messages in a short time. Please wait a few minutes and try again.' ],
		'error'    => [ 'err', 'Sorry, something went wrong sending your message. Please email info@leeroysystems.co.bw directly.' ],
	];
	$m = $messages[ sanitize_key( $_GET['status'] ) ] ?? null;
	if ( $m ) {
		echo '<div class="form-notice form-notice--' . esc_attr( $m[0] ) . '" role="status">' . esc_html( $m[1] ) . '</div>';
	}
}

function leeroy_form_captcha() {
	$keys = leeroy_recaptcha_keys();
	if ( $keys ) {
		echo '<div class="field field--full"><div class="g-recaptcha" data-sitekey="' . esc_attr( $keys['site'] ) . '"></div></div>';
	}
}
