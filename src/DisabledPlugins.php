<?php

namespace SternerStuffWordPress;

use Roots\WPConfig\Config;

/**
 * Disable plugins based on environment.
 */
class DisabledPlugins {

	function __construct() {
		
		if(getenv('WP_ENV') != 'development' || defined('DISABLED_PLUGINS')) return;
		
		Config::define('DISABLED_PLUGINS', [
			'google-analytics-for-wordpress/googleanalytics.php',
			'google-site-kit/google-site-kit.php',
			'ga-google-analytics/ga-google-analytics.php',
			'gravity-forms-google-analytics-event-tracking/gravity-forms-event-tracking.php',
			'iwp-client/init.php',
			'official-facebook-pixel/facebook-for-wordpress.php',
			'tiny-compress-images/tiny-compress-images.php',
			'wp-fastest-cache/wpFastestCache.php',
		]);

		Config::apply();
	}
}

