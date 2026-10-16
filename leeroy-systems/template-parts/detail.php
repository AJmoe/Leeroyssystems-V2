<?php
/**
 * Service / project detail page (Medksy "service details" layout:
 * main column + sticky sidebar).
 *
 * @var array $args { kind: service|project, slug, item }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$kind    = $args['kind'];
$slug    = $args['slug'];
$item    = $args['item'];
$c       = leeroy_contact();
$siblings = 'service' === $kind ? leeroy_services() : leeroy_projects();
$home    = home_url( '/' );

get_header();

get_template_part( 'template-parts/page-banner', null, [
	'title'        => $item['title'],
	'image'        => $item['banner'],
	'eyebrow'      => 'service' === $kind ? 'Service' : 'Project case',
	'parent_label' => 'service' === $kind ? 'Services' : 'Projects',
	'parent_url'   => $home . ( 'service' === $kind ? '#services' : '#projects' ),
] );
?>

<section class="section detail">
	<div class="container detail__grid">
		<article class="detail__main">
			<figure class="detail__hero">
				<img src="<?php echo esc_url( leeroy_img( 'service' === $kind ? $item['image'] : $item['banner'] ) ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
			</figure>

			<p class="lead detail__lead"><?php echo esc_html( 'service' === $kind ? $item['lead'] : $item['short'] ); ?></p>

			<span class="eyebrow">Overview</span>
			<h2 class="section-title section-title--sm"><?php echo 'service' === $kind ? 'What this service delivers.' : 'What this project delivered.'; ?></h2>
			<p><?php echo esc_html( $item['overview'] ); ?></p>

			<ul class="checklist detail__points">
				<?php foreach ( $item['points'] as $point ) : ?>
					<li><?php echo leeroy_icon( 'check-circle' ); ?><?php echo esc_html( $point ); ?></li>
				<?php endforeach; ?>
			</ul>

			<div class="outcome">
				<span class="outcome__icon"><?php echo leeroy_icon( 'growth' ); ?></span>
				<div>
					<h3>Outcome</h3>
					<p><?php echo esc_html( $item['outcome'] ); ?></p>
				</div>
			</div>

			<?php if ( 'project' === $kind && count( $item['gallery'] ) > 1 ) : ?>
				<h2 class="section-title section-title--sm">Project gallery</h2>
				<div class="detail__gallery" data-gallery-group>
					<?php foreach ( $item['gallery'] as $img ) : ?>
						<button type="button" class="detail__gallery-item" data-lightbox="<?php echo esc_url( leeroy_img( $img ) ); ?>" aria-label="Enlarge photo">
							<img src="<?php echo esc_url( leeroy_img( $img ) ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?> project photo" loading="lazy">
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( 'service' === $kind ) : ?>
				<div class="detail__related">
					<h2 class="section-title section-title--sm">Recent deployments</h2>
					<div class="detail__related-grid">
						<?php foreach ( array_slice( leeroy_projects(), 0, 2, true ) as $p_slug => $p ) : ?>
							<a class="mini-card" href="<?php echo esc_url( leeroy_page_url( $p_slug ) ); ?>">
								<img src="<?php echo esc_url( leeroy_img( $p['thumb'] ) ); ?>" alt="" loading="lazy">
								<span><strong><?php echo esc_html( $p['title'] ); ?></strong><small><?php echo esc_html( $p['short'] ); ?></small></span>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</article>

		<aside class="detail__aside">
			<div class="widget">
				<h3 class="widget__title"><?php echo 'service' === $kind ? 'All Services' : 'All Projects'; ?></h3>
				<ul class="widget__list">
					<?php foreach ( $siblings as $s_slug => $s ) : ?>
						<li class="<?php echo $s_slug === $slug ? 'is-current' : ''; ?>">
							<a href="<?php echo esc_url( leeroy_page_url( $s_slug ) ); ?>" <?php echo $s_slug === $slug ? 'aria-current="page"' : ''; ?>><?php echo esc_html( $s['title'] ); ?><?php echo leeroy_icon( 'arrow-right' ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<?php if ( 'project' === $kind ) : ?>
				<div class="widget">
					<h3 class="widget__title">Project info</h3>
					<dl class="facts">
						<div><dt>Client</dt><dd><?php echo esc_html( $item['title'] ); ?></dd></div>
						<div><dt>Location</dt><dd><?php echo esc_html( $item['location'] ); ?></dd></div>
						<div><dt>Sector</dt><dd><?php echo esc_html( $item['tag'] ); ?></dd></div>
						<div><dt>Scale</dt><dd><?php echo esc_html( $item['scale'] ); ?></dd></div>
						<div><dt>Status</dt><dd><?php echo esc_html( $item['status'] ); ?></dd></div>
					</dl>
				</div>
			<?php endif; ?>

			<div class="widget widget--help" style="--bg: url('<?php echo esc_url( leeroy_img( 'ab04.jpg' ) ); ?>')">
				<span class="icon-box icon-box--light"><?php echo leeroy_icon( 'phone' ); ?></span>
				<h3>Ready for a scoped discussion?</h3>
				<p>Talk to Leeroy Systems about how <?php echo 'service' === $kind ? 'this service' : 'we'; ?> can support your water metering programme.</p>
				<a class="help-phone" href="tel:<?php echo esc_attr( $c['tel'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a>
				<a class="btn btn--light" href="<?php echo esc_url( $home . '#contact' ); ?>">Contact Leeroy Systems</a>
			</div>
		</aside>
	</div>
</section>

<?php
get_template_part( 'template-parts/partners' );
get_template_part( 'template-parts/lightbox' );
get_footer();
