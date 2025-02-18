<?php 

namespace SternerStuffWordPress\Yoast;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class DisableIndexingNotification implements FilterHookSubscriber {
	
	public static function get_filters()
	{
		return [
			'option_wpseo' => 'ignore_search_engines_discouraged_notice',
		];
	}
	
	public function ignore_search_engines_discouraged_notice( $option )
	{
		if( wp_get_environment_type() !== 'production' ) {
			$option['ignore_search_engines_discouraged_notice'] = true;
		}
		return $option;
	}
	
}