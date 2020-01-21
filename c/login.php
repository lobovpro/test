<?php
/**
 * class контроллера Login 
 * отвечает за авторизацию и проверку прав
*/
class Login extends Controller {
	
	public function __construct() {
		
		parent::__construct();
	}
	
	public function index() {
		
		$data = $_POST;
		if (count($data)) {
			
			try {
				$this-> _check_data($data);
				$user = self::load_model('user');
				$id = $user-> try_to_auth($data['login'], $data['pass']);
			
				if ($id) {
					header('Location: /');
				}
				
				else $data['error'] = 'Login error';
			}
			catch (Exception $e) {
				$data['error'] = $e-> getMessage();
			}
		}

		$data['header'] = 'Login';
		$this-> __render('header', $data);
		$this-> __render('login_form', $data);
		$this-> __render('footer', $data);
	}
	
	public function logout() {
		$user = self::load_model('user');
		$user-> logout();
		header('Location: /');
	}
	
	/**
	 *  проверка данных
	 *  
	 *  @param array	$data
	 */
	private function _check_data($data) {
		if (empty($data['login'])) throw new Exception('Login required');
		if (empty($data['pass'])) throw new Exception('Password required');
		
		return true;
	}
}