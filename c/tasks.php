<?php
/**
 * class контроллера Tasks
 * отвечает за работу с задачами
*/
class Tasks extends Controller {

	/**
	 *  инициируем таски
	 *  
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 *  список задач с постраничкой
	 *  
	 */
	public function index() {
		
		// загружаем модель задач
		$task = self::load_model('task');
		
		// сортировка 
		$sort_tpl['by'] = Array('id', 'name', 'email', 'text');
		$sort_tpl['order'] = Array('asc', 'desc');
		
		// по умолчанию
		$page = null;
		$sort = array();
		$sort['by'] = 'id';
		$sort['order'] = 'desc';
		
		// если переданы данные сортировки/постранички
		$data = $_GET;
		
		// если есть постраничка
		if (!empty($data['page'])) {
			$page = (int)$data['page'];
		}
		
		// применяем сортировки
		if (!empty($data['sort'])) {
			
			$sort['by'] = $data['sort'];
			$sort['order'] = $data['order'];
		}
		$task-> apply_sort($sort, $sort_tpl);
		$data['sort'] = $_SESSION['sort'];
		$data['sort_tpl'] = $sort_tpl;
		
		// если страница не указана - берем первую 
		if ($page < 1) $page = 1;
		$data['page'] = $page;
		
		$data['header'] = 'Task list';
		$data['task_list'] = Array();
		
		// запрашиваем список 
		try {
			$data['task_list'] = $task-> get_list($page);
			$data['page_count'] = $task-> get_page_count();
		}
		catch (Exception $e) {
			$data['error'] = $e-> getMessage();
		}

		// обрабатываем сообщение об успешном добавлении
		if (isset($_SESSION['message'])) {
			$data['message'] = $_SESSION['message'];
			unset($_SESSION['message']);
		}
		
		// выводим
		$this-> __render('header', $data);
		$this-> __render('task_list', $data);
		$this-> __render('footer', $data);
	}
	
	/**
	 *  форма добавления
	 */
	public function add() {
		$this-> __render('header', $data);
		$this-> __render('task_add', $data);
		$this-> __render('footer', $data);
	}
	 
	/**
	 *  сохраняем данные
	 */
	public function save() {

		// получаем данные
		$data = $_POST;
			
		try {
			
			// если редактируем (id не пустой)
			if (!empty($data['id'])) {
				
				// запрашиваем модель пользователя
				$user = self::load_model('user');
				
				// проверяем права авторизации
				if (!$user-> check_auth()) {
					throw new Exception('<a href="/login/">Authorization</a> required');
				}
				
				// если ошибка при передаче ID
				$id = (int)$data['id'];
				if (empty($id)) throw new Exception('Empty ID'); 
				
				// проверяем изменение поля text и ставим флаг "изменено"
				$old_task = self::load_model('task');
				$old_data = $old_task-> get_by_id($id);
				if ($old_data['text'] !== $data['text']) $data['admin_edit'] = 1;
			}
			
			// проверяем и сохраняем данные
			$this-> _check_data($data);
			$task = self::load_model('task');
			$task-> init_by_array($data);
			$task-> save();
		}
		catch(Exception $e) {
			$data['error'] = $e-> getMessage();
			$this-> __render('header', $data);
			$this-> __render('task_add', $data);
			$this-> __render('footer', $data);
		}
		
		// если нет ошибки - кидаем сообщение об успехе и редирект на список тасков
		if (!$data['error']) {
			$_SESSION['message'] = 'Success';
			header('Location:/');
			exit;
		}
	}
	
	/**
	 *  редактирование
	 */
	public function edit() {
		
		// проверяем авторизацию пользователя 
		// если не авторизован - сразу выкидываем на форму авторизации
		$user = self::load_model('user');
		if (!$user-> check_auth()) {
			header('Location: /login/');
			exit;
		}
		
		// если пытаемся редактировать пустой таск
		if (empty($_GET['id'])) throw new Exception('Empty ID'); 
		$id = (int)$_GET['id'];
		if (empty($id)) throw new Exception('Empty ID'); 
		
		// загружаем модель
		$task = self::load_model('task');
		$data = $task-> get_by_id($id);
		
		// выдаем форму
		if (!empty($data)) {
			$data['header'] = 'Edit task #'.$id;
			$this-> __render('header', $data);
			$this-> __render('task_add', $data);
			$this-> __render('footer', $data);
		}
		else {
			$data['error'] = 'Task #'.$id.' not found';
		}
	}
	
	/**
	 *  проверка данных
	 *  
	 *  @param array	$data
	 */
	private function _check_data($data) {
		
		if (!$data['name']) throw new Exception('Name required');
		if (!$data['email']) throw new Exception('Email required');
		if (!preg_match('/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $data['email'])) throw new Exception('Email invalid');
		if (!$data['text']) throw new Exception('Text required');
		
		return true;
	}
}
