<?php 

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class JetpackModes implements FilterHookSubscriber {

    public static function get_filters()
    {
        return [
            'jetpack_offline_mode' => 'jetpack_offline_mode',
            'jetpack_is_staging_site' => 'jetpack_is_staging_site',
        ];
    }

    public function jetpack_offline_mode( $offline_mode_enabled )
    {
        if(defined( 'WP_ENV' ) && (WP_ENV == 'dev' || WP_ENV == 'development')) {
            $offline_mode_enabled = true;
        }
        return $offline_mode_enabled;
    }

    public function jetpack_is_staging_site( $is_staging_site )
    {
        if(defined( 'WP_ENV' ) && (WP_ENV == 'staging')) {
            $is_staging_site = true;
        }
        return $is_staging_site;
    }

}