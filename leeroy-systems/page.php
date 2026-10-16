<?php
/**
 * Pages. Service and project pages are rendered from inc/data.php by
 * slug; any other page falls back to its normal editor content.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug     = leeroy_current_slug();
$services = leeroy_services();
$projects = leeroy_projects();

if ( isset( $services[ $slug ] ) ) {
	get_template_part( 'template-parts/detail', null, [ 'kind' => 'service', 'slug' => $slug, 'item' => $services[ $slug ] ] );
	return;
}
if ( isset( $projects[ $slug ] ) ) {
	get_template_part( 'template-parts/detail', null, [ 'kind' => 'project', 'slug' => $slug, 'item' => $projects[ $slug ] ] );
	return;
}

get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-banner', null, [ 'title' => get_the_title(), 'image' => 'leeroy-systems-banner-2.jpg' ] );
	?>
	<section class="section">
		<div class="container prose">
			<?php the_content(); ?>
		</div>
	</section>
	<?php
endwhile;
get_footer();
