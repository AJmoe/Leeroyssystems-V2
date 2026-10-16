<?php
/**
 * 404 page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/page-banner', null, [ 'title' => 'Page not found', 'image' => 'leeroy-systems-banner-2.jpg' ] );
?>
<section class="section">
	<div class="container notfound">
		<strong class="notfound__code">404</strong>
		<h2 class="section-title">We couldn't find that page.</h2>
		<p class="lead">It may have moved when we refreshed the site. Try one of these instead:</p>
		<div class="hero__actions">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to Home <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
			<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Contact Us</a>
		</div>
	</div>
</section>
<?php
get_footer();
