<?php 

namespace SternerStuffWordPress\Kinsta;

use Roots\WPConfig\Config;
use SternerStuffWordPress\Interfaces\ActionHookSubscriber;

class CDN implements ActionHookSubscriber {

    public static function get_actions() {
		return [
			'init' => 'init',
		];
	}

	public function init()
	{
		Config::define('KINSTA_CDN_USERDIRS', 'app');
		Config::apply();
	}

}