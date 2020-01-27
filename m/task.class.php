<?php
namespace Test\M;
use Test\Core\Model as Model;
use Test\Core\Config as Config;
/**
 *  Task Class
 */
Class Task extends Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 *  get task list
	 *  
	 *  @param integer $page - номер страницы для постранички
	 *  @return array $tasks - список тасков
	 *  @throws Exception 
	 */
	public function get_list($page) {
		
		// если есть, что возвращать
		if (\R::count( 'task' )) {
			
			// формируем параметры запроса
			$start = ($page-1) * Config::DEFAULT_PER_PAGE;
			$sort = $_SESSION['sort'];
			
			// запрашиваем 
			$tasks = \R::findAll( 'task' , ' order by '.$sort['by'].' '.$sort['order'].' limit '.$start.','.Config::DEFAULT_PER_PAGE );
			
			return $tasks;
		}
		else {
			throw new \Exception('Empty table task');
		}
	}
	
	/**
	 *  @brief формируем таск из массива
	 *  
	 *  @param array $data - данные таска
	 */
	public function init_by_array($data) {
		
		$task = \R::dispense( 'task' );
		foreach ($data as $k=> $v) {
			$task-> $k = htmlspecialchars($v);
		}
		$this-> task = $task;
	}

	/**
	 *  сохранить таск
	 *  
	 *  @throws Exception
	 */
	public function save() {
		$id = \R::store( $this-> task );
		if (!$id) throw new \Exception('Save error');
		return true;
	}
	
	/**
	 *  @brief количество страниц
	 *  
	 */
	public function get_page_count() {
		\R::count( 'task' );
		$page_count = ceil(\R::count( 'task' ) / Config::DEFAULT_PER_PAGE);
		return $page_count;
	}

	/**
	 *  получить таск из базы по идентификатору
	 *  
	 *  @param integer $id
	 */
	public function get_by_id($id) {
		$task = \R::findOne( 'task', ' id = :id ', 
		[
			':id' => $id
		]);
		return $task;
	}

	/**
	 *  применить сортировки 
	 *  
	 *  @param array $sort - установить эти сортировки
	 *  @param array $sort_tpl - шаблоны сортировок
	 */
	public function apply_sort($sort, $sort_tpl) {
		if (!in_array($sort['by'], $sort_tpl['by'])) throw new \Exception('Sort by error');
		if (!in_array($sort['order'], $sort_tpl['order'])) throw new \Exception('Sort order error');
		
		$_SESSION['sort']['by'] = $sort['by'];
		$_SESSION['sort']['order'] = $sort['order'];
	}
}