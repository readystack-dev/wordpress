<?php
/**
 * Sets a WordPress user's password from the command line (the image has no WP-CLI):
 *   docker exec -e WP_NEW_PASSWORD='a strong password' <container> php /usr/local/lib/readystack/wp-reset-password.php <login>
 */
if ( 'cli' !== PHP_SAPI ) {
	exit( 1 );
}
$rs_login = isset( $argv[1] ) ? (string) $argv[1] : '';
$rs_pass  = (string) getenv( 'WP_NEW_PASSWORD' );
if ( '' === $rs_login || '' === trim( $rs_pass ) ) {
	fwrite( STDERR, "usage: docker exec -e WP_NEW_PASSWORD='new password' <container> php /usr/local/lib/readystack/wp-reset-password.php <user login>\n" );
	exit( 2 );
}
require '/usr/local/lib/readystack/wp-cli-env.php';
require '/var/www/html/wp-load.php';
$rs_user = get_user_by( 'login', $rs_login );
if ( ! $rs_user ) {
	readystack_cli_die( "no WordPress user with the login '$rs_login'" );
}
// Slashed, like every password WordPress' own forms store (wp-login.php, user-edit.php).
wp_set_password( wp_slash( $rs_pass ), $rs_user->ID );
echo "wordpress: set a new password for '$rs_login'\n";
