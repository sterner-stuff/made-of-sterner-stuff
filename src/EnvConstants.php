<?php 

namespace SternerStuffWordPress;

use Roots\WPConfig\Config;

/**
 * Set constants for a variety of premium plugins
 */
class EnvConstants {
	
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
		if(env('WPMDB_LICENCE')):
			Config::define('WPMDB_LICENCE', env('WPMDB_LICENCE'));
		endif;
		
		/**
		 * Configure WP Offload Media license
		 */
		if(env('AS3CFPRO_LICENCE')):
			Config::define('AS3CFPRO_LICENCE', env('AS3CFPRO_LICENCE'));
		endif;

		/**
		 * Configure Gravity Forms license
		 */
		if(env('GF_LICENSE_KEY')):
			Config::define('GF_LICENSE_KEY', env('GF_LICENSE_KEY'));
		endif;

		/**
		 * Configure TinyPNG API Key
		 */
		if(env('TINY_API_KEY')):
			Config::define('TINY_API_KEY', env('TINY_API_KEY'));
		endif;

		/**
		 * Configure Mailgun
		 */
		Config::define('MAILGUN_USEAPI', env('MAILGUN_USEAPI') ?? true);
		Config::define('MAILGUN_REGION', env('MAILGUN_REGION') ?? 'us');

		if(env('MAILGUN_APIKEY')):
			Config::define('MAILGUN_APIKEY', env('MAILGUN_APIKEY'));
		endif;

		if(env('MAILGUN_DOMAIN')):
			Config::define('MAILGUN_DOMAIN', env('MAILGUN_DOMAIN'));
		endif;

		if(env('MAILGUN_FROM_ADDRESS')):
			Config::define('MAILGUN_FROM_ADDRESS', env('MAILGUN_FROM_ADDRESS'));
		endif;

		/**
		 * WP-Rocket
		 */
		Config::define('WP_ROCKET_EMAIL', env('WP_ROCKET_EMAIL') ?? null);
		Config::define('WP_ROCKET_KEY', env('WP_ROCKET_KEY') ?? null);

		/**
		 * Apply new constants
		 */
		Config::apply();

	}
}