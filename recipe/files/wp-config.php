<?php
/**
 * ReadyStack WordPress configuration. Shipped read-only in the image: every setting comes from the container
 * environment, this instance's keys and salts are generated at its first start into /var/lib/wordpress/wp-keys.php
 * (never baked into the image), and /var/lib/wordpress/wp-config-extra.php, when present, adds your own constants.
 */
if ( ! function_exists( 'readystack_env' ) ) {
	function readystack_env( $name, $fallback = '' ) {
		$value = getenv( $name );
		return ( false === $value || '' === $value ) ? $fallback : $value;
	}
}

if ( '' !== readystack_env( 'WORDPRESS_DB_HOST' ) ) {
	// MySQL or MariaDB, the databases WordPress is built for.
	define( 'DB_HOST', readystack_env( 'WORDPRESS_DB_HOST' ) );
	define( 'DB_NAME', readystack_env( 'WORDPRESS_DB_NAME', 'wordpress' ) );
	define( 'DB_USER', readystack_env( 'WORDPRESS_DB_USER', 'wordpress' ) );
	define( 'DB_PASSWORD', readystack_env( 'WORDPRESS_DB_PASSWORD' ) );
} else {
	// Default: an embedded SQLite database through WordPress.org's SQLite Database Integration drop-in
	// (wp-content/db.php), stored on the data volume outside the web root.
	define( 'DB_ENGINE', 'sqlite' );
	define( 'DB_DIR', '/var/lib/wordpress/database/' );
	define( 'DB_FILE', '.ht.sqlite' );
	define( 'DB_NAME', 'wordpress' );
	define( 'DB_USER', '' );
	define( 'DB_PASSWORD', '' );
	define( 'DB_HOST', '' );
}
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
$table_prefix = readystack_env( 'WORDPRESS_TABLE_PREFIX', 'wp_' );

require '/var/lib/wordpress/wp-keys.php';

// Your own wp-config.php constants. Loaded before the defaults below, so a constant defined there wins.
if ( is_file( '/var/lib/wordpress/wp-config-extra.php' ) ) {
	require '/var/lib/wordpress/wp-config-extra.php';
}

// The address people open, with no path (the image serves WordPress at /). The entrypoint defaults it to
// http://localhost:8080.
if ( '' !== readystack_env( 'WORDPRESS_URL' ) ) {
	defined( 'WP_HOME' ) || define( 'WP_HOME', rtrim( readystack_env( 'WORDPRESS_URL' ), '/' ) );
	defined( 'WP_SITEURL' ) || define( 'WP_SITEURL', rtrim( readystack_env( 'WORDPRESS_URL' ), '/' ) );
}
// TLS ended by a reverse proxy in front of the container (WordPress' documentation for reverse proxies).
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && false !== strpos( $_SERVER['HTTP_X_FORWARDED_PROTO'], 'https' ) ) {
	$_SERVER['HTTPS'] = 'on';
}
// WordPress core is read-only in this image (updated by pulling a new image); themes, plugins and uploads live
// on the wp-content volume, which www-data owns.
defined( 'FS_METHOD' ) || define( 'FS_METHOD', 'direct' );
defined( 'WP_AUTO_UPDATE_CORE' ) || define( 'WP_AUTO_UPDATE_CORE', false );
defined( 'DISALLOW_FILE_EDIT' ) || define( 'DISALLOW_FILE_EDIT', true );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
