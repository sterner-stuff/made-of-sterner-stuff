<?php

namespace SternerStuffWordPress;

class GravityFormsCaptcha {

	public function __construct() 
	{
		add_filter( 'gform_field_container', [$this, 'hide_captcha_label'], 10, 2 );
		add_filter( 'gform_field_content', [$this, 'add_captcha_disclaimer'], 10, 2 );

		add_action( 'wp_head', function() {
			echo '<style>
				.grecaptcha-badge { 
				    visibility: hidden;
				}
			</style>';
		});
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

}