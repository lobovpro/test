<?php
namespace Test\M;
use Test\Core\Config;

/**
 *  Model Task
 */
Class Task 
{
	public $order_by;
	public $order_sort;
	
	/**
	 *  @brief init filters
	 */
	public function __construct() 
	{
		$this-> order_by = Config::DEFAULT_ORDER_BY;
		$this-> order_sort = Config::DEFAULT_ORDER_SORT;
	}
	 
	/**
	 *  @brief get task list
	 *  
	 *  @param int $page page num for pager 
	 *  @return List of RB classes
	 *	@throws Exception
	 */
	public function getList(int $page): array
	{
		
		// if tasks > 0
		if (!\R::count( 'task' )) throw new \Exception('Empty table task');
			
		// set params
		$start = ($page-1) * Config::DEFAULT_PER_PAGE;
		$sort = $_SESSION['sort'];
		
		// request 
		$tasks = \R::findAll( 'task' , ' order by '.$sort['by'].' '.$sort['order'].' limit '.$start.','.Config::DEFAULT_PER_PAGE );
		
		return $tasks;
	}
	
	/**
	 *  @brief init task from array data
	 *  
	 *  @param array $data
	 *  @return void
	 */
	public function initByArray($data): void
	{
		
		$task = \R::dispense( 'task' );
		foreach ($data as $k=> $v) {
			$task-> $k = htmlspecialchars($v);
		}
		$this-> task = $task;
	}

	/**
	 *  @brief save task
	 *  
	 *  @return void
	 *  @throws Exception
	 */
	public function save(): bool
	{
		$id = \R::store( $this-> task );
		if (!$id) throw new \Exception('Save error');
		return true;
	}
	
	/**
	 *  @brief get page count for tasks
	 *  
	 *  @return int 
	 */
	public function getPageCount(): int 
	{
		\R::count( 'task' );
		$page_count = ceil(\R::count( 'task' ) / Config::DEFAULT_PER_PAGE);
		return $page_count;
	}

	/**
	 *  @brief init task by id
	 *  
	 *  @param int $id 
	 *  @return array
	 */
	public function getById(int $id): array
	{
		$task = \R::findOne( 'task', ' id = :id ', 
		[
			':id' => $id
		])->export();
		if (!$task['id']) throw new \Exception('Task not found');
		
		return $task;
	}

	/**
	 *  применить сортировки 
	 *  
	 *  @param array $sort - установить эти сортировки
	 *  @param array $sort_tpl - шаблоны сортировок
	 */
	public function applySort($sort, $sort_tpl) 
	{
		if (!in_array($sort['by'], $sort_tpl['by'])) throw new \Exception('Sort by error');
		if (!in_array($sort['order'], $sort_tpl['order'])) throw new \Exception('Sort order error');
		
		$_SESSION['sort']['by'] = $sort['by'];
		$_SESSION['sort']['order'] = $sort['order'];
	}
}