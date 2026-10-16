<?php
/**
 * Site footer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c    = leeroy_contact();
$home = home_url( '/' );
?>
</main>

<footer class="footer">
	<div class="container">
		<div class="footer__cta">
			<div>
				<span class="eyebrow eyebrow--light">Futuristic Solutions</span>
				<h2>Ready to modernise your water infrastructure? Let's talk.</h2>
			</div>
			<div class="footer__cta-actions">
				<a class="btn btn--light" href="<?php echo esc_url( $home . '#contact' ); ?>">Talk to Our Team <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
				<a class="footer__cta-call" href="tel:<?php echo esc_attr( $c['tel'] ); ?>"><?php echo leeroy_icon( 'phone' ); ?><?php echo esc_html( $c['phone'] ); ?></a>
			</div>
		</div>

		<div class="footer__grid">
			<div class="footer__about">
				<a href="<?php echo esc_url( $home ); ?>" class="footer__logo"><img src="<?php echo esc_url( leeroy_img( 'leeroy-logo-white.png' ) ); ?>" alt="Leeroy Systems" width="320" height="237" loading="lazy"></a>
				<p>A pioneer of smart prepaid water metering in Africa — Metering-as-a-Service, IoT smart meters, data intelligence and open multi-utility vending.</p>
				<div class="social social--footer">
					<a href="<?php echo esc_url( $c['facebook'] ); ?>" aria-label="Facebook" target="_blank" rel="noopener"><?php echo leeroy_icon( 'facebook' ); ?></a>
					<a href="<?php echo esc_url( $c['linkedin'] ); ?>" aria-label="LinkedIn" target="_blank" rel="noopener"><?php echo leeroy_icon( 'linkedin' ); ?></a>
					<a href="<?php echo esc_url( $c['youtube'] ); ?>" aria-label="YouTube" target="_blank" rel="noopener"><?php echo leeroy_icon( 'youtube' ); ?></a>
				</div>
			</div>

			<div>
				<h3 class="footer__title">Quick Links</h3>
				<ul class="footer__links">
					<li><a href="<?php echo esc_url( $home . '#about' ); ?>">About Us</a></li>
					<li><a href="<?php echo esc_url( $home . '#projects' ); ?>">Projects</a></li>
					<li><a href="<?php echo esc_url( leeroy_page_url( 'news' ) ); ?>">News</a></li>
					<li><a href="<?php echo esc_url( leeroy_page_url( 'gallery' ) ); ?>">Gallery</a></li>
					<li><a href="<?php echo esc_url( leeroy_page_url( 'community' ) ); ?>">Community</a></li>
					<li><a href="<?php echo esc_url( leeroy_page_url( 'careers' ) ); ?>">Careers</a></li>
					<li><a href="<?php echo esc_url( $home . '#contact' ); ?>">Contact</a></li>
				</ul>
			</div>

			<div>
				<h3 class="footer__title">Our Services</h3>
				<ul class="footer__links">
					<?php foreach ( leeroy_services() as $s_slug => $s ) : ?>
						<li><a href="<?php echo esc_url( leeroy_page_url( $s_slug ) ); ?>"><?php echo esc_html( $s['title'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div>
				<h3 class="footer__title">Contact Us</h3>
				<ul class="footer__contact">
					<li><?php echo leeroy_icon( 'pin' ); ?><span>Plot 176, Gaborone International Commerce Park.<br>Gaborone, Botswana</span></li>
					<li><?php echo leeroy_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></li>
					<li><?php echo leeroy_icon( 'phone' ); ?><span><a href="tel:<?php echo esc_attr( $c['tel'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a><br><?php echo esc_html( implode( ' / ', $c['mobiles'] ) ); ?></span></li>
					<li><?php echo leeroy_icon( 'clock' ); ?><span><?php echo esc_html( $c['hours'] ); ?> (CAT)</span></li>
				</ul>
				<div class="footer__affiliations">
					<?php foreach ( [ 'SWAN' => 'swan.png', 'Brand Botswana' => 'brand-botswana.png', 'LEA' => 'lea.png' ] as $name => $logo ) : ?>
						<span><img src="<?php echo esc_url( leeroy_img( 'partners/' . $logo ) ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy"></span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="footer__bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Hitong Holdings (Pty) Ltd T/A Leeroy Systems. All rights reserved.</p>
			<p><a href="https://ajmoe.github.io/Nexora-Synth/" target="_blank" rel="noopener noreferrer">Website by Nexora Synth</a></p>
		</div>
	</div>
</footer>

<button class="to-top" type="button" aria-label="Back to top" data-to-top><?php echo leeroy_icon( 'arrow-right' ); ?></button>

<?php wp_footer(); ?>
</body>
</html>
