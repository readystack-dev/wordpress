<?php
/**
 * Plugin Name: ReadyStack SQLite Site Health
 * Description: Loads the Site Health adjustments of WordPress.org's SQLite Database Integration (shipped in the image at /usr/src/wordpress/sqlite-database-integration) unless that plugin is itself active. Managed by the container entrypoint.
 */
add_action(
	'plugins_loaded',
	static function () {
		if ( ! defined( 'SQLITE_MAIN_FILE' ) && defined( 'DB_ENGINE' ) && 'sqlite' === DB_ENGINE && ! function_exists( 'sqlite_plugin_filter_debug_data' ) ) {
			require_once '/usr/src/wordpress/sqlite-database-integration/health-check.php';
		}
	}
);
