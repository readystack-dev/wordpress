<?php
/**
 * Request variables WordPress expects when it is loaded from the command line, taken from WORDPRESS_URL, and a
 * wp_die() handler that fails the script (WordPress' default handler prints an HTML page and exits with status 0).
 */
if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}
$readystack_url   = rtrim( (string) ( getenv( 'WORDPRESS_URL' ) ?: 'http://localhost:8080' ), '/' );
$readystack_parts = parse_url( $readystack_url );
if ( ! is_array( $readystack_parts ) || empty( $readystack_parts['host'] )
	|| ! in_array( $readystack_parts['scheme'] ?? '', array( 'http', 'https' ), true )
	|| '' !== trim( (string) ( $readystack_parts['path'] ?? '' ), '/' ) ) {
	fwrite( STDERR, "wordpress: WORDPRESS_URL must be the site's root address, http:// or https:// with no path (got '$readystack_url')\n" );
	exit( 1 );
}
$_SERVER['HTTP_HOST']       = $readystack_parts['host'] . ( isset( $readystack_parts['port'] ) ? ':' . $readystack_parts['port'] : '' );
$_SERVER['SERVER_NAME']     = $readystack_parts['host'];
$_SERVER['SERVER_PORT']     = (string) ( $readystack_parts['port'] ?? ( 'https' === $readystack_parts['scheme'] ? 443 : 80 ) );
$_SERVER['REQUEST_URI']     = '/';
$_SERVER['REQUEST_METHOD']  = 'GET';
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
if ( 'https' === $readystack_parts['scheme'] ) {
	$_SERVER['HTTPS'] = 'on';
}

function readystack_cli_die( $message ) {
	if ( function_exists( 'is_wp_error' ) && is_wp_error( $message ) ) {
		$message = $message->get_error_message();
	}
	fwrite( STDERR, 'wordpress: ' . trim( html_entity_decode( strip_tags( (string) $message ) ) ) . "\n" );
	exit( 1 );
}
// A pre-initialised hook (WP_Hook::build_preinitialized_hooks), so it also covers failures while WordPress loads.
$GLOBALS['wp_filter']['wp_die_handler'][10][] = array(
	'function'      => static function () {
		return 'readystack_cli_die';
	},
	'accepted_args' => 1,
);
