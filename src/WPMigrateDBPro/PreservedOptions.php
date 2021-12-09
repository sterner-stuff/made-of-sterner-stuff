<?php 

namespace SternerStuffWordPress\WPMigrateDBPro;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class PreservedOptions implements FilterHookSubscriber {

    private $preserved_options = [
        'easypost_licence_key', // EasyPost from Elextensions
        'easypost_activation_status',
        'easypost_instance_id',
        'easypost_email',
    ];

    public static function get_filters()
    {
        return [
            'wpmdb_preserved_options' => 'wpmdb_preserved_options',
        ];
    }

    public function wpmdb_preserved_options( $options )
    {
        return array_merge($this->preserved_options, $options);
    }

}