<?php
namespace Test\Core;
use Test\M\User;

/**
 * class Controller
 * 
 */
Abstract Class Controller 
{
	
	/**
	 *  @brief render view
	 *  
	 *  @param string 	$viewname 
	 *  @param array	$data
	 *  
	 *  @return void
	 *  
	 *  @throws Exception
	 */
	public function render(string $viewname, array $data = []): void 
	{
		
		// if view doesn't exist
		if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/v/'.$viewname.'.php')) throw new \Exception('"'.$viewname.'" doesn\'t exist', 1);
		
		// $data to $vars conversion
		if (isset($data) && count($data)) foreach($data as $k=>$v) {
			$$k = $v;
		}
		
		// is admin authorized
		$admin = \Test\M\User::checkAuth();
		
		// view
		require($_SERVER['DOCUMENT_ROOT'].'/v/header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/v/'.$viewname.'.php');
		require($_SERVER['DOCUMENT_ROOT'].'/v/footer.php');
	}
	
	/**
	 *  @brief intercepts undefined methods query
	 *  
	 *  @param string $method 
	 *  @param array $params
	 *  
	 *  @return void
	 */
	public function __call(string $method, array $params): void
	{
		$controller = str_replace(__NAMESPACE__.'\\', '', __CLASS__);
		throw new \Exception('Method "'.$method.'" doesn\'t exist in controller "'.$controller.'"');
	}
}