<?php 

namespace SternerStuffWordPress\TheEventsCalendar;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class AllowTroubleshooting implements FilterHookSubscriber {

    public static function get_filters()
    {
        return [
            'tec_troubleshooting_capability' => 'tec_troubleshooting_capability',
        ];
    }

    public function tec_troubleshooting_capability( $capability )
    {
        return 'manage_options';
    }

}