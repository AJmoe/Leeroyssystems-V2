<?php
/**
 * Contact section: tabbed inquiry forms + office cards.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c      = leeroy_contact();
$action = esc_url( admin_url( 'admin-post.php' ) );
$active = isset( $_GET['form'] ) ? sanitize_key( $_GET['form'] ) : 'personal';
if ( ! in_array( $active, [ 'personal', 'business', 'sponsorship' ], true ) ) {
	$active = 'personal';
}
$tabs = [
	'personal'    => [ 'For Me', 'Questions about your meter, plot or prepaid water supply? We\'ll get back to you within 24 hours.' ],
	'business'    => [ 'Business / Private', 'Fill in the form and one of our specialists will get back to you within 24 hours.' ],
	'sponsorship' => [ 'Sponsorship & Marketing', 'Interested in partnering with or sponsoring a Leeroy Systems initiative? Tell us more below.' ],
];
?>
<section class="section contact" id="contact">
	<div class="container contact__grid">
		<div class="contact__intro">
			<span class="eyebrow">Get in touch</span>
			<h2 class="section-title">Let's talk about your water metering needs</h2>
			<p class="lead">Our team is ready to help you design, deploy and manage a smarter water infrastructure for your community.</p>

			<ul class="contact__quick">
				<li>
					<span class="icon-box"><?php echo leeroy_icon( 'phone' ); ?></span>
					<div><small>Call us now</small><a href="tel:<?php echo esc_attr( $c['tel'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a></div>
				</li>
				<li>
					<span class="icon-box"><?php echo leeroy_icon( 'mail' ); ?></span>
					<div><small>Send an email</small><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></div>
				</li>
				<li>
					<span class="icon-box"><?php echo leeroy_icon( 'pin' ); ?></span>
					<div><small>Head office &middot; <?php echo esc_html( $c['hours'] ); ?></small><span>Plot 176, Gaborone International Commerce Park</span></div>
				</li>
			</ul>
		</div>

		<div class="form-card" data-tabs>
			<div class="tabs" role="tablist" aria-label="Inquiry type">
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<button class="tabs__btn <?php echo $key === $active ? 'is-active' : ''; ?>" type="button" role="tab" id="tab-<?php echo esc_attr( $key ); ?>" aria-controls="panel-<?php echo esc_attr( $key ); ?>" aria-selected="<?php echo $key === $active ? 'true' : 'false'; ?>"><?php echo esc_html( $tab[0] ); ?></button>
				<?php endforeach; ?>
			</div>

			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="tabs__panel" role="tabpanel" id="panel-<?php echo esc_attr( $key ); ?>" aria-labelledby="tab-<?php echo esc_attr( $key ); ?>" <?php echo $key === $active ? '' : 'hidden'; ?>>
					<p class="form-card__intro"><?php echo esc_html( $tab[1] ); ?></p>
					<?php leeroy_form_notice( $key ); ?>
					<form class="form" method="post" action="<?php echo $action; ?>">
						<?php leeroy_form_open( $key ); ?>

						<?php if ( 'personal' === $key ) : ?>
							<div class="field field--full"><label for="p-name">Full name *</label><input id="p-name" name="name" type="text" autocomplete="name" required></div>
							<fieldset class="field field--full">
								<legend>Preferred contact method</legend>
								<div class="radio-row">
									<label class="radio"><input type="radio" name="contact_pref" value="email" checked> Email</label>
									<label class="radio"><input type="radio" name="contact_pref" value="phone"> Phone</label>
								</div>
							</fieldset>
							<div class="field"><label for="p-email">Email</label><input id="p-email" name="email" type="email" autocomplete="email" placeholder="Your email address"></div>
							<div class="field"><label for="p-phone">Phone</label><input id="p-phone" name="phone" type="tel" autocomplete="tel" placeholder="Your phone number"></div>
							<div class="field"><label for="p-plot">Plot number</label><input id="p-plot" name="plot_number" type="text"></div>
							<div class="field"><label for="p-meter">Meter number</label><input id="p-meter" name="meter_number" type="text"></div>
							<div class="field field--full"><label for="p-query">Your query *</label><textarea id="p-query" name="query" rows="4" required placeholder="Explain in detail how we can help you..."></textarea></div>
							<?php leeroy_form_captcha(); ?>
							<div class="field field--full"><button class="btn btn--primary" type="submit">Send Inquiry <?php echo leeroy_icon( 'arrow-up-right' ); ?></button></div>

						<?php elseif ( 'business' === $key ) : ?>
							<div class="field"><label for="b-name">Full name *</label><input id="b-name" name="name" type="text" autocomplete="name" required></div>
							<div class="field"><label for="b-email">Email *</label><input id="b-email" name="email" type="email" autocomplete="email" required></div>
							<div class="field"><label for="b-phone">Phone</label><input id="b-phone" name="phone" type="tel" autocomplete="tel"></div>
							<div class="field"><label for="b-org">Organisation</label><input id="b-org" name="organisation" type="text" autocomplete="organization"></div>
							<div class="field field--full"><label for="b-type">Inquiry type</label>
								<select id="b-type" name="inquiry_type">
									<option>General Inquiry</option><option>Meter Installation</option><option>Service &amp; Support</option><option>Pricing &amp; Quotation</option>
								</select>
							</div>
							<div class="field field--full"><label for="b-msg">Message *</label><textarea id="b-msg" name="message" rows="4" required placeholder="Tell us about your project or requirements..."></textarea></div>
							<?php leeroy_form_captcha(); ?>
							<div class="field field--full"><button class="btn btn--primary" type="submit">Send Inquiry <?php echo leeroy_icon( 'arrow-up-right' ); ?></button></div>

						<?php else : ?>
							<div class="field"><label for="s-name">Full name *</label><input id="s-name" name="name" type="text" autocomplete="name" required></div>
							<div class="field"><label for="s-org">Organisation</label><input id="s-org" name="organisation" type="text" autocomplete="organization"></div>
							<div class="field"><label for="s-email">Email *</label><input id="s-email" name="email" type="email" autocomplete="email" required></div>
							<div class="field"><label for="s-phone">Phone</label><input id="s-phone" name="phone" type="tel" autocomplete="tel"></div>
							<div class="field"><label for="s-type">Request type *</label>
								<select id="s-type" name="request_type" required><option value="">Select…</option><option>Sponsorship</option><option>Partnership</option></select>
							</div>
							<div class="field"><label for="s-proj">Initiative / campaign</label><input id="s-proj" name="project_name" type="text" placeholder="Name of your initiative or campaign"></div>
							<div class="field field--full"><label for="s-msg">Message *</label><textarea id="s-msg" name="message" rows="4" required placeholder="Tell us about your proposal and what you are looking for..."></textarea></div>
							<?php leeroy_form_captcha(); ?>
							<div class="field field--full"><button class="btn btn--primary" type="submit">Send Proposal <?php echo leeroy_icon( 'arrow-up-right' ); ?></button></div>
						<?php endif; ?>
					</form>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="container offices">
		<div class="section-head section-head--center">
			<span class="eyebrow">Our offices</span>
			<h2 class="section-title">Find us across Botswana and Beyond</h2>
		</div>
		<?php get_template_part( 'template-parts/office-map' ); ?>
	</div>
</section>
