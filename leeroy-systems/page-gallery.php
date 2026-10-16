<?php
/**
 * Gallery page (slug: gallery). Album folders grouped by category; an album
 * opens at /gallery/?album=<slug>. Manage photos in wp-admin → Media.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$album_slug = isset( $_GET['album'] ) ? sanitize_title( wp_unslash( $_GET['album'] ) ) : '';
$album      = $album_slug ? get_term_by( 'slug', $album_slug, LEEROY_ALBUM_TAX ) : null;
$card       = $album ? leeroy_album_card( $album ) : null;

get_header();

if ( $card ) :
	$parent = $album->parent ? get_term( $album->parent, LEEROY_ALBUM_TAX ) : null;
	get_template_part( 'template-parts/page-banner', null, [
		'title'        => $album->name,
		'image'        => 'hq-leeroy.jpg',
		'eyebrow'      => $parent && ! is_wp_error( $parent ) ? $parent->name : 'Gallery',
		'parent_label' => 'Gallery',
		'parent_url'   => leeroy_page_url( 'gallery' ),
	] );
	?>
	<section class="section album">
		<div class="container">
			<div class="album__head">
				<div>
					<p class="album__meta">
						<?php echo leeroy_icon( 'camera' ); ?><?php echo (int) $card['count']; ?> photos
						<?php if ( $card['date'] ) : ?>
							<span>·</span><?php echo leeroy_icon( 'calendar' ); ?><?php echo esc_html( wp_date( 'j F Y', strtotime( $card['date'] ) ) ); ?>
						<?php endif; ?>
					</p>
					<?php if ( $album->description ) : ?>
						<p class="album__desc"><?php echo esc_html( $album->description ); ?></p>
					<?php endif; ?>
				</div>
				<div class="album__actions">
					<?php if ( $card['post'] && 'publish' === get_post_status( $card['post'] ) ) : ?>
						<a class="btn btn--primary" href="<?php echo esc_url( get_permalink( $card['post'] ) ); ?>">Read the story <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
					<?php endif; ?>
					<a class="btn btn--outline" href="<?php echo esc_url( leeroy_page_url( 'gallery' ) ); ?>"><?php echo leeroy_icon( 'chevron-left' ); ?> All albums</a>
				</div>
			</div>

			<div class="photo-grid" data-gallery-group>
				<?php foreach ( $card['photos'] as $photo ) :
					$title = get_the_title( $photo );
					?>
					<figure class="photo" data-reveal>
						<button type="button" class="photo__btn" data-lightbox="<?php echo esc_url( wp_get_attachment_image_url( $photo->ID, 'full' ) ); ?>" data-title="<?php echo esc_attr( $title ); ?>" aria-label="View larger: <?php echo esc_attr( $title ); ?>">
							<?php echo wp_get_attachment_image( $photo->ID, 'medium_large', false, [ 'loading' => 'lazy', 'alt' => esc_attr( get_post_meta( $photo->ID, '_wp_attachment_image_alt', true ) ?: $title ) ] ); ?>
						</button>
						<figcaption><?php echo esc_html( $title ); ?></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
else :
	get_template_part( 'template-parts/page-banner', null, [
		'title'   => 'Gallery',
		'image'   => 'hq-leeroy.jpg',
		'eyebrow' => 'Moments from the field and the floor',
	] );
	$tree = leeroy_gallery_tree();
	?>
	<section class="section gallery-page">
		<div class="container">
			<?php if ( $album_slug ) : ?>
				<div class="form-notice form-notice--err">That album couldn’t be found — here are all our albums.</div>
			<?php endif; ?>

			<?php if ( $tree ) : ?>
				<div class="filter" data-filter role="tablist" aria-label="Gallery category">
					<button type="button" class="filter__btn is-active" data-filter-value="all" role="tab" aria-selected="true">All albums</button>
					<?php foreach ( $tree as $cat ) : ?>
						<button type="button" class="filter__btn" data-filter-value="<?php echo esc_attr( $cat['slug'] ); ?>" role="tab" aria-selected="false"><?php echo esc_html( $cat['name'] ); ?> <span class="filter__count"><?php echo count( $cat['albums'] ); ?></span></button>
					<?php endforeach; ?>
				</div>

				<?php foreach ( $tree as $cat ) : ?>
					<div class="story-group" data-filter-group="<?php echo esc_attr( $cat['slug'] ); ?>">
						<div class="story-group__head">
							<h2><?php echo leeroy_icon( 'camera' ); ?><?php echo esc_html( $cat['name'] ); ?></h2>
							<?php if ( $cat['description'] ) : ?>
								<p><?php echo esc_html( $cat['description'] ); ?></p>
							<?php endif; ?>
						</div>
						<div class="folder-grid">
							<?php foreach ( $cat['albums'] as $a ) : ?>
								<a class="folder" href="<?php echo esc_url( add_query_arg( 'album', $a['term']->slug, leeroy_page_url( 'gallery' ) ) ); ?>" data-reveal>
									<span class="folder__tab" aria-hidden="true"></span>
									<span class="folder__img"><img src="<?php echo esc_url( $a['cover'] ); ?>" alt="" loading="lazy"></span>
									<span class="folder__body">
										<strong><?php echo esc_html( $a['term']->name ); ?></strong>
										<small><?php echo leeroy_icon( 'camera' ); ?><?php echo (int) $a['count']; ?> photos<?php echo $a['date'] ? ' · ' . esc_html( wp_date( 'M Y', strtotime( $a['date'] ) ) ) : ''; ?></small>
									</span>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="news-empty">
					<span class="icon-box"><?php echo leeroy_icon( 'camera' ); ?></span>
					<h2>Our gallery is being set up</h2>
					<p>Photo albums from our projects, events and community work will appear here shortly.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
endif;

get_template_part( 'template-parts/lightbox' );
get_footer();
