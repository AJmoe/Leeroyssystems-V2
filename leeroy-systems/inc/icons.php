<?php
/**
 * Inline SVG icon set (stroke icons, 24px grid).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function leeroy_icon( string $name, string $class = '' ): string {
	$icons = [
		'arrow-right' => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
		'arrow-up-right' => '<path d="M7 17 17 7"/><path d="M8 7h9v9"/>',
		'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
		'chevron-left' => '<path d="m15 18-6-6 6-6"/>',
		'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
		'facebook'    => '<path d="M15 8h-2a2 2 0 0 0-2 2v2H8v3h3v6h3v-6h3l1-3h-4v-2a1 1 0 0 1 1-1h3V6h-3Z"/>',
		'linkedin'    => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4V9h4v2"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>',
		'youtube'     => '<path d="M22 12s0-3.3-.4-4.8a3 3 0 0 0-2.1-2.1C17.7 4.6 12 4.6 12 4.6s-5.7 0-7.5.5a3 3 0 0 0-2.1 2.1C2 8.7 2 12 2 12s0 3.3.4 4.8a3 3 0 0 0 2.1 2.1c1.8.5 7.5.5 7.5.5s5.7 0 7.5-.5a3 3 0 0 0 2.1-2.1c.4-1.5.4-4.8.4-4.8Z"/><path d="m10 15 5-3-5-3v6Z"/>',
		'pin'         => '<path d="M12 21s7-5.1 7-11a7 7 0 1 0-14 0c0 5.9 7 11 7 11Z"/><circle cx="12" cy="10" r="2.4"/>',
		'mail'        => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
		'phone'       => '<path d="M22 16.9V20a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 2 4.2 2 2 0 0 1 4 2h3.1a2 2 0 0 1 2 1.7c.1 1 .4 2 .8 3a2 2 0 0 1-.4 2.1L8.1 10.2a16 16 0 0 0 5.7 5.7l1.4-1.4a2 2 0 0 1 2.1-.4c1 .4 2 .7 3 .8a2 2 0 0 1 1.7 2Z"/>',
		'check'       => '<path d="m20 6-11 11-5-5"/>',
		'check-circle' => '<circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5 4.5-5"/>',
		'gauge'       => '<path d="M12 14 15.5 8.5"/><circle cx="12" cy="14" r="1.6"/><path d="M3.5 18a9 9 0 1 1 17 0"/>',
		'chart'       => '<path d="M3 3v18h18"/><path d="m7 15 4-4 3 3 5-6"/>',
		'antenna'     => '<path d="M4.9 16.1C1 12.2 1 5.8 4.9 1.9"/><path d="M7.8 4.7a6.1 6.1 0 0 0-.8 7.5"/><circle cx="12" cy="9" r="2"/><path d="M16.2 4.8c2 2 2.3 5.1.8 7.5"/><path d="M19.1 1.9a10 10 0 0 1 0 14.1"/><path d="M9.5 18h5"/><path d="m8 22 4-11 4 11"/>',
		'code'        => '<rect x="3" y="4" width="18" height="14" rx="2"/><path d="m9.5 9-2 2 2 2"/><path d="m14.5 9 2 2-2 2"/><path d="M8 21h8"/>',
		'award'       => '<circle cx="12" cy="9" r="6"/><path d="m8.5 14 -1.5 7 5-3 5 3-1.5-7"/>',
		'flag'        => '<path d="M5 21V4"/><path d="M5 4h11l-2 4 2 4H5"/>',
		'users'       => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9"/><path d="M16 3.1a4 4 0 0 1 0 7.8"/>',
		'shield'      => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/>',
		'handshake'   => '<path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.9-3.9a3 3 0 0 0-4.2 0l-.9.9a1 1 0 1 1-3-3l2.8-2.8a5.8 5.8 0 0 1 7 .9L21 7.2"/><path d="m21 3 1 11h-2"/><path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3"/><path d="M3 4h8"/>',
		'bulb'        => '<path d="M9 18h6"/><path d="M10 22h4"/><path d="M12 2a7 7 0 0 0-4 12.7V17h8v-2.3A7 7 0 0 0 12 2Z"/>',
		'smile'       => '<circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><path d="M9 9h.01"/><path d="M15 9h.01"/>',
		'leaf'        => '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.5 19 2c1 2 2 4.2 2 8 0 5.5-4.8 10-10 10Z"/><path d="M2 21c0-3 1.9-5.4 5.2-6"/>',
		'target'      => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/>',
		'calendar'    => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4"/><path d="M8 3v4"/><path d="M3 10h18"/>',
		'clock'       => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
		'play'        => '<path d="M7 4v16l13-8Z"/>',
		'camera'      => '<path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z"/><circle cx="12" cy="13" r="3.5"/>',
		'growth'      => '<path d="m22 7-8.5 8.5-5-5L2 17"/><path d="M16 7h6v6"/>',
		'briefcase'   => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><path d="M2 13h20"/>',
		'heart'       => '<path d="M19 14c1.5-1.5 3-3.2 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.8 0-3 .5-4.5 2-1.5-1.5-2.7-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4 3 5.5l7 7Z"/>',
		'upload'      => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m17 8-5-5-5 5"/><path d="M12 3v12"/>',
		'close'       => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
		'quote'       => '<path d="M3 21c3 0 7-1 7-8V5H3v7h4c0 3-1 5-4 5"/><path d="M14 21c3 0 7-1 7-8V5h-7v7h4c0 3-1 5-4 5"/>',
	];

	$paths = $icons[ $name ] ?? $icons['check'];
	$class = trim( 'icon ' . $class );

	return '<svg class="' . esc_attr( $class ) . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths . '</svg>';
}
