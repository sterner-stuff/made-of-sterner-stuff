<?php 

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\ActionHookSubscriber;
use SternerStuffWordPress\Interfaces\FilterHookSubscriber;
use function Env\env;

class DisableTracking implements ActionHookSubscriber, FilterHookSubscriber {

	public $should_disable = false;

	public static function get_actions()
	{
		return [
			'init' => 'should_disable',
			'wp_head' => [
				'disable_ga_google_analytics_tracking',
				1,
			],
		];
	}

	public static function get_filters()
	{
		return [
			'googlesitekit_analytics_tracking_disabled' => 'disable_googlesitekit_tracking',
			'monsterinsights_track_user' => 'monsteranalytics_track_user',
		];
	}

	public function monsteranalytics_track_user( $should_track )
	{
		return $this->should_disable ? false : $should_track;
	}

	public function disable_ga_google_analytics_tracking() 
	{
		if(!$this->should_disable) return;
		remove_action( 'wp_head', 'ga_google_analytics_tracking_code' );
	}

	public function disable_googlesitekit_tracking( $disabled ) 
	{
		return $this->should_disable ?: $disabled;
	}

	public function should_disable()
	{
		if(env('WP_ENV') && env('WP_ENV') != 'production') {
			$this->should_disable = true;
			return;
		}

		// If user is not logged in, fall back to default.
		if( !is_user_logged_in() ) {
			$this->should_disable = false;
			return;
		}

		$user = wp_get_current_user();

		// If the user's role is customer, don't disable tracking.
		if('customer' == $user->roles[0]) {
			$this->should_disable = false;
			return;
		}

		// Disable for all other logged in users.
		$this->should_disable = true;
		return;
	}

}
