<?php

namespace SternerStuffWordPress;

use function Env\env;

use Roots\WPConfig\Config;
use SternerStuffWordPress\Interfaces\ActionHookSubscriber;

/**
 * If Mailtrap variables are set and it's on the development environment,
 * use Mailtrap for emails
 */
class Mailtrap implements ActionHookSubscriber {

    public static function get_actions() 
    {
        return [
            'plugins_loaded' => 'plugins_loaded',
        ];
	}

    public function plugins_loaded()
    {
        $mailer = env( 'MAIL_MAILER' );

        if(!$mailer) {
            if(env('WP_ENV') != 'production') {
                $mailer = 'mailhog';
            } else {
                $mailer = 'mailgun';
            }
        }
        

        switch($mailer) {
            case 'mailtrap':
                add_action('phpmailer_init', [$this, 'enable_mailtrap']);
                break;
            case 'mailhog':                
                add_action('phpmailer_init', [$this, 'enable_mailhog']);
                break;
            case 'mailgun':
            default:
                $this->enable_mailgun();
                break;
        }
    }

	public function enable_mailtrap( $phpmailer ) {
		if(!env('MAILTRAP_USER') || !env('MAILTRAP_PASSWORD')) {
			return;
		}
		$phpmailer->isSMTP();
		$phpmailer->Host = 'smtp.mailtrap.io';
		$phpmailer->SMTPAuth = true;
		$phpmailer->Port = 2525;
		$phpmailer->Username = env('MAILTRAP_USER');
		$phpmailer->Password = env('MAILTRAP_PASSWORD');
    }
    
    public function enable_mailhog( $phpmailer )
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

		if(env('MAILGUN_APIKEY')):
			Config::define('MAILGUN_APIKEY', env('MAILGUN_APIKEY'));
		endif;

		if(env('MAILGUN_DOMAIN')):
			Config::define('MAILGUN_DOMAIN', env('MAILGUN_DOMAIN'));
		endif;

		if(env('MAILGUN_FROM_ADDRESS')):
			Config::define('MAILGUN_FROM_ADDRESS', env('MAILGUN_FROM_ADDRESS'));
		endif;

        Config::apply();
    }
}
