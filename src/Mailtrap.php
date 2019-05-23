<?php

namespace SternerStuffWordPress;

/**
 * If Mailtrap variables are set and it's on the development environment,
 * use Mailtrap for emails
 */
class Mailtrap {
	function __construct() {
		add_action('phpmailer_init', [$this, 'enable_mailtrap']);
	}

	public function enable_mailtrap($phpmailer) {
		if(!getenv('MAILTRAP_USER') || !getenv('MAILTRAP_PASSWORD') || getenv('WP_ENV') != 'development') {
			return;
		}
		$phpmailer->isSMTP();
		$phpmailer->Host = 'smtp.mailtrap.io';
		$phpmailer->SMTPAuth = true;
		$phpmailer->Port = 2525;
		$phpmailer->Username = getenv('MAILTRAP_USER');
		$phpmailer->Password = getenv('MAILTRAP_PASSWORD');
	}
}
