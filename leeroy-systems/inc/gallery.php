<?php
/**
 * Photo Gallery.
 *
 * Albums are a taxonomy on Media Library photos ("Albums", under Media in
 * wp-admin). Top-level albums are the gallery categories (folders); albums
 * nested under them hold the photos. Each photo's Title is shown under it on
 * the album page, so managing the gallery is just: upload, title, tick album.
 *
 * Starter albums are created once in the background from the bundled news
 * stories and the Community page photo sets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LEEROY_ALBUM_TAX', 'leeroy_album' );
define( 'LEEROY_GALLERY_SEED_VERSION', '1' );

/** The gallery categories (top-level folders), in display order. */
function leeroy_gallery_categories(): array {
	return [
		'events-visits'      => [ 'name' => 'Events & visits', 'description' => 'Visits, dialogues, partnerships and industry events.' ],
		'life-at-leeroy'     => [ 'name' => 'Life at Leeroy', 'description' => 'Team culture, celebrations and wellness.' ],
		'training'           => [ 'name' => 'Training', 'description' => 'Customer care and Kaizen training sessions.' ],
		'community-outreach' => [ 'name' => 'Community outreach', 'description' => 'Sponsorships, sport and giving back.' ],
	];
}

add_action( 'init', function () {
	register_taxonomy( LEEROY_ALBUM_TAX, 'attachment', [
		'labels'                => [
			'name'          => 'Albums',
			'singular_name' => 'Album',
			'menu_name'     => 'Albums',
			'all_items'     => 'All albums',
			'edit_item'     => 'Edit album',
			'add_new_item'  => 'Add new album',
			'parent_item'   => 'Gallery category',
			'search_items'  => 'Search albums',
		],
		'description'           => 'Photo albums shown on the Gallery page. Top-level albums are gallery categories; put photo albums inside them.',
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'hierarchical'          => true,
		'rewrite'               => false,
		'update_count_callback' => '_update_generic_term_count',
	] );
}, 5 );

/* -------------------------------------------------------------------------
 * Reading albums
 * ---------------------------------------------------------------------- */

/** Photos in an album (attachment posts), oldest first. */
function leeroy_album_photos( int $term_id ): array {
	return get_posts( [
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'post_mime_type' => 'image',
		'posts_per_page' => -1,
		'orderby'        => [ 'menu_order' => 'ASC', 'date' => 'ASC', 'ID' => 'ASC' ],
		'tax_query'      => [ [ 'taxonomy' => LEEROY_ALBUM_TAX, 'field' => 'term_id', 'terms' => $term_id, 'include_children' => false ] ],
	] );
}

/** Album summary used by the gallery page. */
function leeroy_album_card( WP_Term $term ): ?array {
	$photos = leeroy_album_photos( $term->term_id );
	if ( ! $photos ) {
		return null;
	}
	$cover = (int) get_term_meta( $term->term_id, 'leeroy_cover', true );
	if ( ! $cover || ! wp_get_attachment_image_url( $cover ) ) {
		$cover = $photos[0]->ID;
	}
	return [
		'term'   => $term,
		'photos' => $photos,
		'count'  => count( $photos ),
		'cover'  => wp_get_attachment_image_url( $cover, 'medium_large' ),
		'date'   => (string) get_term_meta( $term->term_id, 'leeroy_date', true ),
		'post'   => (int) get_term_meta( $term->term_id, 'leeroy_post', true ),
	];
}

/** All gallery categories with their albums (newest album first). */
function leeroy_gallery_tree(): array {
	$tree = [];
	foreach ( leeroy_gallery_categories() as $slug => $cat ) {
		$parent = get_term_by( 'slug', $slug, LEEROY_ALBUM_TAX );
		if ( ! $parent ) {
			continue;
		}
		$albums = [];
		foreach ( get_terms( [ 'taxonomy' => LEEROY_ALBUM_TAX, 'parent' => $parent->term_id, 'hide_empty' => false ] ) as $term ) {
			$card = leeroy_album_card( $term );
			if ( $card ) {
				$albums[] = $card;
			}
		}
		usort( $albums, function ( $a, $b ) {
			return strcmp( $b['date'] ?: '0000', $a['date'] ?: '0000' ) ?: strcmp( $a['term']->name, $b['term']->name );
		} );
		if ( $albums ) {
			$tree[] = [ 'slug' => $slug, 'name' => $parent->name, 'description' => $parent->description ?: $cat['description'], 'albums' => $albums ];
		}
	}
	// Albums an admin created at the top level (no category) still show.
	$loose = [];
	foreach ( get_terms( [ 'taxonomy' => LEEROY_ALBUM_TAX, 'parent' => 0, 'hide_empty' => false ] ) as $term ) {
		if ( ! isset( leeroy_gallery_categories()[ $term->slug ] ) ) {
			$card = leeroy_album_card( $term );
			if ( $card ) {
				$loose[] = $card;
			}
		}
	}
	if ( $loose ) {
		$tree[] = [ 'slug' => 'more', 'name' => 'More albums', 'description' => '', 'albums' => $loose ];
	}
	return $tree;
}

/* -------------------------------------------------------------------------
 * Starter albums (background, a few at a time)
 * ---------------------------------------------------------------------- */

/** Make sure the four categories exist; return slug => term_id. */
function leeroy_gallery_ensure_categories(): array {
	$ids = [];
	foreach ( leeroy_gallery_categories() as $slug => $cat ) {
		$term = get_term_by( 'slug', $slug, LEEROY_ALBUM_TAX );
		if ( ! $term ) {
			$new = wp_insert_term( $cat['name'], LEEROY_ALBUM_TAX, [ 'slug' => $slug, 'description' => $cat['description'] ] );
			$ids[ $slug ] = is_wp_error( $new ) ? 0 : (int) $new['term_id'];
		} else {
			$ids[ $slug ] = (int) $term->term_id;
		}
	}
	return $ids;
}

/** Create (or find) an album under a category. */
function leeroy_gallery_album( string $name, string $slug, string $category, array $meta = [] ): int {
	$cats = leeroy_gallery_ensure_categories();
	$term = get_term_by( 'slug', $slug, LEEROY_ALBUM_TAX );
	if ( $term ) {
		return (int) $term->term_id;
	}
	$new = wp_insert_term( $name, LEEROY_ALBUM_TAX, [ 'slug' => $slug, 'parent' => $cats[ $category ] ?? 0, 'description' => $meta['description'] ?? '' ] );
	if ( is_wp_error( $new ) ) {
		return 0;
	}
	foreach ( [ 'date', 'post' ] as $key ) {
		if ( ! empty( $meta[ $key ] ) ) {
			update_term_meta( $new['term_id'], 'leeroy_' . $key, $meta[ $key ] );
		}
	}
	return (int) $new['term_id'];
}

/** Which gallery category each bundled news story belongs to. */
function leeroy_gallery_news_map(): array {
	return [
		'lea-board-of-directors-visits-leeroy-systems'     => 'events-visits',
		'wellness-in-action-team-climbs-nyangabgwe-hill'   => 'life-at-leeroy',
		'boipuso-botswana-60-years-of-independence'        => 'life-at-leeroy',
		'water-futures-dialogue-smart-water-infrastructure' => 'events-visits',
		'hosting-gs1-namibia-at-leeroy-systems'            => 'events-visits',
		'proud-sponsor-of-the-next-chapter-cup'            => 'community-outreach',
	];
}

/** Turn a news story's photos into an album (stories with 2+ photos). */
function leeroy_gallery_album_from_post( int $post_id ): bool {
	$post = get_post( $post_id );
	$map  = leeroy_gallery_news_map();
	if ( ! $post || ! isset( $map[ $post->post_name ] ) ) {
		return false;
	}
	$photos = get_attached_media( 'image', $post_id );
	if ( count( $photos ) < 2 ) {
		return false;
	}
	$album = leeroy_gallery_album( $post->post_title, 'news-' . $post->post_name, $map[ $post->post_name ], [
		'date'        => get_the_date( 'Y-m-d', $post ),
		'post'        => $post_id,
		'description' => get_the_excerpt( $post ),
	] );
	foreach ( $photos as $photo ) {
		wp_set_object_terms( $photo->ID, $album, LEEROY_ALBUM_TAX, true );
	}
	$thumb = get_post_thumbnail_id( $post_id );
	if ( $thumb ) {
		update_term_meta( $album, 'leeroy_cover', $thumb );
	}
	return true;
}

/** Community page photo sets → albums. */
function leeroy_gallery_story_jobs(): array {
	$map  = [ 'life' => 'life-at-leeroy', 'training' => 'training', 'outreach' => 'community-outreach' ];
	$date = [
		'Christmas Party'                  => '2025-12-01',
		'Kaizen Training – Session 2 of 5' => '2025-12-15',
	];
	$jobs = [];
	foreach ( leeroy_stories() as $group => $g ) {
		foreach ( $g['items'] as $story ) {
			$jobs[] = [
				'name'     => $story['title'],
				'slug'     => 'story-' . sanitize_title( $story['title'] ),
				'category' => $map[ $group ],
				'text'     => $story['text'],
				'photos'   => $story['photos'],
				'date'     => $date[ $story['title'] ] ?? '',
				'cover'    => [ 'Christmas Party' => 'christmaspart2025-01.jpg' ][ $story['title'] ] ?? '',
			];
		}
	}
	return $jobs;
}

function leeroy_gallery_import_story_album( array $job ): void {
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$album = leeroy_gallery_album( $job['name'], $job['slug'], $job['category'], [ 'date' => $job['date'], 'description' => $job['text'] ] );
	if ( ! $album || leeroy_album_photos( $album ) ) {
		return; // Already imported.
	}
	foreach ( array_values( $job['photos'] ) as $i => $file ) {
		$path = get_template_directory() . '/assets/img/' . $file;
		$tmp  = wp_tempnam( $file );
		if ( ! is_file( $path ) || ! $tmp || ! copy( $path, $tmp ) ) {
			continue;
		}
		$title = $job['name'] . ' — photo ' . ( $i + 1 );
		$att   = media_handle_sideload( [ 'name' => $job['slug'] . '-' . basename( $file ), 'tmp_name' => $tmp ], 0, $title );
		if ( is_wp_error( $att ) ) {
			wp_delete_file( $tmp );
			continue;
		}
		wp_update_post( [ 'ID' => $att, 'menu_order' => $i ] );
		update_post_meta( $att, '_wp_attachment_image_alt', $title );
		wp_set_object_terms( $att, $album, LEEROY_ALBUM_TAX, true );
		if ( ! empty( $job['cover'] ) && $job['cover'] === $file ) {
			update_term_meta( $album, 'leeroy_cover', $att );
		}
	}
}

add_action( 'init', function () {
	if ( get_option( 'leeroy_gallery_seed_version' ) !== LEEROY_GALLERY_SEED_VERSION && ! wp_next_scheduled( 'leeroy_gallery_seed' ) ) {
		wp_schedule_single_event( time() + 5, 'leeroy_gallery_seed' );
	}
}, 30 );
add_action( 'leeroy_gallery_seed', 'leeroy_gallery_seed_step' );

/**
 * One step of the starter-album import. Processes one community photo set per
 * run (they are the slow part) and re-schedules itself until finished.
 */
function leeroy_gallery_seed_step(): void {
	if ( get_option( 'leeroy_gallery_seed_version' ) === LEEROY_GALLERY_SEED_VERSION ) {
		return;
	}
	leeroy_gallery_ensure_categories();

	// News-story albums are quick (photos are already in the Media Library).
	foreach ( (array) get_option( 'leeroy_news_seeded', [] ) as $slug ) {
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( $post ) {
			leeroy_gallery_album_from_post( $post->ID );
		}
	}

	$done = (array) get_option( 'leeroy_gallery_seed_done', [] );
	foreach ( leeroy_gallery_story_jobs() as $job ) {
		if ( in_array( $job['slug'], $done, true ) ) {
			continue;
		}
		leeroy_gallery_import_story_album( $job );
		$done[] = $job['slug'];
		update_option( 'leeroy_gallery_seed_done', $done, false );
		wp_schedule_single_event( time() + 2, 'leeroy_gallery_seed' );
		return; // One photo set per run.
	}
	update_option( 'leeroy_gallery_seed_version', LEEROY_GALLERY_SEED_VERSION );
}
