<?php
/**
 * Security hardening for a brochure site: hide user accounts from the public,
 * turn off unused remote-publishing endpoints and send basic security headers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Nobody posts to this site from desktop apps: switch off XML-RPC and pingbacks. */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );
add_filter( 'wp_headers', function ( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
} );
add_filter( 'pings_open', '__return_false' );

/* News has no comment section, so close comments (stops wp-comments-post.php spam). */
add_filter( 'comments_open', '__return_false' );

/* Don't advertise the WordPress version or legacy editor endpoints. */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

/* Keep login names private: no author archives or ?author=N lookups... */
add_action( 'template_redirect', function () {
	if ( is_author() || isset( $_GET['author'] ) ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
	}
}, 1 );

/* ...no user list in the REST API for visitors (editors are logged in)... */
add_filter( 'rest_endpoints', function ( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		foreach ( array_keys( $endpoints ) as $route ) {
			if ( 0 === strpos( $route, '/wp/v2/users' ) ) {
				unset( $endpoints[ $route ] );
			}
		}
	}
	return $endpoints;
} );

/* ...no users sitemap, and no author name in oEmbed previews. */
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
	return 'users' === $name ? false : $provider;
}, 10, 2 );
add_filter( 'oembed_response_data', function ( $data ) {
	unset( $data['author_name'], $data['author_url'] );
	return $data;
} );

/* Author links in feeds and markup point home rather than to /author/<login>/. */
add_filter( 'author_link', function () {
	return home_url( '/' );
} );

/* Basic security headers (a Content-Security-Policy is left to the host/CDN). */
add_action( 'send_headers', function () {
	if ( headers_sent() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()' );
	if ( is_ssl() ) {
		header( 'Strict-Transport-Security: max-age=31536000' );
	}
} );

/**
 * Visitor IP for rate limiting. Behind a proxy (Render, Cloudflare) every
 * request comes from the proxy, so trust X-Forwarded-For only when
 * LEEROY_TRUST_PROXY is defined in wp-config.php.
 */
function leeroy_client_ip(): string {
	if ( defined( 'LEEROY_TRUST_PROXY' ) && LEEROY_TRUST_PROXY && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ips = explode( ',', sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) );
		return trim( $ips[0] );
	}
	return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
}

/** True when this visitor has sent too many forms recently (5 per 10 minutes). */
function leeroy_form_rate_limited(): bool {
	$key   = 'leeroy_form_rl_' . md5( leeroy_client_ip() );
	$count = (int) get_transient( $key );
	if ( $count >= 5 ) {
		return true;
	}
	set_transient( $key, $count + 1, 10 * MINUTE_IN_SECONDS );
	return false;
}
