<?php 

namespace SternerStuffWordPress\WordPress;

use SternerStuffWordPress\Interfaces\FilterHookSubscriber;

class LoginErrors implements FilterHookSubscriber {

    public static function get_filters()
    {
        return [
            // 'login_errors' => 'login_errors',
			// 'lostpassword_errors' => 'lostpassword_errors',
			// 'lostpassword_user_data' => 'lostpassword_user_data',
        ];
    }

    public function login_errors( $errors )
    {
		if($errors) {
			return '<p>' . 
				'Login failed. Check your username and password.' . 
				' <a href="' . wp_lostpassword_url() . '">' .
				__( 'Lost your password?' ) .
				'</a>' .
			'</p>';
		}

		return $errors;
    }

	public function lostpassword_errors( $errors )
	{
		$this->add_lostpassword_message();
		if($errors->get_error_code() == 'invalid_email') {
			return new \WP_Error('lostpassword_error', '.');
		}
		
		return $errors;
	}

	public function lostpassword_user_data( $user_data )
	{
		if(!$user_data) {
			$this->add_lostpassword_message();
			add_filter('lostpassword_errors', function($errors) {
				return new \WP_Error('lostpassword_error', '.');
			});
		}
	}

	private function add_lostpassword_message()
	{
		// add_filter();
	}
}