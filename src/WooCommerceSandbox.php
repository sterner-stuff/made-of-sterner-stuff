<?php

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class WooCommerceSandbox implements FilterHookSubscriber {

	/**
     * Get the filter hooks subscribing to.
     *
     * @return array
     */
    public static function get_filters()
    {
        return [
            'option_woocommerce_paypal_settings' => 'option_woocommerce_paypal_settings'
        ];
    }

	public function option_woocommerce_paypal_settings( $settings ) 
	{
		if(env('WOOCOMMERCE_ENV') != 'test') return $settings;
		
		$settings['testmode'] = 'yes';

		if(($email = env('WOOCOMMERCE_SANDBOX_PAYPAL_EMAIL'))) {
			$settings['email'] = $email;
		}
		return $settings;
	}
}
