<?php
/**
 * Site header: info top bar + sticky main header (Medksy layout).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$c    = leeroy_contact();
$slug = leeroy_current_slug();
$home = home_url( '/' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>

<div class="topbar">
	<div class="container topbar__inner">
		<ul class="topbar__info">
			<li><?php echo leeroy_icon( 'pin' ); ?><span>Plot 176, Gaborone International Commerce Park</span></li>
			<li><?php echo leeroy_icon( 'mail' ); ?><a href="mailto:<?php echo esc_attr( $c['email'] ); ?>"><?php echo esc_html( $c['email'] ); ?></a></li>
		</ul>
		<div class="topbar__right">
			<span class="topbar__tag"><?php echo leeroy_icon( 'clock' ); ?><?php echo esc_html( $c['hours'] ); ?></span>
			<div class="social">
				<a href="<?php echo esc_url( $c['facebook'] ); ?>" aria-label="Facebook" target="_blank" rel="noopener"><?php echo leeroy_icon( 'facebook' ); ?></a>
				<a href="<?php echo esc_url( $c['linkedin'] ); ?>" aria-label="LinkedIn" target="_blank" rel="noopener"><?php echo leeroy_icon( 'linkedin' ); ?></a>
				<a href="<?php echo esc_url( $c['youtube'] ); ?>" aria-label="YouTube" target="_blank" rel="noopener"><?php echo leeroy_icon( 'youtube' ); ?></a>
			</div>
		</div>
	</div>
</div>

<header class="header" data-header>
	<div class="container header__inner">
		<a class="brand" href="<?php echo esc_url( $home ); ?>" aria-label="Leeroy Systems home">
			<img src="<?php echo esc_url( leeroy_img( 'logo.png' ) ); ?>" alt="Leeroy Systems" width="756" height="368">
		</a>

		<nav class="nav" aria-label="Primary">
			<ul class="nav__list" id="site-menu">
				<li class="<?php echo 'home' === $slug ? 'is-current' : ''; ?>"><a href="<?php echo esc_url( $home ); ?>">Home</a></li>
				<li><a href="<?php echo esc_url( $home . '#about' ); ?>">About Us</a></li>
				<li class="has-sub <?php echo isset( leeroy_services()[ $slug ] ) ? 'is-current' : ''; ?>">
					<a href="<?php echo esc_url( $home . '#services' ); ?>">Services <?php echo leeroy_icon( 'chevron-down' ); ?></a>
					<button class="sub-toggle" type="button" aria-label="Show services" aria-expanded="false"><?php echo leeroy_icon( 'chevron-down' ); ?></button>
					<ul class="sub">
						<?php foreach ( leeroy_services() as $s_slug => $s ) : ?>
							<li><a href="<?php echo esc_url( leeroy_page_url( $s_slug ) ); ?>"><?php echo esc_html( $s['title'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<li class="has-sub <?php echo isset( leeroy_projects()[ $slug ] ) ? 'is-current' : ''; ?>">
					<a href="<?php echo esc_url( $home . '#projects' ); ?>">Projects <?php echo leeroy_icon( 'chevron-down' ); ?></a>
					<button class="sub-toggle" type="button" aria-label="Show projects" aria-expanded="false"><?php echo leeroy_icon( 'chevron-down' ); ?></button>
					<ul class="sub">
						<?php foreach ( leeroy_projects() as $p_slug => $p ) : ?>
							<li><a href="<?php echo esc_url( leeroy_page_url( $p_slug ) ); ?>"><?php echo esc_html( $p['title'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<li class="has-sub <?php echo ( in_array( $slug, [ 'news', 'gallery' ], true ) || is_singular( 'post' ) ) ? 'is-current' : ''; ?>">
					<a href="<?php echo esc_url( leeroy_page_url( 'news' ) ); ?>">News <?php echo leeroy_icon( 'chevron-down' ); ?></a>
					<button class="sub-toggle" type="button" aria-label="Show news and gallery" aria-expanded="false"><?php echo leeroy_icon( 'chevron-down' ); ?></button>
					<ul class="sub">
						<li><a href="<?php echo esc_url( leeroy_page_url( 'news' ) ); ?>">News</a></li>
						<li><a href="<?php echo esc_url( leeroy_page_url( 'gallery' ) ); ?>">Gallery</a></li>
					</ul>
				</li>
				<li class="<?php echo 'careers' === $slug ? 'is-current' : ''; ?>"><a href="<?php echo esc_url( leeroy_page_url( 'careers' ) ); ?>">Careers</a></li>
				<li><a href="<?php echo esc_url( $home . '#contact' ); ?>">Contact</a></li>
			</ul>
		</nav>

		<div class="header__cta">
			<span class="header__flag"><img src="<?php echo esc_url( leeroy_img( 'botcolor.png' ) ); ?>" alt="Botswana flag" width="300" height="175"></span>
			<a class="btn btn--primary" href="<?php echo esc_url( $home . '#contact' ); ?>">Get In Touch <?php echo leeroy_icon( 'arrow-up-right' ); ?></a>
			<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-menu" aria-label="Open menu">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<main id="main">
