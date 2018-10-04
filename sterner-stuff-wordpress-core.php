<?php
/*
Plugin Name: Sterner Stuff WordPress Core
Plugin URI: https://sternerstuffdesign.com
Description: Baseline settings for Sterner Stuff WordPress sites
Version: 6.1.0
Author: Ethan Clevenger
Author URI: https://sternerstuffdesign.com
*/

class SternerStuff {
	private static $self = false;

	function __construct() {
		/* Autoloader */
		//See https://github.com/afragen/autoloader/blob/master/plugin.php
		//Plugin namespace root
		$root = [
			'SternerStuffWordPress' => __DIR__.'/SternerStuffWordPress'
		];
		$extra_classes = [];
		//Load autoloader
		require_once(__DIR__.'/SternerStuffWordPress/Autoloader.php');
		$loader = 'SternerStuffWordPress\\Autoloader';
		new $loader($root, $extra_classes);

		//Editing Experience
		new SternerStuffWordPress\EditingExperience;
		//Permissions
		new SternerStuffWordPress\Permissions;

		new SternerStuffWordPress\Mailtrap;
	}

	//Keep this method at the bottom of the class
	public static function getInstance() {
		if(!self::$self) {
			self::$self = new self();
		}
		return self::$self;
	}
}

SternerStuff::getInstance();
