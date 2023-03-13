<?php

namespace SternerStuffWordPress\GravityForms;

use SternerStuffWordPress\Interfaces\ActionHookSubscriber;
use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

/**
 * Hide Gravity Forms Captcha label and the Captcha badge
 * Adhere to Google ToS for hiding Captcha badge
 */
class Captcha implements FilterHookSubscriber, ActionHookSubscriber {

	public static function get_filters() { 
		return [
			'gform_field_content' => ['add_captcha_disclaimer', 10, 2],
			'gform_field_container' => ['hide_captcha_label', 10, 2],
		];
	}

	public static function get_actions() { 
		return [
			'wp_head' => 'wp_head',
		];
	}

	public function hide_captcha_label($field_container, $field)
	{
		if( 'captcha' != $field->type ) {
			return $field_container;
		}

		return str_replace("class='gfield ", "class='gfield hidden_label ", $field_container);
	}

	public function add_captcha_disclaimer($content, $field)
	{
		if( 'captcha' != $field->type ) {
			return $content;
		}

		$content .= '<small>This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy">Privacy Policy</a> and <a href="https://policies.google.com/terms">Terms of Service</a> apply.</small>';

		return $content;
	}

	public function wp_head()
	{
		echo '<style>
			.grecaptcha-badge { 
				visibility: hidden;
			}
		</style>';
	}

}