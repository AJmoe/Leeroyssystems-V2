<?php
/**
 * A single news post.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$c    = leeroy_contact();
	$cats = get_the_category();
	$url  = rawurlencode( get_permalink() );
	$text = rawurlencode( get_the_title() );
	get_template_part( 'template-parts/page-banner', null, [
		'title'        => get_the_title(),
		'image'        => 'hq-leeroy.jpg',
		'eyebrow'      => $cats ? $cats[0]->name : 'News',
		'parent_label' => 'News',
		'parent_url'   => leeroy_page_url( 'news' ),
	] );
	?>

	<section class="section post">
		<div class="container news__grid">
			<article class="post__main">
				<p class="news-card__meta"><?php echo leeroy_icon( 'calendar' ); ?><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><span>·</span><?php echo esc_html( leeroy_reading_time( get_the_ID() ) ); ?></p>
				<?php
				$meta     = has_post_thumbnail() ? wp_get_attachment_metadata( get_post_thumbnail_id() ) : [];
				$portrait = ! empty( $meta['width'] ) && $meta['height'] > $meta['width'];
				// Small images (e.g. social graphics) show at their natural size rather than stretched.
				$natural  = ! empty( $meta['width'] ) && ( $portrait || $meta['width'] < 760 );
				?>
				<figure class="post__cover<?php echo $natural ? ' post__cover--natural' : ''; ?>"<?php echo $natural ? ' style="max-width:' . (int) min( $meta['width'], $portrait ? 520 : 760 ) . 'px"' : ''; ?>><button type="button" class="post__cover-btn" data-lightbox="<?php echo esc_url( leeroy_post_cover( get_the_ID(), 'full' ) ); ?>" aria-label="View the photo full size"><img src="<?php echo esc_url( leeroy_post_cover( get_the_ID(), 'full' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></button></figure>
				<div class="prose post__content">
					<?php the_content(); ?>
				</div>

				<div class="post__share">
					<span>Share this story</span>
					<a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $url ); ?>" target="_blank" rel="noopener" aria-label="Share on Facebook"><?php echo leeroy_icon( 'facebook' ); ?></a>
					<a href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url ); ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><?php echo leeroy_icon( 'linkedin' ); ?></a>
					<a href="<?php echo esc_url( 'https://wa.me/?text=' . $text . '%20' . $url ); ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><?php echo leeroy_icon( 'phone' ); ?></a>
				</div>

				<nav class="post__nav" aria-label="More news">
					<?php
					$prev = get_previous_post();
					$next = get_next_post();
					// Never link to WordPress's sample post.
					if ( $prev && in_array( $prev->ID, leeroy_news_excluded(), true ) ) {
						$prev = null;
					}
					if ( $next && in_array( $next->ID, leeroy_news_excluded(), true ) ) {
						$next = null;
					}
					if ( $prev ) :
						?>
						<a class="post__nav-link" href="<?php echo esc_url( get_permalink( $prev ) ); ?>"><small>← Previous</small><strong><?php echo esc_html( get_the_title( $prev ) ); ?></strong></a>
					<?php endif; ?>
					<?php if ( $next ) : ?>
						<a class="post__nav-link post__nav-link--next" href="<?php echo esc_url( get_permalink( $next ) ); ?>"><small>Next →</small><strong><?php echo esc_html( get_the_title( $next ) ); ?></strong></a>
					<?php endif; ?>
				</nav>
				<a class="link-arrow" href="<?php echo esc_url( leeroy_page_url( 'news' ) ); ?>">All news <?php echo leeroy_icon( 'arrow-right' ); ?></a>
			</article>

			<aside class="news__aside">
				<?php
				$recent = new WP_Query( [
					'post_type'         => 'post',
					'posts_per_page'    => 4,
					'post__not_in'      => array_merge( [ get_the_ID() ], leeroy_news_excluded() ),
				] );
				if ( $recent->have_posts() ) :
					?>
					<div class="widget">
						<h3 class="widget__title">More news</h3>
						<ul class="recent">
							<?php
							while ( $recent->have_posts() ) :
								$recent->the_post();
								?>
								<li><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( leeroy_post_cover( get_the_ID(), 'thumbnail' ) ); ?>" alt="" loading="lazy"><span><strong><?php the_title(); ?></strong><small><?php echo esc_html( get_the_date() ); ?></small></span></a></li>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php
					wp_reset_postdata();
				endif;
				?>
			</aside>
		</div>
	</section>
	<?php
endwhile;

get_template_part( 'template-parts/lightbox' );
get_footer();
