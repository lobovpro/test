<?php 
/**
 *  Class User
 *  
 *  используется для авторизации и проверки авторизации
 */
Class User extends Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 *  попытка авторизоваться
	 *  
	 *  @param string $login
	 *  @param string $password
	 */
	public function try_to_auth($login, $pass) {

		$user = R::findOne( 'user', ' name = :login AND pass = :pass ', 
		[ 
			':login' => htmlspecialchars($login), 
			':pass' => md5($pass) 
		] );
		
		if (!empty($user) && $user-> id) {
			$_SESSION['user_id'] = $user-> id;
			return $user-> id;
		}
	}
	
	/**
	 *  проверка авторизован ли пользователь
	 */
	public function check_auth() {
		
		$auth = false;
		
		if (!empty($_SESSION['user_id'])) {
			$user = R::findOne( 'user', ' id = :id ', 
			[
				':id' => $_SESSION['user_id']
			]);
			if ($user-> id) $auth = true;
		}
		
		return $auth;
	}
	
	/**
	 *  выход 
	 */
	public function logout() {
		unset($_SESSION['user_id']);
	}
}