<?php
/*
Plugin Name: Made of Sterner Stuff
Plugin URI: https://sternerstuff.dev
Description: Core functionality for built-to-last Sterner Stuff WordPress sites.
Version: 12.1.0
Author: Ethan Clevenger
Author URI: https://sternerstuff.dev
*/

use Env\Env;

use SternerStuffWordPress\Commands\Deploy;
use SternerStuffWordPress\Commands\SyncDB;
use SternerStuffWordPress\Commands\Update;
use SternerStuffWordPress\DisableRedisProAds;
use SternerStuffWordPress\DisableTracking;
use SternerStuffWordPress\EditingExperience;
use SternerStuffWordPress\GravityForms\Captcha;
use SternerStuffWordPress\GravityForms\HideUpdateMessages;
use SternerStuffWordPress\JetpackModes;
use SternerStuffWordPress\LimitRevisions;
use SternerStuffWordPress\MaintenanceMode;
use SternerStuffWordPress\Permissions;
use SternerStuffWordPress\PluginAPIManager;
use SternerStuffWordPress\QuadLayers\DisableQuadLayersPluginNotices;
use SternerStuffWordPress\TheEventsCalendar\AllowTroubleshooting;
use SternerStuffWordPress\WooCommerce\WooCommerceSandbox;
use SternerStuffWordPress\WordPress\DisableAdminEmailCheck;
use SternerStuffWordPress\WordPress\LoginErrors;
use SternerStuffWordPress\WordPress\Mailers;
use SternerStuffWordPress\WordPress\SiteHealthChecks;
use SternerStuffWordPress\WPMigrateDBPro\PreservedOptions;
use SternerStuffWordPress\WPRocket;
use SternerStuffWordPress\Yoast\DisableIndexingNotification;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

class SternerStuffWordPress {
	
	private static $self = false;
	
	function __construct() {
		
		SternerStuffWordPress\EnvConstants::define();
		
		$manager = new PluginAPIManager();
		
		if(Env::get('MAINTENANCE_MODE_ENABLED')) {
			$manager->register( new MaintenanceMode() );
		}
		
		new SternerStuffWordPress\DisabledPlugins();
		
		// WordPress
		$manager->register( new DisableAdminEmailCheck() );
		$manager->register( new Mailers() );
		$manager->register( new SiteHealthChecks() );
		$manager->register( new LoginErrors() );
		
		// WooCommerce
		$manager->register( new WooCommerceSandbox() );
		
		// Gravity Forms
		$manager->register( new Captcha() );
		$manager->register( new HideUpdateMessages() );

		// The Events Calendar
		$manager->register( new AllowTroubleshooting() );

		// Yoast
		$manager->register( new DisableIndexingNotification() );
		
		// Other plugins
		$manager->register( new WPRocket() );
		$manager->register( new JetpackModes() );
		$manager->register( new PreservedOptions() );
		$manager->register( new DisableQuadLayersPluginNotices() );
		
		$manager->register( new LimitRevisions() );
		$manager->register( new Permissions() );
		$manager->register( new EditingExperience() );
		$manager->register( new DisableTracking() );
		$manager->register( new DisableRedisProAds() );
		
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
