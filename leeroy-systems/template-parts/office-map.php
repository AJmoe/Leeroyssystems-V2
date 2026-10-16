<?php
/**
 * Offices & footprint map. Opens on Africa, zooms to our regional footprint
 * when scrolled into view (capital pins + a Botswana "3 offices" pin), and
 * zooms into Botswana to show the office pins.
 * Outlines: Natural Earth (public domain), pre-projected in inc/map-data.json.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$map       = json_decode( file_get_contents( get_template_directory() . '/inc/map-data.json' ), true );
$c         = leeroy_contact();
$offices   = leeroy_offices();
$footprint = leeroy_footprint();
$ab        = $map['africaBox'];
$bb        = $map['bwaBox'];
$rb        = $map['regionBox'];
// The Botswana group pin sits at the centre of the three offices.
$ox = array_sum( array_column( $map['offices'], 0 ) ) / 3;
$oy = array_sum( array_column( $map['offices'], 1 ) ) / 3;
?>
<div class="zmap" data-zoommap data-africa="<?php echo esc_attr( implode( ',', $ab ) ); ?>" data-region="<?php echo esc_attr( implode( ',', $rb ) ); ?>" data-bwa="<?php echo esc_attr( implode( ',', $bb ) ); ?>">
	<div class="zmap__frame">
		<svg class="zmap__svg" viewBox="<?php echo esc_attr( implode( ' ', $ab ) ); ?>" preserveAspectRatio="xMidYMid meet" role="img" aria-label="Map of Africa showing the Leeroy Systems footprint — Botswana, Zambia, Namibia, Lesotho, Eswatini and Uganda — and our offices in Gaborone, Palapye and Francistown">
			<defs>
				<pattern id="zmap-dots" width="1.6" height="1.6" patternUnits="userSpaceOnUse"><circle cx="0.4" cy="0.4" r="0.18"/></pattern>
			</defs>
			<rect class="zmap__sea" x="-2000" y="-2000" width="5000" height="5000"/>
			<path class="zmap__land" d="<?php echo esc_attr( $map['land'] ); ?>"/>
			<?php foreach ( $map['near'] as $d ) : ?>
				<path class="zmap__land zmap__land--near" d="<?php echo esc_attr( $d ); ?>"/>
			<?php endforeach; ?>
			<?php foreach ( $map['footprint'] as $d ) : ?>
				<path class="zmap__fp" d="<?php echo esc_attr( $d ); ?>"/>
			<?php endforeach; ?>
			<path class="zmap__bwa" d="<?php echo esc_attr( $map['bwa'] ); ?>"/>
			<path class="zmap__bwa-dots" d="<?php echo esc_attr( $map['bwa'] ); ?>"/>
			<circle class="zmap__pulse" cx="<?php echo esc_attr( $bb[0] + $bb[2] / 2 ); ?>" cy="<?php echo esc_attr( $bb[1] + $bb[3] / 2 ); ?>" r="<?php echo esc_attr( $bb[2] * 0.7 ); ?>"/>
			<g class="zmap__labels">
				<?php foreach ( $map['labels'] as $code => $l ) : ?>
					<text class="zmap__label<?php echo 'BWA' === $code ? ' zmap__label--bwa' : ''; ?>" x="<?php echo esc_attr( $l[0] ); ?>" y="<?php echo esc_attr( $l[1] ); ?>"><?php echo esc_html( $l[2] ); ?></text>
				<?php endforeach; ?>
			</g>
		</svg>

		<?php foreach ( $offices as $o ) :
			[ $x, $y ] = $map['offices'][ $o['id'] ];
			?>
			<button type="button" class="zmap__pin<?php echo 'Head Office' === $o['type'] ? ' zmap__pin--hq' : ''; ?>" data-office="<?php echo esc_attr( $o['id'] ); ?>" data-view="bwa" data-x="<?php echo esc_attr( $x ); ?>" data-y="<?php echo esc_attr( $y ); ?>" aria-label="<?php echo esc_attr( $o['city'] . ' ' . strtolower( $o['type'] ) ); ?>" aria-controls="zmap-card-<?php echo esc_attr( $o['id'] ); ?>" aria-expanded="false" tabindex="-1">
				<span class="zmap__pin-dot"><?php echo leeroy_icon( 'pin' ); ?></span>
				<span class="zmap__pin-name"><?php echo esc_html( $o['city'] ); ?></span>
			</button>
		<?php endforeach; ?>

		<?php foreach ( $footprint as $f ) :
			[ $x, $y ] = $map['capitals'][ $f['id'] ];
			?>
			<button type="button" class="zmap__pin zmap__pin--capital" data-office="<?php echo esc_attr( $f['id'] ); ?>" data-view="region" data-x="<?php echo esc_attr( $x ); ?>" data-y="<?php echo esc_attr( $y ); ?>" aria-label="<?php echo esc_attr( $f['capital'] . ', ' . $f['country'] ); ?>" aria-controls="zmap-card-<?php echo esc_attr( $f['id'] ); ?>" aria-expanded="false" tabindex="-1">
				<span class="zmap__pin-dot"><?php echo leeroy_icon( 'flag' ); ?></span>
				<span class="zmap__pin-name"><?php echo esc_html( $f['capital'] ); ?><small><?php echo esc_html( $f['country'] ); ?></small></span>
			</button>
		<?php endforeach; ?>

		<button type="button" class="zmap__pin zmap__pin--cluster" data-zoom-to="bwa" data-view="region" data-x="<?php echo esc_attr( round( $ox, 2 ) ); ?>" data-y="<?php echo esc_attr( round( $oy, 2 ) ); ?>" aria-label="Botswana — zoom in to our three offices" tabindex="-1">
			<span class="zmap__pin-dot"><b>3</b></span>
			<span class="zmap__pin-name">Gaborone<small>Botswana · 3 offices</small></span>
		</button>

		<div class="zmap__status" aria-hidden="true"><span></span><em>Zooming in…</em></div>
	</div>

	<aside class="zmap__panel">
		<p class="zmap__kicker"><?php echo leeroy_icon( 'pin' ); ?>Our footprint</p>
		<h3>Botswana and beyond</h3>
		<div class="zmap__views" role="group" aria-label="Map view">
			<button type="button" data-view-btn="africa" aria-pressed="true">Africa</button>
			<button type="button" data-view-btn="region" aria-pressed="false">Footprint</button>
			<button type="button" data-view-btn="bwa" aria-pressed="false">Botswana</button>
		</div>

		<p class="zmap__group">Offices in Botswana</p>
		<ul class="zmap__list">
			<?php foreach ( $offices as $o ) : ?>
				<li>
					<button type="button" class="zmap__item" data-office-card="<?php echo esc_attr( $o['id'] ); ?>" data-view="bwa">
						<span class="zmap__item-dot<?php echo 'Head Office' === $o['type'] ? ' zmap__item-dot--hq' : ''; ?>"></span>
						<span><strong><?php echo esc_html( $o['city'] ); ?></strong><small><?php echo esc_html( $o['type'] ); ?></small></span>
						<?php echo leeroy_icon( 'chevron-right' ); ?>
					</button>
				</li>
			<?php endforeach; ?>
		</ul>

		<p class="zmap__group">Regional footprint</p>
		<ul class="zmap__chips">
			<?php foreach ( $footprint as $f ) : ?>
				<li><button type="button" class="zmap__chip" data-office-card="<?php echo esc_attr( $f['id'] ); ?>" data-view="region"><?php echo leeroy_icon( 'flag' ); ?><?php echo esc_html( $f['country'] ); ?></button></li>
			<?php endforeach; ?>
		</ul>
	</aside>

	<?php foreach ( $offices as $o ) : ?>
		<div class="zmap__card" id="zmap-card-<?php echo esc_attr( $o['id'] ); ?>" data-card="<?php echo esc_attr( $o['id'] ); ?>" role="dialog" aria-label="<?php echo esc_attr( $o['city'] . ' office details' ); ?>" hidden>
			<button type="button" class="zmap__close" data-card-close aria-label="Close"><?php echo leeroy_icon( 'close' ); ?></button>
			<span class="office__type"><?php echo esc_html( $o['type'] ); ?></span>
			<h3><?php echo esc_html( $o['city'] ); ?></h3>
			<p class="office__region"><?php echo esc_html( $o['region'] ); ?></p>
			<ul>
				<li><?php echo leeroy_icon( 'pin' ); ?><span><?php echo esc_html( $o['address'] ); ?></span></li>
				<li><?php echo leeroy_icon( 'phone' ); ?><span><?php echo esc_html( implode( ' · ', $o['phones'] ) ); ?></span></li>
				<li><?php echo leeroy_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></li>
			</ul>
			<a class="zmap__directions" href="<?php echo esc_url( 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $o['address'] . ', ' . $o['city'] . ', Botswana' ) ); ?>" target="_blank" rel="noopener">Get directions <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
		</div>
	<?php endforeach; ?>

	<?php foreach ( $footprint as $f ) : ?>
		<div class="zmap__card zmap__card--fp" id="zmap-card-<?php echo esc_attr( $f['id'] ); ?>" data-card="<?php echo esc_attr( $f['id'] ); ?>" role="dialog" aria-label="<?php echo esc_attr( $f['country'] . ' footprint details' ); ?>" hidden>
			<button type="button" class="zmap__close" data-card-close aria-label="Close"><?php echo leeroy_icon( 'close' ); ?></button>
			<span class="office__type">Regional footprint</span>
			<h3><?php echo esc_html( $f['country'] ); ?></h3>
			<p class="office__region">Capital: <?php echo esc_html( $f['capital'] ); ?></p>
			<p class="zmap__fp-text"><?php echo esc_html( $f['country'] ); ?> is part of the Leeroy Systems footprint. Enquiries are handled by our head office in Gaborone.</p>
			<ul>
				<li><?php echo leeroy_icon( 'phone' ); ?><a href="tel:<?php echo esc_attr( $c['tel'] ); ?>"><?php echo esc_html( $c['phone'] ); ?></a></li>
				<li><?php echo leeroy_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></li>
			</ul>
			<a class="zmap__directions" href="#contact">Send an enquiry <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
		</div>
	<?php endforeach; ?>
</div>
