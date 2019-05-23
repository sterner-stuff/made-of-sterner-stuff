<?php 

namespace SternerStuffWordPress;

use Roots\WPConfig\Config;

/**
 * Set constants for a variety of premium plugins
 */
class Constants {
	
	public static function define() {

		/**
		 * Configure WP Offload Media
		 */
		if(($access_key_id = env('OFFLOAD_MEDIA_ACCESS_KEY_ID')) && ($secret_access_key = env('OFFLOAD_MEDIA_SECRET_ACCESS_KEY')) ) {
		    define( 'AS3CF_SETTINGS', serialize( array(
		        'provider' => env('OFFLOAD_MEDIA_PROVIDER') ?: 'do',
		        'access-key-id' => $access_key_id,
		        'secret-access-key' => $secret_access_key,
		    ) ) );
		}

		/**
		 * Configure WP Migrate DB Pro license
		 */
		Config::define('WPMDB_LICENCE', env('WPMDB_LICENCE'));

		/**
		 * Configure WP Offload Media license
		 */
		Config::define('AS3CFPRO_LICENCE', env('AS3CFPRO_LICENCE'));

		/**
		 * Configure Gravity Forms license
		 */
		Config::define('GF_LICENSE_KEY', env('GF_LICENSE_KEY'));

		/**
		 * Configure TinyPNG API Key
		 */
		Config::define('TINY_API_KEY', env('TINY_API_KEY'));

		/**
		 * Apply new constants
		 */
		Config::apply();

	}
}