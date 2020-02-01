<?php
namespace Test\C;
use Test\Core\Controller;
use Test\M\User;

/**
 *  Controller Login
 *  
 *  provides public methods
 *  index - render login form
 *  auth - login user
 *  logout - logout user
 */
class Login extends Controller 
{
	
	/**
	 *  @brief render auth form
	 *  
	 *  @return void
	 */
	public function index(): void 
	{

		// if data
		$data = $_POST;
		if (!count($data)) {
			$data['login'] = '';
			$data['pass'] = '';
		}

		// render form
		$data['header'] = 'Login';
		$this-> render('login_form', $data);
	}
	
	/**
	 *  @brief auth user
	 *  
	 *  @return void
	 *  @throws Exception
	 */
	public function auth(): void 
	{
		$data = $_POST;
		
		if (count($data)) {
			
			// try to auth
			try {
			
				$this-> _check_data($data);
				$id = \Test\M\User::tryToAuth($data['login'], $data['pass']);
			
				// go to index if success
				if ($id) {
					header('Location: /');
				}
				
				// otherwise error 
				throw new \Exception('Login error');
			}
			// error output
			catch (\Exception $e) {
				$data['error'] = $e-> getMessage();
			}
		}
		
		// render form
		$data['header'] = 'Login';
		$this-> render('login_form', $data);
	}
	
	/**
	 *  @brief user logout request
	 *  
	 *  @return void
	 */
	public function logout(): void
	{
		\Test\M\User::logout();
		header('Location: /');
	}
	
	/**
	 *  @brief check auth data
	 *  
	 *  @param array $data [login, pass]
	 *  @return bool
	 *  @throws Exception
	 */
	private function _check_data(array $data): bool 
	{
		if (empty($data['login'])) throw new \Exception('Login required');
		if (empty($data['pass'])) throw new \Exception('Password required');
		
		return true;
	}
}