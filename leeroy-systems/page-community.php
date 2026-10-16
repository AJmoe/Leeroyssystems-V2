<?php
/**
 * Community page (slug: community).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/page-banner', null, [
	'title'   => 'Community',
	'image'   => 'gbmarathon-0.jpg',
	'eyebrow' => 'Community & Impact',
] );

$stories = leeroy_stories();
?>

<section class="section community-intro">
	<div class="container community-intro__grid">
		<div data-reveal>
			<span class="eyebrow">Community &amp; impact</span>
			<h2 class="section-title">Giving back to the communities we serve.</h2>
			<p class="lead">Growth for us means growth for the communities we serve: 200+ youths employed, 20+ training programmes, 20+ schools and 8+ communities supported, and 3+ corporate sponsorships of talent searches, events and initiatives.</p>
		</div>
		<div class="stat-cards" data-reveal>
			<?php foreach ( leeroy_community_stats() as $s ) : ?>
				<div class="stat-card">
					<strong><span data-count="<?php echo (int) $s['value']; ?>"><?php echo (int) $s['value']; ?></span><?php echo esc_html( $s['suffix'] ); ?></strong>
					<span><?php echo esc_html( $s['label'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tint stories" id="our-world">
	<div class="container">
		<div class="section-head section-head--center">
			<span class="eyebrow">Our world</span>
			<h2 class="section-title">Two sides of the same purpose.</h2>
		</div>

		<div class="filter" data-filter role="tablist" aria-label="Story category">
			<button type="button" class="filter__btn is-active" data-filter-value="all" role="tab" aria-selected="true">All Stories</button>
			<?php foreach ( $stories as $key => $group ) : ?>
				<button type="button" class="filter__btn" data-filter-value="<?php echo esc_attr( $key ); ?>" role="tab" aria-selected="false"><?php echo esc_html( $group['title'] ); ?></button>
			<?php endforeach; ?>
		</div>

		<?php foreach ( $stories as $key => $group ) : ?>
			<div class="story-group" data-filter-group="<?php echo esc_attr( $key ); ?>">
				<div class="story-group__head">
					<h3><?php echo esc_html( $group['title'] ); ?></h3>
					<p><?php echo esc_html( $group['text'] ); ?></p>
				</div>
				<div class="story-grid">
					<?php foreach ( $group['items'] as $story ) :
						$photos = array_map( 'leeroy_img', $story['photos'] );
						?>
						<button type="button" class="story-card" data-story='<?php echo esc_attr( wp_json_encode( [ 'title' => $story['title'], 'text' => $story['text'], 'photos' => $photos ] ) ); ?>'>
							<img src="<?php echo esc_url( $photos[0] ); ?>" alt="" loading="lazy">
							<span class="story-card__count"><?php echo leeroy_icon( 'camera' ); ?><?php echo count( $photos ); ?></span>
							<span class="story-card__body">
								<strong><?php echo esc_html( $story['title'] ); ?></strong>
								<small>Click to explore <?php echo leeroy_icon( 'arrow-right' ); ?></small>
							</span>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section class="section media" id="media">
	<div class="container">
		<div class="section-head section-head--center">
			<span class="eyebrow">Media</span>
			<h2 class="section-title">Moments from the field and the floor.</h2>
		</div>

		<?php foreach ( leeroy_videos() as $title => $group ) : ?>
			<div class="video-group">
				<div class="story-group__head">
					<h3><?php echo esc_html( $title ); ?></h3>
					<p><?php echo esc_html( $group['text'] ); ?></p>
				</div>
				<div class="video-grid">
					<?php foreach ( $group['items'] as $id => $label ) : ?>
						<button type="button" class="video-card" data-youtube="<?php echo esc_attr( $id ); ?>" data-title="<?php echo esc_attr( $label ); ?>">
							<span class="video-card__thumb">
								<img src="<?php echo esc_url( 'https://i.ytimg.com/vi/' . $id . '/hqdefault.jpg' ); ?>" alt="" loading="lazy">
								<span class="video-card__play"><?php echo leeroy_icon( 'play' ); ?></span>
							</span>
							<strong><?php echo esc_html( $label ); ?></strong>
							<small>Play video</small>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/lightbox' );
get_footer();
