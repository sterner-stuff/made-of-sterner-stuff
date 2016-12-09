<?php

namespace SternerStuffWordPress;

class EditingExperience {
  function __construct() {
    //Call later so we can filter out functionality
    add_action('after_setup_theme', [$this, 'after_setup_theme']);
  }

  public function after_setup_theme() {
    if(apply_filters('SternerStuffWordPress/EditingExperience/EditingRestrictions', true)) {
      //Filter out the higher <h> values in the editor
  		add_filter('tiny_mce_before_init', [$this, 'tiny_mce_before_init']);
    }
  }

  function tiny_mce_before_init($mceInit) {
    $mceInit['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
    return $mceInit;
  }
}
