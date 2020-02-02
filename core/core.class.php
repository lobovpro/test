<?php
namespace Test\Core;
use Test\Core\Config;
use Test\C\Controller;

/**
 * Core 
 * 
 * init aplication and request controller
 * 
 * static function __init
 */
class Core 
{
	/**
	 *  @brief init app
	 *  
	 *  @param string $request URI
	 *  @throws Exception
	 */
	public static function init(string $request): void 
	{
		// set controller by default
		$controller_name = Config::DEFAULT_CONTROLLER;
		$method_name = Config::DEFAULT_METHOD;
		
		// if request is not empty - process route
		if (!empty($request)) {
			self::_route($request, $controller_name, $method_name);
		}
		
		// connect DB
		self::_dbConnect();
	
		// use factory
		$factory = '\\Test\\C\\Controller';
		$app = new $factory();
		
		// init controller
		try {
			$app = $app-> init($controller_name);
			$app-> $method_name();
		} 
		// errors within a controller
		catch(\Error | \Exception $e) {
			$data['header'] = 'Error';
			$data['error'] = $e-> getMessage();
			$app-> render('error', $data);
		}
	}
	
	/**
	 *  @brief DB connection and admin user creation in first start
	 *  
	 *  @return void
	 */
	private static function _dbConnect(): void 
	{
		if (empty(\R::$currentDB)) {
			\R::setup('mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME, Config::DB_USER, Config::DB_PASSWD);
		}
		
		if (!\R::count( 'user' )) {
			$user = \R::dispense('user');
			$user-> name = 'admin';
			$user-> pass = md5('123');
			$id = \R::store($user);
		}
	}
	
	/**
	 *  @brief get controller and method from request URI
	 *  
	 *  @param string $request URI
	 *  @param string $controller_name 
	 *  @param string $method_name 
	 *  @return void
	 */
	private static function _route(string $request, string &$controller_name, string &$method_name): void 
	{
		// drop $_GET params
		if (strpos($request, '?') !== false) {
			
			$tmp = explode('?', $request);
			$request = $tmp[0];
		}
		
		// get controller and method names
		$tmp = explode('/', $request);
		if (!empty($tmp[1])) $controller_name = $tmp[1];
		if (!empty($tmp[2])) $method_name = $tmp[2];
	}
}
