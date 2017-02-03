<?php
/**
 * 	Facebook Authentication Class
 *	Copyright Dalegroup Pty Ltd 2013
 *	support@dalegroup.net
 *
 *
 * @package     dgx
 * @author      Michael Dale <mdale@dalegroup.net>
 */

namespace sts;

class auth_facebook {
	
	private $config 	= array();
	//private $user		= array();
	private $facebook;
	
	function __construct() {	

		$config 			= &singleton::get(__NAMESPACE__ . '\config');
		
		if ($config->get('facebook_enabled')) {
			include(LIB . '/facebook/facebook.php');
			
			$this->facebook		= &singleton::get('facebook',
				array(
					  'appId' 				=> $config->get('facebook_app_id'),
					  'secret' 				=> $config->get('facebook_app_secret'),
					  'fileUpload'			=> false,
					  'allowSignedRequest' 	=> false,
					  'cookie' 				=> true
				)
			);
		}
	}

	public function authenticate($username, $password) {
		$return = false;

		$array['username'] 			= $username;
		$array['password']			= $password;
		$array['task']				= 'authenticate';
			
		$result = $this->send($array);
		
		if (!empty($result)) {
			if ($result['success'] == 1) {
				$this->user = $result;
				$return 	= true;
			}
		}
			
		return $return;
	}
	
	public function get_user() {
		return $this->facebook->getUser();
	}
	
	public function get_login_url() {
		return call_user_func_array(array($this->facebook, 'getLoginUrl'), func_get_args());
	}
	
	public function get_logout_url() {
		return call_user_func_array(array($this->facebook, 'getLogoutUrl'), func_get_args());
	}
	
	public function api() {
		return call_user_func_array(array($this->facebook, 'api'), func_get_args());
	}
	
	public function link_profile($facebook_id) {
		$users 			= &singleton::get(__NAMESPACE__ . '\users');
		$auth 			= &singleton::get(__NAMESPACE__ . '\auth');
		$config 		= &singleton::get(__NAMESPACE__ . '\config');
		$log			= &singleton::get(__NAMESPACE__ . '\log');

	
		$count = $users->count(array('facebook_id' => $facebook_id));
	
		if ($count == 0) {
			$log_array['event_severity'] 		= 'notice';
			$log_array['event_number'] 			= E_USER_NOTICE;
			$log_array['event_description'] 	= 'Facebook Profile Linked "<a href="' . $config->get('address') . '/users/view/' . $auth->get('id') . '/">'.'Unknown User'.'</a>"';
			$log_array['event_file'] 			= __FILE__;
			$log_array['event_file_line'] 		= __LINE__;
			$log_array['event_type'] 			= 'link_profile';
			$log_array['event_source'] 			= 'auth_facebook';
			$log_array['event_version'] 		= '1';
			$log_array['log_backtrace'] 		= false;	
					
			$log->add($log_array);
		
			$update_array['facebook_id'] 		= $facebook_id;
			$update_array['id']					= $auth->get('id');
			
			$users->edit($update_array);
			
			$auth->load();
			
			return true;
		}
		else {
			return false;
		}	
	}

}

?>