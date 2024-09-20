<?php

namespace SternerStuffWordPress\GravityForms;

use SternerStuffWordPress\Interfaces\ActionHookSubscriber;

/**
 * Hide Gravity Forms update messages
 */
class HideUpdateMessages implements ActionHookSubscriber {

	public static function get_actions() { 
		return [
			'admin_print_styles' => 'admin_print_styles',
		];
	}

	public function admin_print_styles()
	{
		echo '<style>#gf_dashboard_message { display: none; }</style>';
	}
}
