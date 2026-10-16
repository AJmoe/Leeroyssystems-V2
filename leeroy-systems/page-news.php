<?php
/**
 * News page (slug: news). Lists WordPress posts — write them in
 * wp-admin → Posts → Add New — beside our live Facebook feed.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/page-banner', null, [
	'title'   => 'News',
	'image'   => 'hq-leeroy.jpg',
	'eyebrow' => 'Latest from Leeroy Systems',
] );

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$news  = new WP_Query( [
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 9,
	'paged'               => $paged,
	'ignore_sticky_posts' => false,
	'post__not_in'        => leeroy_news_excluded(),
] );
$c = leeroy_contact();
?>

<section class="section news">
	<div class="container news__grid">
		<div class="news__main">
			<?php if ( $news->have_posts() ) : ?>
				<div class="news-list">
					<?php
					$i = 0;
					while ( $news->have_posts() ) :
						$news->the_post();
						$i++;
						$cats = get_the_category();
						?>
						<article <?php post_class( 'news-card' . ( 1 === $i && 1 === $paged ? ' news-card--lead' : '' ) ); ?> data-reveal>
							<a class="news-card__img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
								<img src="<?php echo esc_url( leeroy_post_cover( get_the_ID() ) ); ?>" alt="" loading="lazy">
								<?php if ( $cats ) : ?>
									<span class="news-card__cat"><?php echo esc_html( $cats[0]->name ); ?></span>
								<?php endif; ?>
							</a>
							<div class="news-card__body">
								<p class="news-card__meta"><?php echo leeroy_icon( 'calendar' ); ?><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><span>·</span><?php echo esc_html( leeroy_reading_time( get_the_ID() ) ); ?></p>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 1 === $i ? 40 : 22 ) ); ?></p>
								<a class="link-arrow" href="<?php the_permalink(); ?>">Read more <?php echo leeroy_icon( 'arrow-right' ); ?><span class="sr-only"> about <?php the_title(); ?></span></a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<?php if ( $news->max_num_pages > 1 ) : ?>
					<nav class="pager" aria-label="More news">
						<?php
						echo wp_kses_post( paginate_links( [
							'total'     => $news->max_num_pages,
							'current'   => $paged,
							'prev_text' => '← Newer',
							'next_text' => 'Older →',
						] ) );
						?>
					</nav>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<div class="news-empty">
					<span class="icon-box"><?php echo leeroy_icon( 'calendar' ); ?></span>
					<h2>News is on its way</h2>
					<p>Company news, project milestones and community stories will be published here. In the meantime, you can follow our latest updates on Facebook.</p>
					<a class="btn btn--primary" href="<?php echo esc_url( $c['facebook'] ); ?>" target="_blank" rel="noopener">Follow us on Facebook <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
				</div>
			<?php endif; ?>
		</div>

		<aside class="news__aside">
			<div class="widget">
				<h3 class="widget__title">Follow Leeroy Systems</h3>
				<div class="follow">
					<a href="<?php echo esc_url( $c['facebook'] ); ?>" target="_blank" rel="noopener"><?php echo leeroy_icon( 'facebook' ); ?>Facebook</a>
					<a href="<?php echo esc_url( $c['linkedin'] ); ?>" target="_blank" rel="noopener"><?php echo leeroy_icon( 'linkedin' ); ?>LinkedIn</a>
					<a href="<?php echo esc_url( $c['youtube'] ); ?>" target="_blank" rel="noopener"><?php echo leeroy_icon( 'youtube' ); ?>YouTube</a>
				</div>
			</div>
		</aside>
	</div>
</section>

<?php
get_footer();
