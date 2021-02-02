<?php

namespace SternerStuffWordPress;

use SternerStuffWordPress\Interfaces\ActionHookSubscriber;

use function Env\env;

/**
 * If Mailtrap variables are set and it's on the development environment,
 * use Mailtrap for emails
 */
class Mailtrap implements ActionHookSubscriber {

    public static function get_actions() 
    {
        return [
            'phpmailer_init' => 'phpmailer_init',
        ];
	}

    public function phpmailer_init( $phpmailer )
    {
        switch(env( 'MAIL_MAILER' )) {
            case 'mailtrap':
                $this->enable_mailtrap( $phpmailer );
                break;
            case 'mailhog':
            default:
                $this->enable_mailhog( $phpmailer );
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
        $phpmailer->Host = 'localhost';
        $phpmailer->Port = 1025;
        $phpmailer->Username = null;
        $phpmailer->Password = null;
    }
}
