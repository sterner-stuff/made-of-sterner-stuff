<?php
/*
Plugin Name: Made of Sterner Stuff
Plugin URI: https://sternerstuff.dev
Description: Core functionality for built-to-last Sterner Stuff WordPress sites.
Version: 10.2.0
Author: Ethan Clevenger
Author URI: https://sternerstuff.dev
*/

use function Env\env;

use SternerStuffWordPress\Cli\Deploy;
use SternerStuffWordPress\DisableRedisProAds;
use SternerStuffWordPress\DisableTracking;
use SternerStuffWordPress\EditingExperience;
use SternerStuffWordPress\JetpackModes;
use SternerStuffWordPress\Mailtrap;
use SternerStuffWordPress\MaintenanceMode;
use SternerStuffWordPress\Permissions;
use SternerStuffWordPress\PluginAPIManager;
use SternerStuffWordPress\WooCommerce\WooCommerceSandbox;
use SternerStuffWordPress\WordPress\SiteHealthChecks;
use SternerStuffWordPress\WPMigrateDBPro\PreservedOptions;
use SternerStuffWordPress\WPRocket;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

class SternerStuffWordPress {

	private static $self = false;

	function __construct() {

		SternerStuffWordPress\EnvConstants::define();

		$manager = new PluginAPIManager();

		if(getenv('MAINTENANCE_MODE_ENABLED')) {
			$manager->register( new MaintenanceMode() );
		}

		new SternerStuffWordPress\GravityFormsCaptcha;

		new SternerStuffWordPress\LimitRevisions();

		new SternerStuffWordPress\DisabledPlugins();

        $manager->register( new EditingExperience() );
        $manager->register( new Permissions() );
        $manager->register( new Mailtrap() );
		$manager->register( new WooCommerceSandbox() );
		$manager->register( new DisableTracking() );
        $manager->register( new WPRocket() );
        $manager->register( new JetpackModes() );
        $manager->register( new DisableRedisProAds() );
        $manager->register( new SiteHealthChecks() );
        $manager->register( new PreservedOptions() );

		Deploy::register();

		if( is_plugin_active( 'wp-fail2ban/wp-fail2ban.php' ) ) {
			$this->whitelistActiveProxies();
		}

		add_filter( 'xmlrpc_enabled', '__return_false' );
	}

	public function whitelistActiveProxies() {
		/**
		 * Only one proxy whitelist should be defined at a time
		 * Otherwise you'll get constant re-defined warnings
		 */
		if( env('CLOUDFLARE_ENABLED') ) {
			new SternerStuffWordPress\CloudflareIps;
		}
		if( env('FASTLY_ENABLED') ) {
			new SternerStuffWordPress\FastlyIps;
		}
	}

	// Keep this method at the bottom of the class
	public static function getInstance() {
		if(!self::$self) {
			self::$self = new self();
		}
		return self::$self;
	}
}

SternerStuffWordPress::getInstance();
