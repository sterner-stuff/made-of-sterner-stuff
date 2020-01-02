<?php
/*
Plugin Name: Sterner Stuff WordPress Core
Plugin URI: https://sternerstuffdesign.com
Description: Baseline settings for Sterner Stuff WordPress sites
Version: 7.6.0
Author: Ethan Clevenger
Author URI: https://sternerstuffdesign.com
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

class SternerStuffWordPress {

	private static $self = false;

	function __construct() {

		new SternerStuffWordPress\EditingExperience;

		new SternerStuffWordPress\Permissions;

		new SternerStuffWordPress\Mailtrap;

		new SternerStuffWordPress\GravityFormsCaptcha;

		new SternerStuffWordPress\LimitRevisions();

		new SternerStuffWordPress\DisabledPlugins();

		new SternerStuffWordPress\DisableSiteKitTracking();

		SternerStuffWordPress\EnvConstants::define();

		if( is_plugin_active( 'wp-fail2ban/wp-fail2ban.php' ) ) {
			$this->whitelistActiveProxies();
		}		
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
