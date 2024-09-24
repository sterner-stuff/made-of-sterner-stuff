<?php 

namespace SternerStuffWordPress\Yoast;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class DisableIndexingNotification implements FilterHookSubscriber {

    public static function get_filters()
    {
        return [
            'ignore_search_engines_discouraged_notice' => 'ignore_search_engines_discouraged_notice',
        ];
    }

    public function ignore_search_engines_discouraged_notice( $ignore )
	{
		if( wp_get_environment_type() !== 'production' ) {
			return true;
		}
		return $ignore;
	}

}