<?php
/**
 * Inner-page banner with breadcrumb.
 *
 * @var array $args { title, image, eyebrow?, parent_label?, parent_url? }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="page-banner" style="--banner: url('<?php echo esc_url( leeroy_img( $args['image'] ) ); ?>')">
	<div class="container page-banner__inner">
		<?php if ( ! empty( $args['eyebrow'] ) ) : ?>
			<span class="eyebrow eyebrow--light"><?php echo esc_html( $args['eyebrow'] ); ?></span>
		<?php endif; ?>
		<h1><?php echo esc_html( $args['title'] ); ?></h1>
		<nav class="breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
			<?php if ( ! empty( $args['parent_label'] ) ) : ?>
				<?php echo leeroy_icon( 'chevron-right' ); ?>
				<a href="<?php echo esc_url( $args['parent_url'] ); ?>"><?php echo esc_html( $args['parent_label'] ); ?></a>
			<?php endif; ?>
			<?php echo leeroy_icon( 'chevron-right' ); ?>
			<span aria-current="page"><?php echo esc_html( $args['title'] ); ?></span>
		</nav>
	</div>
</section>
