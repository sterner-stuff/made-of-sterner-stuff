<?php

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\ActionHookSubscriber;

/**
 * Don't allow users to add H1s
 */
class EditingExperience implements ActionHookSubscriber {
  
    public static function get_actions()
    {
        return [
            'after_setup_theme' => 'after_setup_theme',
        ];
    }

    public function after_setup_theme() {
        if(apply_filters('SternerStuffWordPress/EditingExperience/EditingRestrictions', true)) {
            //Filter out the higher <h> values in the editor
            add_filter('tiny_mce_before_init', [$this, 'tiny_mce_before_init']);
        }
    }

    public function tiny_mce_before_init($mceInit) {
        $mceInit['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
        return $mceInit;
    }
}
