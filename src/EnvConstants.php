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
		if(($access_key_id = getenv('OFFLOAD_MEDIA_ACCESS_KEY_ID')) && ($secret_access_key = getenv('OFFLOAD_MEDIA_SECRET_ACCESS_KEY')) ) {
		    define( 'AS3CF_SETTINGS', serialize( array(
		        'provider' => getenv('OFFLOAD_MEDIA_PROVIDER') ?: 'do',
		        'access-key-id' => $access_key_id,
		        'secret-access-key' => $secret_access_key,
		    ) ) );
		}

		/**
		 * Configure WP Migrate DB Pro license
		 */
		if(getenv('WPMDB_LICENCE')):
			Config::define('WPMDB_LICENCE', getenv('WPMDB_LICENCE'));
		endif;
		
		/**
		 * Configure WP Offload Media license
		 */
		if(getenv('AS3CFPRO_LICENCE')):
			Config::define('AS3CFPRO_LICENCE', getenv('AS3CFPRO_LICENCE'));
		endif;

		/**
		 * Configure Gravity Forms license
		 */
		if(getenv('GF_LICENSE_KEY')):
			Config::define('GF_LICENSE_KEY', getenv('GF_LICENSE_KEY'));
		endif;

		/**
		 * Configure TinyPNG API Key
		 */
		if(getenv('TINY_API_KEY')):
			Config::define('TINY_API_KEY', getenv('TINY_API_KEY'));
		endif;

		/**
		 * Configure Mailgun
		 */
		Config::define('MAILGUN_USEAPI', getenv('MAILGUN_USEAPI') ?? true);
		Config::define('MAILGUN_REGION', getenv('MAILGUN_REGION') ?? 'us');

		if(getenv('MAILGUN_APIKEY')):
			Config::define('MAILGUN_APIKEY', getenv('MAILGUN_APIKEY'));
		endif;

		if(getenv('MAILGUN_DOMAIN')):
			Config::define('MAILGUN_DOMAIN', getenv('MAILGUN_DOMAIN'));
		endif;

		/**
		 * Apply new constants
		 */
		Config::apply();

	}
}