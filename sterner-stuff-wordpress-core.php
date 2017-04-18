<?php
/*
Plugin Name: Sterner Stuff WordPress Core
Plugin URI: https://sternerstuffdesign.com
Description: Baseline settings for Sterner Stuff WordPress sites
Version: 5.1.3
Author: Ethan Clevenger
Author URI: https://sternerstuffdesign.com
BitBucket Plugin URI: https://github.com/ethanclevenger91/sterner-stuff-design-core
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
		//Version Control
		new SternerStuffWordPress\VersionControl;
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
