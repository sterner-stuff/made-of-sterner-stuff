<?php 

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class WPRocket implements FilterHookSubscriber {

	public static function get_filters()
	{
		return [
			'rocket_set_wp_cache_constant' => 'disable_rocket_set_wp_cache_constant',
		];
	}

	public function disable_rocket_set_wp_cache_constant( $set )
	{
		return false;
	}

}
