<?php

namespace SternerStuffWordPress\WordPress;

use function Env\env;

use Roots\WPConfig\Config;
use SternerStuffWordPress\Interfaces\ActionHookSubscriber;

/**
 * If Mailhog variables are set and it's on the development environment,
 * use Mailhog for emails
 */
class Mailers implements ActionHookSubscriber
{

	public static function get_actions()
	{
		return [
			'muplugins_loaded' => 'muplugins_loaded',
		];
	}

	public function muplugins_loaded()
	{
		$mailer = env('MAIL_MAILER');

		if (!$mailer) {
			if (env('MAILGUN_APIKEY')) {
				$mailer = 'mailgun';
			} else if (env('POSTMARK_API_KEY')) {
				$mailer = 'postmark';
			}
		}


		switch ($mailer) {
			case 'mailhog':
				add_action('phpmailer_init', [$this, 'enable_mailhog']);
				break;			
			case 'postmark':
				$this->enable_postmark();
				break;
			case 'mailgun':
			default:
				$this->enable_mailgun();
				break;
		}
	}

	public function enable_mailhog($phpmailer)
	{
		$phpmailer->isSMTP();
		$phpmailer->Host = env('MAIL_HOST') ?? 'localhost';
		$phpmailer->Port = 1025;
		$phpmailer->Username = null;
		$phpmailer->Password = null;
	}

	/**
	 * Configure Mailgun
	 */
	public function enable_mailgun()
	{
		Config::define('MAILGUN_USEAPI', env('MAILGUN_USEAPI') ?? true);
		Config::define('MAILGUN_REGION', env('MAILGUN_REGION') ?? 'us');

		if (env('MAILGUN_APIKEY')) :
			Config::define('MAILGUN_APIKEY', env('MAILGUN_APIKEY'));
		endif;

		if (env('MAILGUN_DOMAIN')) :
			Config::define('MAILGUN_DOMAIN', env('MAILGUN_DOMAIN'));
		endif;

		if (env('MAILGUN_FROM_ADDRESS')) :
			Config::define('MAILGUN_FROM_ADDRESS', env('MAILGUN_FROM_ADDRESS'));
		endif;

		Config::apply();
	}

	/**
	 * Configure Postmark
	 */
	public function enable_postmark()
	{
		if (env('POSTMARK_API_KEY')) :
			Config::define('POSTMARK_API_KEY', env('POSTMARK_API_KEY'));

			add_filter('option_postmark_settings', function ($settings) {
				$settings = json_decode($settings, true);

				$settings['enabled'] = true;

				return json_encode($settings);
			});
		endif;

		if (env('POSTMARK_STREAM_NAME')) :
			Config::define('POSTMARK_STREAM_NAME', env('POSTMARK_STREAM_NAME'));
		endif;

		if (env('POSTMARK_SENDER_ADDRESS')) :
			Config::define('POSTMARK_SENDER_ADDRESS', env('POSTMARK_SENDER_ADDRESS'));
		endif;

		Config::apply();
	}
}
