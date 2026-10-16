<?php
/**
 * All site content. Sourced from the Leeroy Systems Company Profile
 * (2026) plus the stories, photos and videos from the previous site.
 * Edit text here — templates read from it.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leeroy_contact(): array {
	return [
		'email'    => 'info@leeroysystems.co.bw',
		'phone'    => '(+267) 393 2519',
		'tel'      => '+2673932519',
		'mobiles'  => [ '(+267) 71 390 977', '(+267) 72 229 539' ],
		'hours'    => 'Mon–Sat, 08:00–17:00',
		'address'  => 'Plot 176, Gaborone International Commerce Park, Gaborone, Botswana',
		'facebook' => 'https://facebook.com/p/Leeroy-Systems-100063566140015',
		'linkedin' => 'https://bw.linkedin.com/in/leeroy-systems-415a142b6',
		'youtube'  => 'https://www.youtube.com/@LeeroySystems',
	];
}

/** "At a glance" figures. */
function leeroy_stats(): array {
	return [
		[ 'value' => 33000, 'suffix' => '+', 'label' => 'Smart prepaid meters live', 'icon' => 'gauge' ],
		[ 'value' => 10, 'suffix' => '+', 'label' => 'Years in operation', 'icon' => 'award' ],
		[ 'value' => 24, 'suffix' => '/7', 'label' => 'Meter Control Centre', 'icon' => 'clock' ],
		[ 'value' => 3, 'suffix' => '', 'label' => 'Offices in Botswana', 'icon' => 'pin' ],
	];
}

function leeroy_hero_slides(): array {
	return [
		[
			'image'   => 'img-3325.jpg',
			'eyebrow' => 'Futuristic Solutions',
			'title'   => 'A pioneer of smart prepaid water metering in Africa.',
			'text'    => 'End-to-end Metering-as-a-Service, IoT-enabled smart meters, data intelligence and an open multi-utility vending platform for utilities, municipalities, mines and commercial property owners.',
		],
		[
			'image'   => 'hq-leeroy.jpg',
			'eyebrow' => 'One partner. Every layer.',
			'title'   => 'From the wall to the cloud.',
			'text'    => 'Headquartered in Gaborone, we design, assemble, deploy and manage complete smart metering ecosystems — proven at scale with more than 33,000 meters live.',
		],
		[
			'image'   => 'wuc03.jpg',
			'eyebrow' => 'Monitored around the clock',
			'title'   => 'Every connected meter, watched 24/7.',
			'text'    => 'Our Meter Control Centre handles alerts, customer support, maintenance and field dispatch day and night, so every system performs for its full life.',
		],
	];
}

function leeroy_highlights(): array {
	return [
		[
			'icon'  => 'award',
			'title' => 'Award-Winning',
			'text'  => 'First place in the Manufacturing Sector at the 2025 Botswana Consumer Fair.',
		],
		[
			'icon'  => 'shield',
			'title' => 'Internationally Recognised',
			'text'  => 'A member of the global Smart Water Networks Forum (SWAN), aligned with international best practice.',
		],
		[
			'icon'  => 'flag',
			'title' => 'Endorsed by Brand Botswana',
			'text'  => 'Endorsed under the Botswana Investment and Trade Centre (BITC) as a home-grown champion of innovation.',
		],
	];
}

function leeroy_values(): array {
	return [
		[ 'title' => 'Quality', 'text' => 'The highest standard in every product and service we deliver.', 'icon' => 'shield' ],
		[ 'title' => 'Integrity', 'text' => 'Transparency, honesty and accountability in all our dealings.', 'icon' => 'handshake' ],
		[ 'title' => 'Innovation', 'text' => 'Embracing new technology to stay at the forefront of the industry.', 'icon' => 'bulb' ],
		[ 'title' => 'Customer Satisfaction', 'text' => 'Going the extra mile to meet and exceed expectations.', 'icon' => 'smile' ],
		[ 'title' => 'Teamwork', 'text' => 'Winning by supporting each other to make a positive impact.', 'icon' => 'users' ],
		[ 'title' => 'Sustainability', 'text' => 'Building a better future for customers, employees and communities.', 'icon' => 'leaf' ],
		[ 'title' => 'Reliability & Accuracy', 'text' => 'Delivering on our promises, consistently.', 'icon' => 'target' ],
	];
}

/**
 * The six integrated services, keyed by page slug.
 */
function leeroy_services(): array {
	return [
		'service-meters'      => [
			'title'    => 'Metering-as-a-Service',
			'short'    => 'Smart prepaid water meters supplied, installed and fully managed for billing, revenue collection and water loss control.',
			'lead'     => 'A fully managed metering estate — without the capital outlay or operational burden.',
			'icon'     => 'gauge',
			'thumb'    => 'metering.jpg',
			'banner'   => 'meteringbanner01.jpg',
			'image'    => 'meter1.jpg',
			'overview' => 'We supply, install and manage smart prepaid water meters for real-time billing, revenue collection and water loss control across residential, bulk and commercial properties. Clients get a fully managed metering estate without the capital outlay or operational burden. Our 24-hour Meter Control Centre (MCC) monitors every connected meter around the clock, handling alerts, customer support, preventive and reactive maintenance, and field team dispatch.',
			'points'   => [
				'Smart prepaid meters for residential, bulk and commercial properties.',
				'Real-time billing, revenue collection and water loss control.',
				'24-hour Meter Control Centre monitoring every connected meter.',
				'Alerts, customer support and field team dispatch handled for you.',
				'Preventive and reactive maintenance across the whole estate.',
			],
			'outcome'  => 'A fully managed, accountable metering estate — with no capital outlay and every meter watched around the clock.',
		],
		'service-ciu'         => [
			'title'    => 'CIU Manufacturing & Repair',
			'short'    => 'Customer Interface Units manufactured, assembled, tested and repaired at our own facility in Gaborone.',
			'lead'     => 'Keypad, LCD and token-entry CIUs built and refurbished locally — cutting replacement costs by up to 60%.',
			'icon'     => 'code',
			'thumb'    => 'keypad.jpg',
			'banner'   => 'meter-green.jpg',
			'image'    => 'keypad.jpg',
			'overview' => 'We manufacture, assemble, test and repair Customer Interface Units (CIUs) at our own facility in Gaborone. Keypad, LCD display and token-entry models serve residential and commercial users, and every unit is compatible with LoRaWAN, Sigfox and NB-IoT. Each CIU passes quality assurance testing before deployment, and firmware is updated over the air. Local repair and refurbishment reduces replacement costs by up to 60%.',
			'points'   => [
				'Keypad, LCD display and token-entry models for residential and commercial users.',
				'Every unit compatible with LoRaWAN, Sigfox and NB-IoT.',
				'Quality assurance testing on each CIU before deployment.',
				'Over-the-air firmware updates.',
				'Local repair and refurbishment — up to 60% lower replacement costs.',
			],
			'outcome'  => 'Reliable, locally supported customer units with faster turnaround and a much lower lifecycle cost.',
		],
		'service-engineering' => [
			'title'    => 'Project Management & Engineering',
			'short'    => 'Engineers, project managers and site supervisors who plan and deliver smart water metering projects end to end.',
			'lead'     => 'Engineering-as-a-Service backed by more than 33,000 installations of hands-on experience.',
			'icon'     => 'briefcase',
			'thumb'    => 'ab03.jpg',
			'banner'   => 'ab05.jpg',
			'image'    => 'ab03.jpg',
			'overview' => 'We help utilities, governments, developers and technology partners plan and deliver smart water metering projects, drawing on more than 33,000 installations of hands-on experience. Our engineers, project managers and site supervisors support every phase, from the first feasibility study to commissioning, handover and post-deployment support.',
			'points'   => [
				'Feasibility studies, needs assessment and technology selection.',
				'System design and connectivity planning.',
				'Procurement support, meter testing and calibration before installation.',
				'Rollout planning, installation supervision and quality control.',
				'Systems integration with billing, ERP and SCADA platforms.',
				'Commissioning, handover, training and post-deployment support.',
			],
			'outcome'  => 'Smart metering rollouts delivered on a proven playbook — whether we run the programme or support your own team.',
		],
		'service-iot'         => [
			'title'    => 'IoT-Enabled Smart Meters',
			'short'    => 'Meters and CIUs with IoT built in, reporting wirelessly from day one over LoRaWAN, Sigfox or NB-IoT.',
			'lead'     => 'The right connectivity for every site, with all meter data flowing to our 24-hour Meter Control Centre.',
			'icon'     => 'antenna',
			'thumb'    => 'network-tower.jpg',
			'banner'   => 'network-tower-banner.jpg',
			'image'    => 'network-tower.jpg',
			'overview' => 'We build IoT technology into our meters and CIUs, so every device reports its data wirelessly from day one. Our meters work on LoRaWAN, Sigfox and NB-IoT networks provided by our connectivity partners and mobile network operators, and we match the technology to each site. Data from every meter flows into our 24-hour Meter Control Centre.',
			'points'   => [
				'LoRaWAN for dense urban and estate deployments — up to 15 km open terrain (2–5 km urban), 10+ year battery life, remote valve control and over-the-air updates.',
				'Sigfox for remote and peri-urban meters — ultra-narrowband, low power, redundant message delivery, cost-effective for large rollouts.',
				'NB-IoT for critical and high-security infrastructure — licensed LTE spectrum, deep indoor and basement penetration, SLA-backed reliability.',
				'Networks provided by our connectivity partners and mobile network operators.',
				'Every reading flows into the 24-hour Meter Control Centre.',
			],
			'outcome'  => 'Every meter connected on the technology that best suits its site, reporting reliably from the day it is installed.',
		],
		'service-data'        => [
			'title'    => 'Data-as-a-Service',
			'short'    => 'Live dashboards, non-revenue water detection, revenue intelligence and automated alerts from your meter network.',
			'lead'     => 'Your meter network is a data asset — we help you unlock its value.',
			'icon'     => 'chart',
			'thumb'    => 'modedata.jpg',
			'banner'   => 'team.jpg',
			'image'    => 'about-operations.jpg',
			'overview' => 'Meter data reaches the cloud every 15 minutes and flows into live dashboards and automated insight. From consumption analytics and non-revenue water detection to revenue intelligence and alarm management, the platform turns raw readings into decisions — and can even package anonymised consumption intelligence for planners, developers and insurers.',
			'points'   => [
				'Consumption analytics: zone- and customer-level dashboards, heatmaps, seasonal trends and demand forecasting.',
				'Non-revenue water: automatic detection of discrepancies between bulk and residential meters, locating losses in real time.',
				'Revenue intelligence: real-time payment tracking, credit alerts and revenue-at-risk reporting that end estimated billing.',
				'Alarm and event management: tamper, dry pipe, burst main, reverse flow and low-credit alerts by SMS, email or API.',
				'Data monetisation: anonymised consumption intelligence under revenue-share models.',
			],
			'outcome'  => 'Data every 15 minutes, losses found in real time and estimated billing a thing of the past.',
		],
		'service-software'    => [
			'title'    => 'Open Multi-Utility Vending',
			'short'    => 'One open, cloud-hosted platform for prepaid water, electricity, gas and time-based services — no vendor lock-in.',
			'lead'     => 'One platform. Four utilities. Total control.',
			'icon'     => 'code',
			'thumb'    => 'saaas1.jpg',
			'banner'   => 'software-banner.jpg',
			'image'    => 'wuc4.jpg',
			'overview' => 'Our cloud-hosted vending platform handles prepaid water, electricity, gas and time-based services, and it is built as an open platform: it is not tied to a single meter brand or billing system. REST APIs and standards-based integration connect it to utility billing, municipal ERP, SCADA and property management systems, and it is white-labelled per client with a 24/7 customer portal and mobile app.',
			'points'   => [
				'Open by design: REST APIs and standards-based integration with billing, ERP, SCADA and property systems.',
				'Multi-vendor ready: works with a wide range of compatible meters and devices.',
				'Water vending by mobile, kiosk or agent, with real-time balance, leak alerts and consumption reports.',
				'STS-compliant electricity vending, LPG and reticulated gas with automatic cut-off on zero credit.',
				'Time vending for laundromats, boreholes, kiosks and shared facilities.',
				'White-labelled, multi-tenant and multi-site, with a full audit trail.',
			],
			'outcome'  => 'Total control of prepaid revenue across every utility — on hardware you choose, with no vendor lock-in.',
		],
	];
}

/**
 * Track record, keyed by page slug.
 */
function leeroy_projects(): array {
	return [
		'project-wuc'         => [
			'title'    => 'Water Utilities Corporation',
			'tag'      => 'National utility',
			'location' => 'Gaborone',
			'scale'    => '30,036 domestic · 131 bulk',
			'status'   => 'Completed',
			'short'    => 'Our largest deployment: more than 30,000 domestic and bulk smart prepaid meters across Gaborone.',
			'thumb'    => 'wuc.jpg',
			'banner'   => 'wuc5.jpg',
			'overview' => 'For Botswana\'s national water utility, we deployed domestic and bulk smart prepaid meters in Gaborone — 30,036 domestic and 131 bulk meters — and provided support, maintenance, monitoring and training. It remains the largest single deployment of its kind in our track record.',
			'points'   => [
				'30,036 domestic smart prepaid meters installed in Gaborone.',
				'131 bulk meters for supply and district metering.',
				'Support and maintenance across the installed base.',
				'Monitoring through our Meter Control Centre.',
				'Training for utility teams.',
			],
			'outcome'  => 'Smart prepaid metering at utility scale — proof that the model works across an entire city.',
			'gallery'  => [ 'wuc5.jpg', 'wuc-2.jpg', 'wuc-1.jpg', 'wuc1.jpg' ],
		],
		'project-jwaneng'     => [
			'title'    => 'Debswana, Jwaneng Mine',
			'tag'      => 'Mining',
			'location' => 'Jwaneng',
			'scale'    => 'Township-wide',
			'status'   => 'Completed',
			'short'    => 'Domestic and bulk smart prepaid meters for the mine township, with monitoring and support.',
			'thumb'    => 'jwaneng-board1.jpg',
			'banner'   => 'jwaneng-mine.jpg',
			'overview' => 'At Debswana\'s Jwaneng Mine we installed domestic and bulk smart prepaid meters across the mine township, and provided ongoing monitoring and support to keep readings dependable in a high-value operational environment.',
			'points'   => [
				'Township-wide domestic smart prepaid metering.',
				'Bulk metering for supply visibility.',
				'Meter monitoring through our Meter Control Centre.',
				'Ongoing technical support.',
			],
			'outcome'  => 'Accountable, township-wide water usage information for the mine community.',
			'gallery'  => [ 'jwa1.jpg', 'jwa2.jpg', 'jw3.jpg', 'leeroy-car.jpg' ],
		],
		'project-francistown' => [
			'title'    => 'City of Francistown Council',
			'tag'      => 'Local government',
			'location' => 'Francistown',
			'scale'    => '97 domestic · 22 bulk',
			'status'   => 'Ongoing',
			'short'    => '13-month contract across schools, clinics, SHHA housing and community halls.',
			'thumb'    => 'ft-car.jpg',
			'banner'   => 'ft-pumper.jpg',
			'overview' => 'Under a 13-month contract with the City of Francistown Council, we are installing smart prepaid water meters across council schools, clinics, SHHA housing and community halls — 97 domestic and 22 bulk meters — supported from our Francistown regional office.',
			'points'   => [
				'97 domestic and 22 bulk smart prepaid meters.',
				'Schools, clinics, SHHA housing and community halls.',
				'Field coordination from our Francistown office.',
				'Commissioning, monitoring and reporting for the council.',
			],
			'outcome'  => 'Clearer usage and revenue visibility across the council\'s public facilities.',
			'gallery'  => [ 'ft-car.jpg', 'ft2.jpg', 'ft1.jpg', 'ft-pumper1.jpg' ],
		],
		'project-palapye'     => [
			'title'    => 'Palapye District Council',
			'tag'      => 'Local government',
			'location' => 'Palapye',
			'scale'    => '10 domestic · 1 bulk',
			'status'   => 'Ongoing',
			'short'    => 'Pilot of smart prepaid metering across council school facilities.',
			'thumb'    => 'ab07.jpg',
			'banner'   => 'ab07.jpg',
			'overview' => 'With Palapye District Council we are running a pilot of smart prepaid water metering across council school facilities — 10 domestic and 1 bulk meter — to validate field processes, technical reliability and readiness for a wider rollout.',
			'points'   => [
				'Pilot across council school facilities.',
				'10 domestic and 1 bulk smart prepaid meter.',
				'Performance monitoring and field feedback.',
				'Evidence base for wider rollout planning.',
			],
			'outcome'  => 'A practical evidence base for extending smart prepaid metering across the district.',
			'gallery'  => [ 'ab07.jpg' ],
		],
		'project-diphalane'   => [
			'title'    => 'Diphalane Mall',
			'tag'      => 'Commercial property',
			'location' => 'Palapye',
			'scale'    => 'All tenants',
			'status'   => 'Ongoing',
			'short'    => 'One prepaid meter per tenant plus bulk metering to simplify revenue collection.',
			'thumb'    => 'diphalane-mall.jpg',
			'banner'   => 'diphalane-mall.jpg',
			'overview' => 'At Diphalane Mall in Palapye — also home to our Central Branch — every tenant has their own prepaid water meter, backed by bulk metering for the whole property. Tenants pay for exactly what they use, and the landlord no longer has to chase water bills.',
			'points'   => [
				'One smart prepaid meter per tenant.',
				'Bulk metering for the whole property.',
				'Simplified revenue collection for the landlord.',
				'Local support from our Palapye office in the mall.',
			],
			'outcome'  => 'Fair, transparent water costs for tenants and effortless revenue collection for the property owner.',
			'gallery'  => [ 'diphalane-mall.jpg' ],
		],
	];
}

/** Other clients mentioned in the company profile. */
function leeroy_other_clients(): array {
	return [ 'Ministry of Child Welfare and Basic Education', 'Local Enterprise Authority (LEA)' ];
}

/** Strategic partners and affiliations (logo => area). */
function leeroy_partners(): array {
	return [
		'SWAN — Smart Water Networks Forum' => 'swan.png',
		'BITC — Brand Botswana'             => 'brand-botswana.png',
		'Business Botswana'                 => 'business-botswana.png',
		'Local Enterprise Authority (LEA)'  => 'lea.png',
		'SH Meters'                         => 'sh-meters.png',
		'iCurrate Laboratories'             => 'icurrate-laboratories.png',
		'Reliable Vending Solutions'        => 'reliable-vending-solutions.png',
		'Lesira-Teq'                        => 'lesira-teq.png',
		'Wireless 360°'                     => 'wireless-360.png',
		'Technology Affiliates Group'       => 'technology-affiliates.png',
		'Rapid Skills Development Centre'   => 'rsdc.png',
	];
}

/** Meter portfolio (Technical Capabilities). */
function leeroy_meter_portfolio(): array {
	return [
		[ 'type' => 'Smart prepaid residential (with CIU)', 'size' => 'Domestic', 'use' => 'Homes, flats, estates, tenants', 'note' => 'Keypad or token entry, wireless reporting via LoRaWAN, Sigfox or NB-IoT, AMR drive-by option.' ],
		[ 'type' => 'Ultrasonic bulk', 'size' => 'DN50–DN200', 'use' => 'Bulk supply, district metering', 'note' => 'No moving parts, sustained accuracy, sediment resistant, remote valve control.' ],
		[ 'type' => 'Electromagnetic', 'size' => 'DN50–DN300', 'use' => 'Pump stations, reservoirs', 'note' => 'Full-bore, zero pressure drop, bi-directional, MODBUS / M-Bus for SCADA.' ],
		[ 'type' => 'Multijet', 'size' => 'DN15–DN50', 'use' => 'Commercial and industrial sub-metering', 'note' => 'Wide flow range, pulse output, AMR drive-by compatible, low cost of ownership.' ],
	];
}

function leeroy_offices(): array {
	return [
		[
			'id'      => 'gaborone',
			'type'    => 'Head Office',
			'city'    => 'Gaborone',
			'region'  => 'Botswana · Head Office',
			'address' => 'Plot 176, Gaborone International Commerce Park',
			'phones'  => [ '(+267) 393 2519', '(+267) 71 390 977', '(+267) 72 229 539' ],
		],
		[
			'id'      => 'francistown',
			'type'    => 'Regional Office',
			'city'    => 'Francistown',
			'region'  => 'Botswana · Northern Region',
			'address' => 'Plot 5037, Somerset East Extension',
			'phones'  => [ '(+267) 72 817 224' ],
		],
		[
			'id'      => 'palapye',
			'type'    => 'Regional Office',
			'city'    => 'Palapye',
			'region'  => 'Botswana · Central Region',
			'address' => 'Diphalane Mall, Plot 20737, Office 1, New Industrial',
			'phones'  => [ '(+267) 72 655 286' ],
		],
	];
}

/** Regional footprint: countries (and capitals) we serve beyond Botswana. */
function leeroy_footprint(): array {
	return [
		[ 'id' => 'zambia', 'country' => 'Zambia', 'capital' => 'Lusaka' ],
		[ 'id' => 'namibia', 'country' => 'Namibia', 'capital' => 'Windhoek' ],
		[ 'id' => 'lesotho', 'country' => 'Lesotho', 'capital' => 'Maseru' ],
		[ 'id' => 'eswatini', 'country' => 'Eswatini', 'capital' => 'Mbabane' ],
		[ 'id' => 'uganda', 'country' => 'Uganda', 'capital' => 'Kampala' ],
	];
}

/** Social impact. */
function leeroy_community_stats(): array {
	return [
		[ 'value' => 200, 'suffix' => '+', 'label' => 'Youths employed' ],
		[ 'value' => 20, 'suffix' => '+', 'label' => 'Training programmes' ],
		[ 'value' => 20, 'suffix' => '+', 'label' => 'Schools supported' ],
		[ 'value' => 8, 'suffix' => '+', 'label' => 'Communities supported' ],
	];
}

/**
 * Community stories grouped by category. Each opens a photo gallery.
 */
function leeroy_stories(): array {
	return [
		'life'     => [
			'title' => 'Life at Leeroy',
			'text'  => 'The culture, the people, the moments that make us who we are.',
			'items' => [
				[
					'title'  => 'Christmas Party',
					'text'   => 'An annual celebration bringing the entire Leeroy Systems team together to reflect on the year, recognise achievements and enjoy the festive season.',
					'photos' => [ 'christmaspart2025-0.jpg', 'christmaspart2025-01.jpg', 'christmaspart2025-2.jpg', 'christmaspart2025-3.jpg', 'christmaspart2025-4.jpg', 'christmaspart2025-1.jpg' ],
				],
				[
					'title'  => 'Spring Day',
					'text'   => 'A team outdoor day celebrating the season, giving staff a chance to relax, connect and recharge together outside the office.',
					'photos' => [ 'spr0.jpg', 'spr3.jpg', 'spr4.jpg', 'spr5.jpg', 'spr6.jpg', 'spr1.jpg' ],
				],
				[
					'title'  => 'Morning Aerobics',
					'text'   => 'Staff start select mornings with a group aerobics session, promoting physical wellness, team energy and a healthy work culture.',
					'photos' => [ 'mornaerobics-0.jpg', 'mornaerobics-1.jpg', 'mornaerobics-2.jpg', 'mornaerobics-3.jpg', 'mornaerobics-4.jpg', 'mornaerobics-5.jpg' ],
				],
			],
		],
		'training' => [
			'title' => 'Training Sessions',
			'text'  => 'Investing in our team through ongoing customer care and Kaizen training and development.',
			'items' => [
				[
					'title'  => 'Internal Customer Training',
					'text'   => 'Day 2 of internal customer training, focused on the skills and mindset behind professional, empathetic customer care: listening actively, responding with clarity and respect, and owning the customer experience.',
					'photos' => [ 'training-customer-care-1.jpg', 'training-customer-care-2.jpg', 'training-customer-care-3.jpg', 'training-customer-care-4.jpg', 'training-customer-care-5.jpg' ],
				],
				[
					'title'  => 'Kaizen Training Launch',
					'text'   => 'The official start of our Kaizen (continuous improvement) journey, facilitated by the Local Enterprise Authority and delivered by the Botswana National Productivity Centre, bringing our whole team together around a culture of getting better every day.',
					'photos' => [ 'training-kaizen-launch-1.jpg', 'training-kaizen-launch-2.jpg', 'training-kaizen-launch-3.jpg', 'training-kaizen-launch-4.jpg', 'training-kaizen-launch-5.jpg' ],
				],
				[
					'title'  => 'Kaizen Training – Session 2 of 5',
					'text'   => 'Held on 15 December 2025. Kaizen means "change for the better": smart, consistent improvements. Even heading into the festive season, our commitment to continuous improvement stayed switched on.',
					'photos' => [ 'training-kaizen-session2-1.jpg', 'training-kaizen-session2-2.jpg', 'training-kaizen-session2-3.jpg', 'training-kaizen-session2-4.jpg', 'training-kaizen-session2-5.jpg', 'training-kaizen-session2-6.jpg', 'training-kaizen-session2-7.jpg', 'training-kaizen-session2-8.jpg' ],
				],
				[
					'title'  => 'Kaizen Training – Q1 Kickoff',
					'text'   => 'Setting the tone for a productive first quarter. Facilitated by the Local Enterprise Authority with training support from BNPC, this session reinforced continuous improvement as part of everyday work, everyone\'s responsibility, driving performance, quality and client satisfaction.',
					'photos' => [ 'training-kaizen-q1-1.jpg', 'training-kaizen-q1-2.jpg', 'training-kaizen-q1-3.jpg', 'training-kaizen-q1-4.jpg', 'training-kaizen-q1-5.jpg', 'training-kaizen-q1-6.jpg' ],
				],
			],
		],
		'outreach' => [
			'title' => 'Beyond the Office',
			'text'  => 'How we show up for the communities we serve, off the clock.',
			'items' => [
				[
					'title'  => 'Diacore Gaborone Marathon',
					'text'   => 'Leeroy Systems took part in the Gaborone Marathon, representing the company and showing commitment to an active and connected community.',
					'photos' => [ 'gbmarathon-0.jpg', 'gbmarathon-00.jpg', 'gbmarathon-1.jpg', 'gbmarathon-2.jpg', 'gbmarathon-3.jpg', 'gbmarathon-4.jpg', 'gbmarathon-5.jpg', 'gbmarathon-6.jpg' ],
				],
				[
					'title'  => 'Francistown Mayor\'s Marathon',
					'text'   => 'Our northern branch team participated in the Mayor of Francistown Marathon, bringing the Leeroy spirit to the second city.',
					'photos' => [ 'ftmarathon-0.jpg', 'ftmarathon-00.jpg', 'ftmarathon-1.jpg', 'ftmarathon-2.jpg', 'ftmarathon-3.jpg', 'ftmarathon-4.jpg', 'ftmarathon-5.jpg' ],
				],
				[
					'title'  => 'SOS Painting Outreach',
					'text'   => 'Staff volunteered their time and effort to repaint a local orphanage, giving back to the community in a hands-on and meaningful way.',
					'photos' => [ 'orphanage-00.jpg', 'orphanage-0.jpg', 'orphanage-1.jpg', 'orphanage-2.jpg', 'orphanage-3.jpg', 'orphanage-4.jpg', 'orphanage-5.jpg' ],
				],
			],
		],
	];
}

function leeroy_videos(): array {
	return [
		'Self Service' => [
			'text'  => 'Quick videos to help you use your meter and get answers without waiting on a call.',
			'items' => [
				'P7ATzr-5T78' => '(CIU) Customer Interface Unit - Sample',
				'oBcr6A7tqEI' => 'Leeroy Systems FAQs Answered',
				'6aWH0lpwVGI' => 'Benefits of SPWM',
				'Jh1lHTUiICU' => 'Meter Control Operation Centre (MCCO)',
			],
		],
		'Testimony'    => [
			'text'  => 'Stories from the projects and communities we serve.',
			'items' => [
				'OaEbtrhRrwU' => 'WUC - Leeroy Systems Activation at Sedibeng House',
				'ZPuFVY3E92o' => 'Tsholofelo East Installation',
				'93QZFARUzqM' => 'Palapye Diphalana Mall',
				'JVcGOAEKBbU' => '4th Industrial Revolution',
			],
		],
	];
}

/**
 * Per-page <title> and meta description, carried over from the previous site.
 */
function leeroy_seo_data(): array {
	$seo = [
		'home'      => [
			'title'       => 'Leeroy Systems | Futuristic Solutions for Smart Water',
			'description' => 'Leeroy Systems is a pioneer of smart prepaid water metering in Africa: Metering-as-a-Service, IoT smart meters, data intelligence and an open multi-utility vending platform.',
		],
		'community' => [
			'title'       => 'Community | Leeroy Systems',
			'description' => 'Leeroy Systems community outreach, in-house programmes and media. Giving back to Botswana through sport, volunteering and team culture.',
		],
		'gallery'   => [
			'title'       => 'Gallery | Leeroy Systems',
			'description' => 'Photo albums from Leeroy Systems: events and visits, life at Leeroy, training and community outreach across Botswana.',
		],
		'news'      => [
			'title'       => 'News | Leeroy Systems',
			'description' => 'The latest news from Leeroy Systems: projects, partnerships, recognition and community stories from Botswana and beyond.',
		],
		'careers'   => [
			'title'       => 'Careers | Leeroy Systems',
			'description' => 'Join the Leeroy Systems team. Explore career opportunities in smart prepaid water metering across Botswana.',
		],
	];
	foreach ( leeroy_services() as $slug => $s ) {
		$seo[ $slug ] = [ 'title' => $s['title'] . ' | Leeroy Systems', 'description' => $s['lead'] ];
	}
	foreach ( leeroy_projects() as $slug => $p ) {
		$seo[ $slug ] = [ 'title' => $p['title'] . ' | Leeroy Systems', 'description' => $p['short'] ];
	}
	return $seo;
}
