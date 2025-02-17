<?php 

namespace SternerStuffWordPress\WordPress;

use SternerStuffWordPress\Interfaces\ActionHookSubscriber;

class DisableUpdateNag implements ActionHookSubscriber {
	
	public static function get_actions()
	{
		return [
			'admin_notices' => ['admin_notices', 1, ],
		];
	}
	
	public function admin_notices()
	{
		/**
		* Bedrock doesn't currently support the WP_DEVELOPMENT_MODE constant
		* so we'll use the environment instead.
		*/
		if(wp_get_environment_type() !== 'development' && wp_get_environment_type() !== 'local') {
			remove_action( 'admin_notices', 'update_nag',      3  );
			remove_action( 'admin_notices', 'maintenance_nag', 10 );
		}
	}
	
}