<?php
/**
 * Careers page (slug: careers).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/page-banner', null, [
	'title'   => 'Careers',
	'image'   => 'team.jpg',
	'eyebrow' => 'Join our team',
] );

$reasons = [
	[ 'icon' => 'growth', 'title' => 'Career Growth', 'text' => 'We invest in our people through training, mentorship and clear paths for advancement.' ],
	[ 'icon' => 'flag', 'title' => 'A Home-Grown Champion', 'text' => 'Join a Brand Botswana-endorsed company that is taking smart water management from Botswana to the world.' ],
	[ 'icon' => 'pin', 'title' => 'Nationwide Presence', 'text' => 'Work across our three offices in Gaborone, Francistown and Palapye.' ],
	[ 'icon' => 'heart', 'title' => 'Meaningful Work', 'text' => 'Every role contributes to smarter water infrastructure for communities across Botswana.' ],
];
?>

<section class="section openings">
	<div class="container openings__grid">
		<div data-reveal>
			<span class="eyebrow">Current openings</span>
			<h2 class="section-title">Positions available.</h2>
		</div>
		<div class="empty-state" data-reveal>
			<span class="icon-box"><?php echo leeroy_icon( 'briefcase' ); ?></span>
			<div>
				<h3>No vacancies at the moment</h3>
				<p>We don't have any open positions right now but we're always interested in talented people. Submit your CV below and we'll be in touch when something comes up.</p>
				<a class="link-arrow" href="#apply">Submit your CV <?php echo leeroy_icon( 'arrow-right' ); ?></a>
			</div>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="container">
		<div class="section-head section-head--center">
			<span class="eyebrow">Why join us</span>
			<h2 class="section-title">More than just a job.</h2>
		</div>
		<div class="reasons">
			<?php foreach ( $reasons as $r ) : ?>
				<article class="reason" data-reveal>
					<span class="feature__icon"><?php echo leeroy_icon( $r['icon'] ); ?></span>
					<h3><?php echo esc_html( $r['title'] ); ?></h3>
					<p><?php echo esc_html( $r['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="section-head section-head--center">
			<span class="eyebrow">Our team</span>
			<h2 class="section-title">The people behind the work.</h2>
		</div>
		<div class="team-mosaic" data-gallery-group>
			<?php foreach ( [ 'team.jpg' => 'Leeroy Systems team at the operations centre', 'ab-us1.jpg' => 'Customer engagement at a Leeroy Systems stand', 'ab-us.jpg' => 'Team at a community activation', 'ab01.jpg' => 'Leeroy Systems staff member', 'ab04.jpg' => 'Team collaboration session' ] as $img => $alt ) : ?>
				<button type="button" class="team-mosaic__item" data-lightbox="<?php echo esc_url( leeroy_img( $img ) ); ?>" aria-label="Enlarge photo: <?php echo esc_attr( $alt ); ?>">
					<img src="<?php echo esc_url( leeroy_img( $img ) ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
				</button>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--navy apply" id="apply">
	<div class="container apply__grid">
		<div>
			<span class="eyebrow eyebrow--light">Join our team</span>
			<h2 class="section-title">Submit your application</h2>
			<p class="lead">Fill in the form below and attach your CV. We will review your application and get back to you.</p>
			<ul class="checklist checklist--light">
				<li><?php echo leeroy_icon( 'check-circle' ); ?>PDF, DOC or DOCX — up to 5 MB</li>
				<li><?php echo leeroy_icon( 'check-circle' ); ?>Applications go straight to our HR inbox</li>
				<li><?php echo leeroy_icon( 'check-circle' ); ?>We keep your CV on file for future roles</li>
			</ul>
		</div>
		<div class="form-card">
			<h3 class="form-card__title">Application form</h3>
			<?php leeroy_form_notice( 'careers' ); ?>
			<form class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<?php leeroy_form_open( 'careers' ); ?>
				<div class="field"><label for="c-name">Full name *</label><input id="c-name" name="name" type="text" autocomplete="name" required></div>
				<div class="field"><label for="c-email">Email *</label><input id="c-email" name="email" type="email" autocomplete="email" required></div>
				<div class="field"><label for="c-phone">Phone</label><input id="c-phone" name="phone" type="tel" autocomplete="tel"></div>
				<div class="field"><label for="c-pos">Position *</label><select id="c-pos" name="position" required><option>General Application</option></select></div>
				<div class="field field--full"><label for="c-cover">Cover note</label><textarea id="c-cover" name="cover" rows="4" placeholder="Tell us about yourself and why you want to join Leeroy Systems..."></textarea></div>
				<div class="field field--full">
					<span class="field__label">Your CV *</span>
					<label class="dropzone" data-dropzone>
						<input type="file" name="cv" accept=".pdf,.doc,.docx" required>
						<?php echo leeroy_icon( 'upload' ); ?>
						<span class="dropzone__text"><strong>Click to upload</strong> or drag and drop</span>
						<small>PDF, DOC or DOCX (max 5 MB)</small>
					</label>
				</div>
				<?php leeroy_form_captcha(); ?>
				<div class="field field--full"><button class="btn btn--primary" type="submit">Submit application <?php echo leeroy_icon( 'arrow-up-right' ); ?></button></div>
			</form>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/lightbox' );
get_footer();
