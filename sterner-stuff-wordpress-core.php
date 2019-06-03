<?php
/*
Plugin Name: Sterner Stuff WordPress Core
Plugin URI: https://sternerstuffdesign.com
Description: Baseline settings for Sterner Stuff WordPress sites
Version: 7.1.1
Author: Ethan Clevenger
Author URI: https://sternerstuffdesign.com
*/

class SternerStuffWordPress {
	private static $self = false;

	function __construct() {

		new SternerStuffWordPress\EditingExperience;

		new SternerStuffWordPress\Permissions;

		new SternerStuffWordPress\Mailtrap;

		new SternerStuffWordPress\GravityFormsCaptcha;

		new SternerStuffWordPress\LimitRevisions();

		SternerStuffWordPress\Constants::define();
		
	}

	//Keep this method at the bottom of the class
	public static function getInstance() {
		if(!self::$self) {
			self::$self = new self();
		}
		return self::$self;
	}
}

SternerStuffWordPress::getInstance();
