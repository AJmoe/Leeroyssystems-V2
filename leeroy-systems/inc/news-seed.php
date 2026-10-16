<?php
/**
 * Bundled news stories.
 *
 * News lives in the WordPress database, so stories written here ship with
 * the theme and are created on the live site automatically (once each) the
 * first time the site loads after the theme is installed or updated. Their
 * photos are copied into the Media Library so they can be edited like any
 * other post afterwards. Deleting a bundled post in wp-admin is permanent —
 * it won't be re-created.
 *
 * To bundle another story: add an item below (photos in assets/img/news/<slug>/)
 * and bump LEEROY_NEWS_SEED_VERSION.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LEEROY_NEWS_SEED_VERSION', '9' );

function leeroy_news_seed_items(): array {
	return [
		[
			'slug'     => 'lea-board-of-directors-visits-leeroy-systems',
			'title'    => 'LEA Board of Directors visits Leeroy Systems',
			'date'     => '2026-10-11 10:00:00',
			'category' => 'Partnerships',
			'folder'   => 'lea-board-visit',
			'excerpt'  => 'We were honoured to host the Local Enterprise Authority Board of Directors and Management, who came to see first-hand how LEA\'s guidance, training and market access support have helped grow our smart prepaid water metering business.',
			'content'  => '<p>We were honoured to host the <strong>Local Enterprise Authority (LEA) Board of Directors and Management</strong> at Leeroy Systems as part of LEA\'s enterprise visits.</p>
<p>The delegation was led by Board Chairperson Lebogang Tips Matale, together with Technical Advisory Committee Chair Wanetsha Mosinyi and Board Members Tshepo Makhani and Gogontle Basiami, alongside members of the LEA Management team. The visit was an opportunity to engage directly with our team and to see the impact of LEA\'s support on our growth and development.</p>
<h2>Our journey — and how LEA has helped</h2>
<p>As a local manufacturer of smart prepaid water metering solutions, we shared our journey and the challenges we have faced in business expansion, diversification, market access, networking and sustainability. To help us meet them, LEA has provided a range of interventions:</p>
<ul>
<li>Business advisory services and business plan development</li>
<li>Financial advisory support and advocacy</li>
<li>Customer care and Kaizen training</li>
<li>International benchmarking opportunities in Italy</li>
<li>Market access initiatives, including the installation of our smart meters at LEA\'s Kutla Incubators</li>
</ul>
<p>The Board and Management team saw for themselves how these interventions have strengthened the business, expanded our market opportunities, enhanced our competitiveness and supported our plans for future growth.</p>
<blockquote><p>We are truly grateful to the LEA Board of Directors and Management for visiting Leeroy Systems! LEA\'s guidance, training and market access support have played a key role in growing our smart prepaid water metering business. We look forward to achieving even more together. <em>Re a leboga.</em></p></blockquote>
<p>The visit highlighted LEA\'s role in nurturing SMMEs — helping businesses innovate, create employment and contribute meaningfully to Botswana\'s economic development. Thank you, LEA.</p>
<h2>Photos from the visit</h2>',
		],
		[
			'slug'     => 'wellness-in-action-team-climbs-nyangabgwe-hill',
			'title'    => 'Wellness in action: Team Leeroy climbs Nyangabgwe Hill',
			'date'     => '2026-10-10 08:00:00',
			'category' => 'Community',
			'folder'   => 'nyangabgwe-hill-climb',
			'excerpt'  => 'Nothing beats a morning climb with the team! Our Francistown team took on Nyangabgwe Hill, recharging our minds and growing stronger together.',
			'content'  => '<p>Nothing beats a morning climb with the team! Our team in <strong>Francistown</strong> took on <strong>Nyangabgwe Hill</strong>, recharging our minds and growing stronger together.</p>
<p>Wellness and team spirit are a big part of life at Leeroy Systems — and a weekend climb, a warm-up together and a few push-ups at the top are a great way to keep both strong.</p>
<p class="post-tags">#TeamLeeroy #WeekendWellness #TeamBuilding</p>
<h2>Photos from the climb</h2>',
		],
		[
			'slug'     => 'flashback-friday-penresa-forbes-africa',
			'title'    => 'Flashback Friday: sharing our story with PENRESA and Forbes Africa',
			'date'     => '2026-10-09 08:45:00',
			'category' => 'Partnerships',
			'folder'   => 'penresa-forbes-africa',
			'excerpt'  => 'Looking back with gratitude on the moment we shared with PENRESA and Forbes Africa — thank you for listening to our story and sharing in our journey.',
			'content'  => '<p>This Flashback Friday we are looking back with gratitude on the moment we shared with <strong>PENRESA</strong> and <strong>Forbes Africa</strong>.</p>
<p>Thank you for taking the time to engage with us, listen to our story and share in our journey. Moments like these remind us how far we have come and inspire us to keep going.</p>
<p>We are truly grateful and look forward to more!</p>
<p class="post-tags">#FBF #ForbesAfrica #PENRESA #Gratitude #Partnerships #LeeroySystems</p>',
		],
		[
			'slug'     => 'botswana-turns-60-leeroy-systems-turns-11',
			'title'    => 'Botswana turns 60. We turn 11.',
			'date'     => '2026-10-06 10:12:00',
			'category' => 'In the media',
			'folder'   => 'botswana-60-leeroy-11',
			'excerpt'  => 'Proud to grow alongside the nation we call home — and featured in the Tuesday Grill: "Leeroy Systems: Proudly Botswana, Powering Every Drop for Botswana’s Next Chapter".',
			'content'  => '<p>🇧🇼 <strong>Botswana turns 60. We turn 11.</strong></p>
<p>We are proud to grow alongside the nation we call home. Here is to the strides behind us — and the bigger ones ahead!</p>
<h2>As featured in the Tuesday Grill</h2>
<p>Missed our feature in last week’s <strong>Tuesday Grill</strong>? The article, <em>“Leeroy Systems: Proudly Botswana, Powering Every Drop for Botswana’s Next Chapter”</em>, opens:</p>
<blockquote><p>Leeroy Systems, a proudly Botswana company behind the country’s smart prepaid water revolution, joins the nation in celebrating 60 years of independence with gratitude, pride and a firm belief that Botswana’s greatest chapters are still to be written.</p></blockquote>
<p>Tap the clipping above to open it full size and read the full feature.</p>
<p class="post-tags">#Botswana60 #LeeroySystems11 #TuesdayGrill #MakingStrides</p>',
		],
		[
			'slug'     => 'breast-cancer-awareness-month',
			'title'    => 'Breast Cancer Awareness Month: early detection saves lives',
			'date'     => '2026-10-05 08:27:00',
			'category' => 'Community',
			'folder'   => 'breast-cancer-awareness-month',
			'excerpt'  => 'This Breast Cancer Awareness Month, let’s spread love, hope and awareness. Early detection saves lives. Check. Support. Encourage.',
			'content'  => '<p>This <strong>Breast Cancer Awareness Month</strong>, let’s spread love, hope and awareness. Early detection saves lives. 🎀</p>
<p><strong>Check. Support. Encourage.</strong> Together, we can make a difference.</p>
<p class="post-tags">#AwarenessSavesLives #HopeAndHealing #LoveAndLight</p>',
		],
		[
			'slug'     => 'boipuso-botswana-60-years-of-independence',
			'title'    => 'Boipuso jo bo monate! Celebrating 60 years of independence',
			'date'     => '2026-09-29 14:01:00',
			'category' => 'Community',
			'folder'   => 'boipuso-botswana-60',
			'excerpt'  => 'Pula! 30 September marks 60 years since Botswana’s independence in 1966 — a diamond jubilee that feels especially fitting for Botswana.',
			'content'  => '<p>Pula! 🇧🇼 And what a year to be celebrating: <strong>30 September marks 60 years since Botswana’s independence in 1966</strong>. A diamond jubilee feels especially fitting for Botswana.</p>
<p>A bit of grey sky can’t compete with that kind of pride. And rain has always been a blessing in Botswana, so gloomy weather during Boipuso might even count as a good omen.</p>
<p>Our team marked the occasion together — in traditional attire, over traditional food and with plenty of national pride.</p>
<p><strong>Boipuso jo bo monate!</strong> 💙🖤🤍</p>
<p class="post-tags">#Boipuso #BotswanaIndependence #Bots60</p>
<h2>Photos from our celebration</h2>',
		],
		[
			'slug'     => 'water-futures-dialogue-smart-water-infrastructure',
			'title'    => 'Water Futures. Real Solutions. Leeroy Systems joins the Water Futures Dialogue',
			'date'     => '2026-09-21 08:00:00',
			'category' => 'Events',
			'folder'   => 'water-futures-dialogue',
			'excerpt'  => 'Our Technical Director joined the Water Futures Dialogue — a new partnership between the University of Botswana and Philipps-Universität Marburg — on the panel on Smart Water Infrastructure and Digitalisation.',
			'content'  => '<p>🇧🇼💧 <strong>Water Futures. Real Solutions.</strong></p>
<p>Leeroy Systems stood proudly at the table shaping tomorrow’s water solutions. Our Technical Director joined the <strong>Water Futures Dialogue</strong>, a new partnership between the <strong>University of Botswana</strong> and <strong>Philipps-Universität Marburg, Germany</strong>, contributing to the panel on <strong>Smart Water Infrastructure and Digitalisation</strong>.</p>
<p>This is what progress looks like: universities, industry, communities and policymakers united around one mission — driving smart, sustainable water solutions for Botswana.</p>
<p>Proud to play our part. 💧🇧🇼</p>
<p class="post-tags">#WaterFutures #SmartWaterTech #Digitalisation #LeeroySystems #Botswana</p>
<h2>Photos from the dialogue</h2>',
		],
		[
			'slug'     => 'hosting-gs1-namibia-at-leeroy-systems',
			'title'    => 'Hosting GS1 Namibia: two SMMEs learning from each other',
			'date'     => '2026-09-04 09:00:00',
			'category' => 'Partnerships',
			'folder'   => 'gs1-namibia-visit',
			'excerpt'  => 'We had the honour of hosting GS1 Namibia at Leeroy Systems — two SMMEs coming together to exchange ideas, share experiences and learn from each other’s journeys.',
			'content'  => '<p>Looking back on a moment worth remembering.</p>
<p>We had the honour of hosting <strong>GS1 Namibia</strong> at Leeroy Systems — two SMMEs coming together to exchange ideas, share experiences and learn from each other’s journeys. Our guests also toured our Meter Control Centre, where every connected meter is monitored around the clock.</p>
<p>We are grateful to the <strong>Local Enterprise Authority (LEA)</strong> for making this engagement possible, and to <strong>BITC</strong> for being part of the conversation. Small moments like these often plant the seeds for bigger things ahead.</p>
<p class="post-tags">#LeeroySystems #GS1Namibia #LEA #BITC #SMMEDevelopment #EnterpriseGrowth #SADCRegion #Botswana #Namibia</p>
<h2>Photos from the visit</h2>',
		],
		[
			'slug'     => 'proud-sponsor-of-the-next-chapter-cup',
			'title'    => 'Proud sponsor of the inaugural Next Chapter Cup',
			'date'     => '2026-08-10 09:00:00', // Estimated — confirm the Facebook post date.
			'category' => 'Community',
			'folder'   => 'next-chapter-cup',
			'excerpt'  => 'Every footballer’s story doesn’t end when they hang up their boots — it begins a new chapter. We were proud to sponsor the inaugural Next Chapter Cup at Royal Aria Stadium, Tlokweng.',
			'content'  => '<p>Every footballer’s story doesn’t end when they hang up their boots — it just begins a new chapter.</p>
<p>Leeroy Systems was proud to be one of the sponsors of the inaugural <strong>Next Chapter Cup</strong> tournament by the <strong>Footballers Union of Botswana</strong> and the <strong>Rapid Skills Development Centre</strong> — one of our strategic partners — held at <strong>Royal Aria Stadium, Tlokweng</strong>.</p>
<p>Sustainability is one of our core values, and this initiative — empowering footballers with real skills for “life after training” — is exactly the kind of impact we love standing behind.</p>
<p>Congratulations to all the scholarship graduates! We were proud to stand alongside Tiro Connect, Bosele Social Club and the Botswana Media Team in supporting this journey, together with the Construction Industry Trust Fund (CITF) and the Kgodiso Foundation.</p>
<p>Here’s to the next chapter — and many more tournaments to come. 🏆</p>
<p class="post-tags">#LifeAfterTraining #SustainableLiving #SupportLocal</p>
<h2>Photos from the tournament</h2>',
		],
	];
}

/*
 * Creating posts and processing photos takes a few seconds, so it never runs
 * while a visitor waits: it runs in WordPress's background cron, or directly
 * when an administrator opens wp-admin.
 */
add_action( 'init', function () {
	if ( get_option( 'leeroy_news_seed_version' ) !== LEEROY_NEWS_SEED_VERSION && ! wp_next_scheduled( 'leeroy_news_seed' ) ) {
		wp_schedule_single_event( time(), 'leeroy_news_seed' );
	}
} );
add_action( 'admin_init', function () {
	if ( get_option( 'leeroy_news_seed_version' ) !== LEEROY_NEWS_SEED_VERSION && current_user_can( 'manage_options' ) ) {
		leeroy_news_seed_run();
	}
} );
add_action( 'leeroy_news_seed', 'leeroy_news_seed_run' );

function leeroy_news_seed_run() {
	if ( get_option( 'leeroy_news_seed_version' ) === LEEROY_NEWS_SEED_VERSION ) {
		return;
	}
	// Mark first so two simultaneous runs can't both create the posts.
	update_option( 'leeroy_news_seed_version', LEEROY_NEWS_SEED_VERSION );
	$done = (array) get_option( 'leeroy_news_seeded', [] );

	foreach ( leeroy_news_seed_items() as $item ) {
		if ( in_array( $item['slug'], $done, true ) || get_page_by_path( $item['slug'], OBJECT, 'post' ) ) {
			continue;
		}
		$id = leeroy_news_seed_create( $item );
		if ( $id ) {
			$done[] = $item['slug'];
		}
	}
	update_option( 'leeroy_news_seeded', $done, false );
}

/** "03-lea-board-members" → "LEA board members" (keeps names and acronyms right). */
function leeroy_photo_label( string $filename ): string {
	$proper = [
		'lea' => 'LEA', 'gs1' => 'GS1', 'bitc' => 'BITC', 'leeroy' => 'Leeroy', 'botswana' => 'Botswana', 'namibia' => 'Namibia',
		'university' => 'University', 'royal' => 'Royal', 'aria' => 'Aria', 'stadium' => 'Stadium', 'next' => 'Next',
		'chapter' => 'Chapter', 'cup' => 'Cup', 'nyangabgwe' => 'Nyangabgwe', 'hill' => 'Hill', 'forbes' => 'Forbes',
		'africa' => 'Africa', 'tuesday' => 'Tuesday', 'grill' => 'Grill', 'boipuso' => 'Boipuso', 'bogobe' => 'Bogobe',
	];
	$words = explode( '-', preg_replace( '/^\d+-/', '', $filename ) );
	foreach ( $words as $i => $w ) {
		$words[ $i ] = $proper[ $w ] ?? ( 0 === $i ? ucfirst( $w ) : $w );
	}
	$label = implode( ' ', $words );
	return str_replace( '2015 2026', '2015–2026', $label );
}

function leeroy_news_seed_create( array $item ): int {
	$term = term_exists( $item['category'], 'category' );
	if ( ! $term ) {
		$term = wp_insert_term( $item['category'], 'category' );
	}

	$post_id = wp_insert_post( [
		'post_title'    => $item['title'],
		'post_name'     => $item['slug'],
		'post_content'  => $item['content'],
		'post_excerpt'  => $item['excerpt'],
		'post_status'   => 'publish',
		'post_date'     => $item['date'],
		'post_category' => is_wp_error( $term ) ? [] : [ (int) $term['term_id'] ],
	], true );
	if ( is_wp_error( $post_id ) ) {
		return 0;
	}

	// Copy the photos into the Media Library: first one is the cover, all form the gallery.
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$files = glob( get_template_directory() . '/assets/img/news/' . $item['folder'] . '/*.jpg' );
	sort( $files );
	$ids = [];
	foreach ( $files as $file ) {
		$tmp = wp_tempnam( basename( $file ) );
		if ( ! $tmp || ! copy( $file, $tmp ) ) {
			continue;
		}
		$label = leeroy_photo_label( pathinfo( $file, PATHINFO_FILENAME ) );
		$att   = media_handle_sideload( [ 'name' => $item['slug'] . '-' . basename( $file ), 'tmp_name' => $tmp ], $post_id, $label );
		if ( is_wp_error( $att ) ) {
			wp_delete_file( $tmp );
			continue;
		}
		update_post_meta( $att, '_wp_attachment_image_alt', $item['title'] . ' — ' . $label );
		$ids[] = $att;
	}
	if ( $ids ) {
		set_post_thumbnail( $post_id, $ids[0] );
	}
	if ( count( $ids ) > 1 && function_exists( 'leeroy_gallery_album_from_post' ) ) {
		leeroy_gallery_album_from_post( (int) $post_id );
	}
	if ( count( $ids ) > 1 ) {
		wp_update_post( [
			'ID'           => $post_id,
			'post_content' => $item['content'] . "\n[gallery ids=\"" . implode( ',', $ids ) . '" columns="3" size="medium_large" link="file"]',
		] );
	}
	return (int) $post_id;
}
