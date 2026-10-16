<?php
/**
 * Partner / affiliate logo marquee.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$partners = leeroy_partners();
?>
<section class="partners" aria-label="Strategic partners and affiliates">
	<div class="container">
		<p class="partners__title">Strategic partners &amp; affiliates</p>
	</div>
	<div class="marquee">
		<div class="marquee__track">
			<?php for ( $loop = 0; $loop < 2; $loop++ ) : ?>
				<?php foreach ( $partners as $name => $logo ) : ?>
					<div class="marquee__item" <?php echo $loop ? 'aria-hidden="true"' : ''; ?>>
						<img src="<?php echo esc_url( leeroy_img( 'partners/' . $logo ) ); ?>" alt="<?php echo $loop ? '' : esc_attr( $name ); ?>" loading="lazy">
					</div>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>
</section>
