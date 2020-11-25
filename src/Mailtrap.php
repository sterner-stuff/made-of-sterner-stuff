<?php

namespace SternerStuffWordPress;

use function Env\env;

/**
 * If Mailtrap variables are set and it's on the development environment,
 * use Mailtrap for emails
 */
class Mailtrap {
	function __construct() {
		add_action('phpmailer_init', [$this, 'enable_mailtrap']);
	}

	public function enable_mailtrap($phpmailer) {
		if(!env('MAILTRAP_USER') || !env('MAILTRAP_PASSWORD') || env('WP_ENV') != 'development') {
			return;
		}
		$phpmailer->isSMTP();
		$phpmailer->Host = 'smtp.mailtrap.io';
		$phpmailer->SMTPAuth = true;
		$phpmailer->Port = 2525;
		$phpmailer->Username = env('MAILTRAP_USER');
		$phpmailer->Password = env('MAILTRAP_PASSWORD');
	}
}
