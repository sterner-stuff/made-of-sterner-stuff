<?php

namespace SternerStuffWordPress;

use \WP_User;

class Permissions {
  public function __construct() {
    //Call later so we can filter out functionality
    add_action('after_setup_theme', [$this, 'after_setup_theme']);
  }

  public function after_setup_theme() {
    if(apply_filters('SternerStuffWordPress/Permissions/UsePermissions', true)) {
      // Editor (default client role) gets extra permissions
  		$this->editor_roles();

      //prevent users from creating higher level users
  		add_filter( 'editable_roles', [$this, 'disable_higher_users_select']);
      add_filter( 'map_meta_cap', [$this, 'disable_higher_users_edit'], 10, 4);
    }
  }

  //extra caps for editors
	public function editor_roles() {
		$caps_set = get_option('ws_caps_set');
		if(!$caps_set) {
			$role = get_role('editor');
			$caps = ['edit_theme_options', 'edit_users', 'list_users', 'remove_users', 'add_users', 'delete_users', 'create_users', 'edit_theme_options', 'gform_full_access'];
      $caps = apply_filters('SternerStuffWordPress/Permissions/CapsToAdd', $caps);
			foreach($caps as $cap) {
				$role->add_cap($cap);
			}
			update_option('ws_caps_set', true);
		}
	}

  // Remove 'Administrator' from the list of roles if the current user is not an admin
  function disable_higher_users_select( $roles ){
    if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
      unset( $roles['administrator']);
    }
    return $roles;
  }

  // If someone is trying to edit or delete and admin and that user isn't an admin, don't allow it
  function disable_higher_users_edit( $caps, $cap, $user_id, $args ){

    switch( $cap ){
        case 'edit_user':
        case 'remove_user':
        case 'promote_user':
            if( isset($args[0]) && $args[0] == $user_id )
                break;
            elseif( !isset($args[0]) )
                $caps[] = 'do_not_allow';
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        case 'delete_user':
        case 'delete_users':
            if( !isset($args[0]) )
                break;
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        default:
            break;
    }
    return $caps;
  }
}
