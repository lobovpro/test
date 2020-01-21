<?php
/**
 * class контроллера Login 
 * отвечает за авторизацию и проверку прав
*/
class Login extends Controller {
	
	/**
	 *  консруктор
	 *  
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 *  обработчик по умолчанию - вывод формы авторизации и попытка авторизации
	 *  
	 */
	public function index() {

		// если переданы данные из формы
		$data = $_POST;
		if (count($data)) {
			
			// пробуем авторизоваться
			try {
				
				// проверка данных
				$this-> _check_data($data);
				
				// загрузка модели
				$user = self::load_model('user');
				
				// авторизуемся
				$id = $user-> try_to_auth($data['login'], $data['pass']);
			
				// если успешно - прыгаем на главную
				if ($id) {
					header('Location: /');
				}
				
				// иначе выдаем ошибку
				else $data['error'] = 'Login error';
			}
			// формируем сообщение об ошибках, возникших при выполнении
			catch (Exception $e) {
				$data['error'] = $e-> getMessage();
			}
		}

		// выводим форму авторизации
		$data['header'] = 'Login';
		$this-> __render('header', $data);
		$this-> __render('login_form', $data);
		$this-> __render('footer', $data);
	}
	
	/**
	 *  разлогиниваем пользователя
	 *  
	 */
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