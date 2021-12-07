<?php 

namespace SternerStuffWordPress\WordPress;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class DisableAdminEmailCheck implements FilterHookSubscriber {

    public static function get_filters()
    {
        return [
            'admin_email_check_interval' => 'admin_email_check_interval',
        ];
    }

    public function admin_email_check_interval( $interval )
    {
        return false;
    }

}