<?php 

namespace SternerStuffWordPress;

class DisableTracking {

	public $should_disable = false;

	public function __construct() {
		add_action( 'init', [$this, 'init'] );
	}

	public function init()
	{
		$this->should_disable = $this->should_disable();
		if($this->should_disable) {
			add_filter( 'googlesitekit_analytics_tracking_disabled', [$this, 'disable_googlesitekit_tracking'] );
			add_action( 'wp_head', [$this, 'disable_ga_google_analytics_tracking'], 1 );
			add_filter( 'monsterinsights_track_user', [$this, 'monsteranalytics_track_user'] );
		}
	}

	public function monsteranalytics_track_user( $should_track )
	{
		return $this->should_disable ? false : $should_track;
	}

	public function disable_ga_google_analytics_tracking() 
	{
		remove_action( 'wp_head', 'ga_google_analytics_tracking_code' );
	}

	public function disable_googlesitekit_tracking( $disabled ) 
	{
		return $this->should_disable ?: $disabled;
	}

	private function should_disable()
	{
		if(env('WP_ENV') != 'production') return true;

		// If user is not logged in, fall back to default.
		if( !is_user_logged_in() ) return false;

		$user = wp_get_current_user();

		// If the user's role is customer, don't disable tracking.
		if('customer' == $user->roles[0]) return false;

		// Disable for all other logged in users.
		return true;
	}

}
