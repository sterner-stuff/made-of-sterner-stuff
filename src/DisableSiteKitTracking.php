<?php 

namespace SternerStuffWordPress;

class DisableSiteKitTracking {

	public function __construct() {
		add_filter( 'googlesitekit_analytics_tracking_disabled', [$this, 'googlesitekit_analytics_tracking_disabled'] );
	}

	public function googlesitekit_analytics_tracking_disabled( $disabled ) {
		
		// If user is not logged in, fall back to default.
		if( !is_user_logged_in() ) return $disabled;
		$user = wp_get_current_user();

		// If the user's role is customer, don't disable tracking.
		if('customer' == $user->roles[0]) return false;

		// Disable for all other logged in users.
		return true;
	}

}
