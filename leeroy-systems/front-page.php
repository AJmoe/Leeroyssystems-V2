<?php
/**
 * Home page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
$c = leeroy_contact();
?>

<!-- Hero slider -->
<section class="hero" data-slider aria-roledescription="carousel" aria-label="Highlights">
	<?php foreach ( leeroy_hero_slides() as $i => $slide ) : ?>
		<div class="hero__slide <?php echo 0 === $i ? 'is-active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' of 3' ); ?>" <?php echo 0 === $i ? '' : 'aria-hidden="true"'; ?>>
			<img class="hero__bg" src="<?php echo esc_url( leeroy_img( $slide['image'] ) ); ?>" alt="" <?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
			<div class="container hero__content">
				<span class="eyebrow eyebrow--light"><?php echo esc_html( $slide['eyebrow'] ); ?></span>
				<?php if ( 0 === $i ) : ?>
					<h1 class="hero__title"><?php echo esc_html( $slide['title'] ); ?></h1>
				<?php else : ?>
					<h2 class="hero__title"><?php echo esc_html( $slide['title'] ); ?></h2>
				<?php endif; ?>
				<p class="hero__text"><?php echo esc_html( $slide['text'] ); ?></p>
				<div class="hero__actions">
					<a class="btn btn--primary" href="#services">Our Services <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
					<a class="btn btn--ghost" href="#contact">Contact Us</a>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="container hero__controls">
		<div class="hero__dots" role="tablist" aria-label="Choose slide">
			<?php for ( $i = 0; $i < 3; $i++ ) : ?>
				<button type="button" class="<?php echo 0 === $i ? 'is-active' : ''; ?>" aria-label="Slide <?php echo (int) $i + 1; ?>" data-slide-to="<?php echo (int) $i; ?>"></button>
			<?php endfor; ?>
		</div>
		<div class="hero__arrows">
			<button type="button" data-slide-prev aria-label="Previous slide"><?php echo leeroy_icon( 'chevron-left' ); ?></button>
			<button type="button" data-slide-next aria-label="Next slide"><?php echo leeroy_icon( 'chevron-right' ); ?></button>
		</div>
	</div>

	<div class="hero__badge">
		<span class="hero__badge-icon"><?php echo leeroy_icon( 'gauge' ); ?></span>
		<div><strong>33,000+</strong><span>Smart meters installed</span></div>
	</div>
</section>

<!-- Highlight cards -->
<section class="features">
	<div class="container features__grid">
		<?php foreach ( leeroy_highlights() as $h ) : ?>
			<article class="feature">
				<span class="feature__icon"><?php echo leeroy_icon( $h['icon'] ); ?></span>
				<div>
					<h3><?php echo esc_html( $h['title'] ); ?></h3>
					<p><?php echo esc_html( $h['text'] ); ?></p>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<!-- About -->
<section class="section about" id="about">
	<div class="container about__grid">
		<div class="about__media" data-reveal>
			<img class="about__img about__img--main" src="<?php echo esc_url( leeroy_img( 'ab05.jpg' ) ); ?>" alt="Leeroy Systems installation crew on site" loading="lazy">
			<img class="about__img about__img--sub" src="<?php echo esc_url( leeroy_img( 'team.jpg' ) ); ?>" alt="The Leeroy Systems team at the Meter Control Centre" loading="lazy">
			<div class="about__exp">
				<strong>10+</strong>
				<span>Years of<br>experience</span>
			</div>
		</div>

		<div class="about__body" data-reveal>
			<span class="eyebrow">About us</span>
			<h2 class="section-title">A decade of leading smart prepaid water metering.</h2>
			<p class="lead">For more than ten years, Leeroy Systems has led the shift from estimated billing and manual reads to real-time, prepaid, data-driven water management.</p>
			<p>We were among the first in the region to deploy smart prepaid water metering at utility scale, and today more than 33,000 of our smart meters are live. Our in-house teams assemble and repair CIUs, build IoT technology into our meters, write firmware and software, calibrate meters and monitor every connected meter from our 24-hour Meter Control Centre — faster deployment, lower lifecycle cost and accountable performance for our clients.</p>

			<ul class="checklist checklist--2col">
				<?php foreach ( [ 'SWAN member', 'Endorsed by Brand Botswana (BITC)', '24/7 Meter Control Centre', 'Built and tested in-house' ] as $item ) : ?>
					<li><?php echo leeroy_icon( 'check-circle' ); ?><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>

			<div class="about__actions">
				<a class="btn btn--primary" href="#services">Discover More <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
				<a class="call-inline" href="tel:<?php echo esc_attr( $c['tel'] ); ?>">
					<span class="icon-box icon-box--round"><?php echo leeroy_icon( 'phone' ); ?></span>
					<span><small>Call anytime</small><strong><?php echo esc_html( $c['phone'] ); ?></strong></span>
				</a>
			</div>
		</div>
	</div>
</section>

<!-- Services -->
<section class="section section--tint services" id="services">
	<div class="container">
		<div class="section-head section-head--split">
			<div>
				<span class="eyebrow">Our services</span>
				<h2 class="section-title">Six integrated services. One partner. Every layer.</h2>
			</div>
			<p>From the Customer Interface Unit on the wall to the analytics dashboard in the cloud — take the full stack or just the layers you need.</p>
		</div>

		<div class="services__grid">
			<?php $n = 0; foreach ( leeroy_services() as $slug => $s ) : $n++; ?>
				<article class="service-card" data-reveal>
					<a class="service-card__media" href="<?php echo esc_url( leeroy_page_url( $slug ) ); ?>" tabindex="-1" aria-hidden="true">
						<img src="<?php echo esc_url( leeroy_img( $s['thumb'] ) ); ?>" alt="" loading="lazy">
					</a>
					<div class="service-card__body">
						<span class="service-card__icon"><?php echo leeroy_icon( $s['icon'] ); ?></span>
						<span class="service-card__num"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>
						<h3><a href="<?php echo esc_url( leeroy_page_url( $slug ) ); ?>"><?php echo esc_html( $s['title'] ); ?></a></h3>
						<p><?php echo esc_html( $s['short'] ); ?></p>
						<a class="link-arrow" href="<?php echo esc_url( leeroy_page_url( $slug ) ); ?>">Explore More <?php echo leeroy_icon( 'arrow-right' ); ?><span class="sr-only"> about <?php echo esc_html( $s['title'] ); ?></span></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Counters -->
<section class="counters" style="--bg: url('<?php echo esc_url( leeroy_img( 'dji-0426.jpg' ) ); ?>')">
	<div class="container counters__grid">
		<?php foreach ( leeroy_stats() as $stat ) : ?>
			<div class="counter">
				<span class="counter__icon"><?php echo leeroy_icon( $stat['icon'] ); ?></span>
				<div>
					<strong><span data-count="<?php echo (int) $stat['value']; ?>"><?php echo esc_html( number_format( $stat['value'] ) ); ?></span><?php echo esc_html( $stat['suffix'] ); ?></strong>
					<span><?php echo esc_html( $stat['label'] ); ?></span>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<!-- Vision & mission -->
<section class="section direction">
	<div class="container direction__grid">
		<div class="direction__body" data-reveal>
			<span class="eyebrow">Direction</span>
			<h2 class="section-title">Clear purpose, measurable water impact.</h2>
			<p class="lead">Our vision and mission define every system we build and every client relationship we invest in.</p>

			<div class="vm">
				<div class="vm__item">
					<span class="vm__icon"><?php echo leeroy_icon( 'target' ); ?></span>
					<div>
						<h3>Vision</h3>
						<p>To redefine water management worldwide through smart prepaid technology that drives efficiency, accountability and long-term water security.</p>
					</div>
				</div>
				<div class="vm__item">
					<span class="vm__icon"><?php echo leeroy_icon( 'flag' ); ?></span>
					<div>
						<h3>Mission</h3>
						<p>To deliver quality water usage data and real-time prepaid metering solutions that exceed industry standards, backed by expertise, innovation and reliability that keep every system we install performing for its full life.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="direction__media" data-reveal>
			<img src="<?php echo esc_url( leeroy_img( 'ab03.jpg' ) ); ?>" alt="Leeroy Systems staff reviewing data with a client on site" loading="lazy">
			<div class="direction__card">
				<span class="icon-box"><?php echo leeroy_icon( 'award' ); ?></span>
				<p><strong>1st place</strong> 2025 Botswana Consumer Fair — Manufacturing Sector</p>
			</div>
		</div>
	</div>
</section>

<!-- Values -->
<section class="section section--navy values">
	<div class="container">
		<div class="section-head section-head--split">
			<div>
				<span class="eyebrow eyebrow--light">Our values</span>
				<h2 class="section-title">The standards behind every system we install.</h2>
			</div>
			<p>Seven principles behind every product and service we deliver.</p>
		</div>
		<div class="values__grid">
			<?php foreach ( leeroy_values() as $i => $v ) : ?>
				<article class="value" data-reveal>
					<div class="value__top">
						<span class="value__icon"><?php echo leeroy_icon( $v['icon'] ); ?></span>
						<span class="value__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					</div>
					<h3><?php echo esc_html( $v['title'] ); ?></h3>
					<p><?php echo esc_html( $v['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
			<a class="value value--cta" href="#contact" data-reveal>
				<h3>Work with a team that lives these values.</h3>
				<span class="link-arrow">Get in touch <?php echo leeroy_icon( 'arrow-right' ); ?></span>
			</a>
		</div>
	</div>
</section>

<!-- Technical capabilities -->
<section class="section capabilities" id="capabilities">
	<div class="container capabilities__grid">
		<div data-reveal>
			<span class="eyebrow">Technical capabilities</span>
			<h2 class="section-title">Built, tested and certified in-house.</h2>
			<p class="lead">Every system we deliver is accountable from component to cloud.</p>
			<ul class="cap-list">
				<li>
					<span class="icon-box"><?php echo leeroy_icon( 'target' ); ?></span>
					<div><h3>Meter testing &amp; calibration</h3><p>With iCurrate Laboratories, our accredited facility tests and calibrates potable cold water meters (ultrasonic, multijet and mechanical, DN50–DN200), issuing a full calibration certificate for each — in line with Botswana Bureau of Standards (BOBS) requirements.</p></div>
				</li>
				<li>
					<span class="icon-box"><?php echo leeroy_icon( 'code' ); ?></span>
					<div><h3>In-house development</h3><p>Our Gaborone team builds the web portals, mobile apps, billing APIs and IoT middleware behind our platform, and integrates meters, connectivity, cloud and client billing systems for each project.</p></div>
				</li>
				<li>
					<span class="icon-box"><?php echo leeroy_icon( 'clock' ); ?></span>
					<div><h3>24-hour Meter Control Centre</h3><p>Dedicated control agents keep watch over every connected meter, day and night.</p></div>
				</li>
			</ul>
		</div>
		<div class="portfolio" data-reveal>
			<h3 class="portfolio__title"><?php echo leeroy_icon( 'gauge' ); ?>Meter portfolio</h3>
			<?php foreach ( leeroy_meter_portfolio() as $m ) : ?>
				<article class="meter-row">
					<div class="meter-row__head">
						<h4><?php echo esc_html( $m['type'] ); ?></h4>
						<span class="meter-row__size"><?php echo esc_html( $m['size'] ); ?></span>
					</div>
					<p class="meter-row__use"><?php echo esc_html( $m['use'] ); ?></p>
					<p><?php echo esc_html( $m['note'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Projects -->
<section class="section projects" id="projects">
	<div class="container">
		<div class="section-head section-head--center">
			<span class="eyebrow">Proven track record</span>
			<h2 class="section-title">National utilities, mining, local government and commercial property.</h2>
			<p>Our largest single deployment exceeds 30,000 meters. Other clients include the <?php echo esc_html( implode( ' and the ', leeroy_other_clients() ) ); ?>.</p>
		</div>
		<div class="projects__grid">
			<?php $n = 0; foreach ( leeroy_projects() as $slug => $p ) : $n++; ?>
				<article class="project-card" data-reveal>
					<a href="<?php echo esc_url( leeroy_page_url( $slug ) ); ?>" class="project-card__link">
						<img src="<?php echo esc_url( leeroy_img( $p['thumb'] ) ); ?>" alt="" loading="lazy">
						<div class="project-card__overlay">
							<span class="project-card__status project-card__status--<?php echo esc_attr( strtolower( $p['status'] ) ); ?>"><?php echo esc_html( $p['status'] ); ?></span>
							<span class="project-card__tag"><?php echo esc_html( $p['tag'] ); ?></span>
							<h3><?php echo esc_html( $p['title'] ); ?></h3>
							<span class="project-card__scale"><?php echo leeroy_icon( 'gauge' ); ?><?php echo esc_html( $p['scale'] ); ?></span>
							<p><?php echo esc_html( $p['short'] ); ?></p>
							<span class="project-card__more">Learn More <?php echo leeroy_icon( 'arrow-up-right' ); ?></span>
						</div>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Community teaser -->
<section class="section section--tint community-teaser">
	<div class="container community-teaser__grid">
		<div data-reveal>
			<span class="eyebrow">Community &amp; impact</span>
			<h2 class="section-title">Giving back to the communities we serve.</h2>
			<p class="lead">Growth for us means growth for the communities we serve — through youth employment, skills training, school support and community upliftment.</p>
			<ul class="mini-stats">
				<?php foreach ( leeroy_community_stats() as $s ) : ?>
					<li><strong><?php echo esc_html( $s['value'] . $s['suffix'] ); ?></strong><span><?php echo esc_html( $s['label'] ); ?></span></li>
				<?php endforeach; ?>
			</ul>
			<a class="btn btn--primary" href="<?php echo esc_url( leeroy_page_url( 'community' ) ); ?>">Explore Community <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
		</div>
		<div class="mosaic" data-reveal>
			<img src="<?php echo esc_url( leeroy_img( 'gbmarathon-0.jpg' ) ); ?>" alt="Leeroy Systems team at the Gaborone Marathon" loading="lazy">
			<img src="<?php echo esc_url( leeroy_img( 'orphanage-0.jpg' ) ); ?>" alt="Staff repainting a local orphanage" loading="lazy">
			<img src="<?php echo esc_url( leeroy_img( 'training-kaizen-launch-1.jpg' ) ); ?>" alt="Kaizen training launch" loading="lazy">
			<img src="<?php echo esc_url( leeroy_img( 'ftmarathon-0.jpg' ) ); ?>" alt="Northern branch team at the Francistown Mayor's Marathon" loading="lazy">
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/partners' ); ?>
<?php get_template_part( 'template-parts/contact' ); ?>

<?php
get_footer();
