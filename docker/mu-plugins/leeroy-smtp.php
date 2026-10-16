<?php
/**
 * Plugin Name: Leeroy SMTP (env)
 * Description: Sends WordPress email (contact and careers forms) through SMTP when SMTP_HOST is set in the environment. Without it, the container has no mail server and forms cannot deliver email.
 */

if ( ! defined( 'ABSPATH' ) || ! getenv( 'SMTP_HOST' ) ) {
	return;
}

add_action( 'phpmailer_init', function ( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->Host       = getenv( 'SMTP_HOST' );
	$phpmailer->Port       = (int) ( getenv( 'SMTP_PORT' ) ?: 587 );
	$phpmailer->SMTPSecure = getenv( 'SMTP_SECURE' ) ?: 'tls';
	if ( getenv( 'SMTP_USER' ) ) {
		$phpmailer->SMTPAuth = true;
		$phpmailer->Username = getenv( 'SMTP_USER' );
		$phpmailer->Password = (string) getenv( 'SMTP_PASS' );
	}
	$from = getenv( 'SMTP_FROM' ) ?: getenv( 'SMTP_USER' );
	if ( $from ) {
		$phpmailer->setFrom( $from, 'Leeroy Systems Website', false );
	}
} );
