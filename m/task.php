<?php
/**
 *  Task Class
 */
Class Task extends Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_list($page) {
		
		if (R::count( 'task' )) {
			$start = ($page-1) * Config::DEFAULT_PER_PAGE;
			$sort = $_SESSION['sort'];
			
			$tasks = R::findAll( 'task' , ' order by '.$sort['by'].' '.$sort['order'].' limit '.$start.','.Config::DEFAULT_PER_PAGE );
			
			return $tasks;
		}
		else {
			throw new Exception('Empty table task');
		}
	}
	
	public function init_by_array($data) {
		
		$task = R::dispense( 'task' );
		foreach ($data as $k=> $v) {
			$task-> $k = htmlspecialchars($v);
		}
		$this-> task = $task;
	}
	
	public function save() {
		$id = R::store( $this-> task );
		if (!$id) throw new Exception('Save error');
		return true;
	}
	
	public function get_page_count() {
		R::count( 'task' );
		$page_count = ceil(R::count( 'task' ) / Config::DEFAULT_PER_PAGE);
		return $page_count;
	}
	
	public function get_by_id($id) {
		$task = R::findOne( 'task', ' id = :id ', 
		[
			':id' => $id
		]);
		return $task;
	}
	
	public function apply_sort($sort, $sort_tpl) {
		if (!in_array($sort['by'], $sort_tpl['by'])) throw new Exception('Sort by error');
		if (!in_array($sort['order'], $sort_tpl['order'])) throw new Exception('Sort order error');
		
		$_SESSION['sort']['by'] = $sort['by'];
		$_SESSION['sort']['order'] = $sort['order'];
	}
}