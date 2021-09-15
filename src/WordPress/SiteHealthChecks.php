<?php 

namespace SternerStuffWordPress\WordPress;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class SiteHealthChecks implements FilterHookSubscriber {

    public static function get_filters()
    {
        return [
            'site_status_tests' => 'site_status_tests',
        ];
    }

    public function site_status_tests( $tests )
    {
        unset($tests['direct']['wordpress_version']);
        unset($tests['direct']['plugin_version']);
        unset($tests['direct']['theme_version']);
        unset($tests['direct']['plugin_theme_auto_updates']);
        unset($tests['async']['background_updates']);

        return $tests;
    }

}