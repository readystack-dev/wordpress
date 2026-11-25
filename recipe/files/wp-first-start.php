<?php
/**
 * ReadyStack first start, run by the entrypoint as www-data before Apache starts:
 *  1. writes this instance's keys and salts once, to /var/lib/wordpress/wp-keys.php (mode 600);
 *  2. when the database holds no WordPress yet, installs it with WordPress' own wp_install(), the function
 *     wp-admin/install.php calls, so the web installer is never needed (and the image never serves it).
 */
if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}
$rs_data = '/var/lib/wordpress';
$rs_keys = $rs_data . '/wp-keys.php';
if ( ! is_file( $rs_keys ) || 0 === filesize( $rs_keys ) ) {
	$rs_php = "<?php\n// This instance's keys and salts, generated at its first start. Deleting this file signs everyone out.\n";
	foreach ( array( 'AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY', 'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT' ) as $rs_name ) {
		$rs_php .= "define( '" . $rs_name . "', '" . bin2hex( random_bytes( 32 ) ) . "' );\n";
	}
	$rs_umask = umask( 077 );
	$rs_ok    = false !== file_put_contents( $rs_keys . '.tmp', $rs_php ) && rename( $rs_keys . '.tmp', $rs_keys );
	umask( $rs_umask );
	if ( ! $rs_ok ) {
		fwrite( STDERR, "wordpress: cannot write $rs_keys - $rs_data must be writable by www-data (uid 33)\n" );
		exit( 1 );
	}
	echo "wordpress: generated this instance's keys and salts into $rs_keys\n";
}

require '/usr/local/lib/readystack/wp-cli-env.php';
define( 'WP_INSTALLING', true );
require '/var/www/html/wp-load.php';
if ( is_blog_installed() ) {
	exit( 0 );
}

// wp_install() mails the new administrator their login; the image has no mail transport, so skip it (as WP-CLI does).
function wp_new_blog_notification( $blog_title, $blog_url, $user_id, $password ) {}
require_once ABSPATH . 'wp-admin/includes/upgrade.php';

$rs_user  = (string) readystack_env( 'WORDPRESS_ADMIN_USER', 'admin' );
$rs_email = (string) readystack_env( 'WORDPRESS_ADMIN_EMAIL', 'admin@example.com' );
$rs_title = (string) readystack_env( 'WORDPRESS_TITLE', 'WordPress' );
$rs_pass  = (string) readystack_env( 'WORDPRESS_ADMIN_PASSWORD' );
if ( ! validate_username( $rs_user ) ) {
	readystack_cli_die( "WORDPRESS_ADMIN_USER '$rs_user' is not a valid WordPress username" );
}
if ( ! is_email( $rs_email ) ) {
	readystack_cli_die( "WORDPRESS_ADMIN_EMAIL '$rs_email' is not a valid email address" );
}
if ( '' === trim( $rs_pass ) ) {
	$rs_pass  = wp_generate_password( 24, false );
	$rs_umask = umask( 077 );
	file_put_contents( $rs_data . '/initial_admin_password', $rs_pass . "\n" );
	umask( $rs_umask );
	echo "wordpress: WORDPRESS_ADMIN_PASSWORD is not set - generated the administrator password into $rs_data/initial_admin_password\n";
}
// Slashed, as wp-admin/install.php passes it: the login form compares the slashed password.
wp_install( $rs_title, $rs_user, $rs_email, true, '', wp_slash( $rs_pass ) );
if ( ! is_blog_installed() ) {
	readystack_cli_die( 'the WordPress install did not complete' );
}
// The permalink structure the web installer picks on Apache with mod_rewrite
// (wp_install_maybe_enable_pretty_permalinks(), which cannot detect Apache from the command line).
$GLOBALS['wp_rewrite']->set_permalink_structure( '/%year%/%monthnum%/%day%/%postname%/' );
flush_rewrite_rules( false );
echo 'wordpress: installed WordPress at ' . home_url() . " with the administrator '$rs_user'\n";
