<?php 

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\ActionHookSubscriber;
use Roots\WPConfig\Config;

class DisableRedisProAds implements ActionHookSubscriber {

    public static function get_actions()
    {
        return [
            'admin_init' => 'admin_init',
        ];
    }

    public function admin_init()
    {
        Config::define( 'WP_REDIS_DISABLE_BANNERS', true );
        Config::apply();
    }

}