<?php
/**
 * Fallback template (blog index, archives, single posts).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/page-banner', null, [
	'title' => is_search() ? sprintf( 'Search results for “%s”', get_search_query( false ) ) : ( is_singular() ? get_the_title() : wp_strip_all_tags( get_the_archive_title() ? get_the_archive_title() : 'News' ) ),
	'image' => 'leeroy-systems-banner-2.jpg',
] );
?>
<section class="section">
	<div class="container prose">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'entry' ); ?>>
					<?php if ( ! is_singular() ) : ?>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="entry__meta"><?php echo esc_html( get_the_date() ); ?></p>
						<?php the_excerpt(); ?>
					<?php else : ?>
						<?php the_content(); ?>
					<?php endif; ?>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<?php if ( is_search() ) : ?>
				<p>No results for &ldquo;<?php echo esc_html( get_search_query() ); ?>&rdquo;. Try different words, or browse our <a href="<?php echo esc_url( leeroy_page_url( 'news' ) ); ?>">latest news</a>.</p>
				<?php get_search_form(); ?>
			<?php else : ?>
				<p>There are no stories here yet. See our <a href="<?php echo esc_url( leeroy_page_url( 'news' ) ); ?>">latest news</a>.</p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
