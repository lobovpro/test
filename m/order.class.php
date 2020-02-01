<?php
namespace Test\M;
use Test\Core\Config;
use Test\M\Task;

/**
 *  Model Order
 *  
 *  set order for TaskList
 *  
 *  use static methods
 *  applyOrder - apply order to TaskList
 *  setOrder - set new order
 */
Class Order 
{
	
	/**
	 *  @brief set filters 
	 *  
	 *  @param Task $task 
	 *  @throws Exception
	 */
	public static function applyOrder(\Test\M\Task $task): void
	{
		$sort = $_SESSION['sort'];
		if (!empty($sort['by'])) $task-> order_by = $sort['by'];
		if (!empty($sort['order'])) $task-> order_sort = $sort['order'];
	}
	 
	/**
	 *  @brief set order filters 
	 *  
	 *  @param string $order_by 
	 *  @param string $sort_order 
	 *  @return void
	 */
	public static function setOrder(string $order_by, string $sort_order): void
	{
		if (!in_array($order_by, Config::PERMITTED_ORDER_BY)) throw new \Exception('Sort by error');
		if (!in_array($sort_order, Config::PERMITTED_ORDER)) throw new \Exception('Sort order error');
		
		$_SESSION['sort']['by'] = $order_by;
		$_SESSION['sort']['order'] = $sort_order;
	}
}