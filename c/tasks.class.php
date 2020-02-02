<?php
namespace Test\C;
use Test\Core\Config;
use Test\C\Controller;
use Test\M\{Task, Order, User};

/**
 *  Controller Tasks
 *  
 *  provides public methods
 *  index - render the list of tasks
 *  add - render the add form
 *  save - try to save the task from the edit ar add form
 *  edit - render edit form for task
 */
class Tasks extends Controller 
{	
	/**
	 *  @brief deprecate parent functionality
	 *  
	 *  @return void
	 */
	public function __construct()
	{
	}
	
	/**
	 *  @brief get and render task list
	 *  
	 *  @return void
	 */
	public function index(): void 
	{
		$page = null;
		$data = $_GET;
		
		// set new page from params
		if (!empty($data['page'])) {
			$page = (int)$data['page'];
		}
		if ($page < 1) $page = 1;
		
		$data['task_list'] = array();
		try { 
			// set new sorts from params
			if (!empty($data['sort'])) {	
				\Test\M\Order::setOrder($data['sort'], $data['order']);
			}
		}
		catch (\Exception $e) {
			$data['error'] = $e-> getMessage();
		}
		
		try {
			// main model
			$task = new \Test\M\Task;
			
			// apply order 
			\Test\M\Order::applyOrder($task);
			
			// get data
			$data['task_list'] = $task-> getList($page);
			$data['page_count'] = $task-> getPageCount();
			$data['sort'] = $task-> order_by;
			$data['order'] = $task-> order_sort;
		}
		catch (\Exception $e) {
			$data['error'] = $e-> getMessage();
		}
		
		// set params for template
		$data['header'] = 'Task list';
		$data['page'] = $page;
		$data['sort_tpl']['by'] = Config::PERMITTED_ORDER_BY;
		$data['sort_tpl']['order'] = Config::PERMITTED_ORDER;
		
		
		// add message if exists
		if (isset($_SESSION['message'])) {
			$data['message'] = $_SESSION['message'];
			unset($_SESSION['message']);
		}
		
		// render
		$this-> render('task_list', $data);
	}
	
	/**
	 *  @brief render add form
	 *  
	 *  @return void
	 */
	public function add(): void 
	{
		// preset data
		$data['header'] = 'Add task';
		$data['id'] = '';
		$data['name'] = '';
		$data['email'] = '';
		$data['text'] = '';
		
		// render add form
		$this-> render('task_add', $data);
	}
	 
	/**
	 *  @brief save task
	 *  
	 *  @return void
	 */
	public function save(): void
	{
		// get data - _POST only
		$data = $_POST;
			
		try {
			
			// if edit task
			if (!empty($data['id'])) {
				
				// check admin auth
				if (!\Test\M\User::checkAuth()) {
					throw new \Exception('<a href="/login/">Authorization</a> required');
				}
				
				// if ID error
				$id = (int)$data['id'];
				if (empty($id)) throw new \Exception('Empty ID'); 
				
				// check if task is changed
				$old_task = new \Test\M\Task;
				$old_data = $old_task-> getById($id);
				if ($old_data['text'] !== $data['text']) $data['admin_edit'] = 1;
			}
			
			// check and save
			$this-> _checkData($data);
			$task = new \Test\M\Task;
			$task-> initByArray($data);
			$task-> save();
		}
		catch(\Exception $e) {
			$data['error'] = $e-> getMessage();
			$data['header'] = 'Add task';
			$this-> render('task_add', $data);
		}
		
		// redirect to list
		if (!$data['error']) {
			$_SESSION['message'] = 'Success';
			header('Location:/');
			exit;
		}
	}
	
	/**
	 *  @brief render edit form
	 *  
	 *  @return void
	 *  @throws Exception
	 */
	public function edit(): void
	{
		// check admin auth
		if (!\Test\M\User::checkAuth()) {
			header('Location: /login/');
			exit;
		}
		
		// if ID error
		if (empty($_GET['id']) || !$id = (int)$_GET['id']) throw new \Exception('Empty ID'); 
		
		// load Task data
		$task = new \Test\M\Task;
		$data = $task-> getById($id);
		
		// edit form
		if (!empty($data)) {
			$data['header'] = 'Edit task #'.$id;
			$this-> render('task_add', $data);
		}
		else {
			$data['error'] = 'Task #'.$id.' not found';
		}
	}
	
	/**
	 *  @brief check data
	 *  
	 *  @param array $data [name, email, text etc]
	 *  @return bool
	 *  @throws Exception
	 */
	private function _checkData(array $data): bool 
	{
		if (!$data['name']) throw new \Exception('Name required');
		if (!$data['email']) throw new \Exception('Email required');
		if (!preg_match('/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $data['email'])) throw new \Exception('Email invalid');
		if (!$data['text']) throw new \Exception('Text required');
		
		return true;
	}
}
