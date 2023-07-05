<?php

namespace SternerStuffWordPress\GravityForms;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

/**
 * Hide Gravity Forms update messages
 */
class HideUpdateMessages implements FilterHookSubscriber {

	public static function get_filters() { 
		return [
			'option_gf_env_hide_background_updates' => '__return_true',
			'option_gf_env_hide_update_message' => '__return_true',
		];
	}
}