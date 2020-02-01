<?php 
namespace Test\M;

/**
 *  Model User
 *  
 *  use static functions 
 *  tryToAuth
 *  checkAuth
 *  logout
 */
Class User 
{
	
	/**
	 *  auth admin
	 *  
	 *  @param string $login
	 *  @param string $password
	 *  @return int $user_id
	 */
	public static function tryToAuth(string $login, string $pass): int 
	{

		$user_id = 0;
		
		$user = \R::findOne( 'user', ' name = :login AND pass = :pass ', 
		[ 
			':login' => htmlspecialchars($login), 
			':pass' => md5($pass) 
		] );
		
		if (!empty($user) && $user-> id) {
			$_SESSION['user_id'] = $user-> id;
			$user_id = $user-> id;
		}
		
		return $user_id;
	}
	
	/**
	 *  check is admin authorized
	 *  
	 *  @return bool
	 */
	public static function checkAuth(): bool 
	{
		$auth = false;
		
		if (!empty($_SESSION['user_id'])) {
			$user = \R::findOne( 'user', ' id = :id ', 
			[
				':id' => $_SESSION['user_id']
			]);
			if ($user-> id) $auth = true;
		}
		
		return $auth;
	}
	
	/**
	 *  logout user
	 */
	public static function logout(): void 
	{
		unset($_SESSION['user_id']);
	}
}