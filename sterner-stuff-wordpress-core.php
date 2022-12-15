<?php
/*
Plugin Name: Made of Sterner Stuff
Plugin URI: https://sternerstuff.dev
Description: Core functionality for built-to-last Sterner Stuff WordPress sites.
Version: 11.3.1
Author: Ethan Clevenger
Author URI: https://sternerstuff.dev
*/

use function Env\env;

use SternerStuffWordPress\Commands\Deploy;
use SternerStuffWordPress\Commands\SyncDB;
use SternerStuffWordPress\Commands\Update;
use SternerStuffWordPress\DisableRedisProAds;
use SternerStuffWordPress\DisableTracking;
use SternerStuffWordPress\EditingExperience;
use SternerStuffWordPress\GravityFormsCaptcha;
use SternerStuffWordPress\JetpackModes;
use SternerStuffWordPress\LimitRevisions;
use SternerStuffWordPress\MaintenanceMode;
use SternerStuffWordPress\Permissions;
use SternerStuffWordPress\PluginAPIManager;
use SternerStuffWordPress\WooCommerce\WooCommerceSandbox;
use SternerStuffWordPress\WordPress\DisableAdminEmailCheck;
use SternerStuffWordPress\WordPress\Mailers;
use SternerStuffWordPress\WordPress\SiteHealthChecks;
use SternerStuffWordPress\WPMigrateDBPro\PreservedOptions;
use SternerStuffWordPress\WPRocket;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

class SternerStuffWordPress {
	
	private static $self = false;
	
	function __construct() {
		
		SternerStuffWordPress\EnvConstants::define();
		
		$manager = new PluginAPIManager();
		
		if(env('MAINTENANCE_MODE_ENABLED')) {
			$manager->register( new MaintenanceMode() );
		}
		
		new SternerStuffWordPress\DisabledPlugins();
		
		$manager->register( new EditingExperience() );
		$manager->register( new Permissions() );
		$manager->register( new Mailers() );
		$manager->register( new WooCommerceSandbox() );
		$manager->register( new DisableTracking() );
		$manager->register( new WPRocket() );
		$manager->register( new JetpackModes() );
		$manager->register( new DisableRedisProAds() );
		$manager->register( new SiteHealthChecks() );
		$manager->register( new PreservedOptions() );
		$manager->register( new DisableAdminEmailCheck() );
		$manager->register( new LimitRevisions() );
		$manager->register( new GravityFormsCaptcha() );
		
		if(defined( 'WP_CLI' ) && constant('WP_CLI')) {
			Deploy::register();
			Update::register();
			SyncDB::register();
		}
		
		add_filter( 'xmlrpc_enabled', '__return_false' );
		define('KINSTAMU_CUSTOM_MUPLUGIN_URL', WPMU_PLUGIN_URL . '/kinsta-mu-plugins/');
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
