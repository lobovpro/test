<?php
namespace Test\Core;
use Test\Core\Config;
use Test\C\{Tasks, Login};

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
		$controller = Config::DEFAULT_CONTROLLER;
		$method = Config::DEFAULT_METHOD;
		
		// if request is not empty - process string
		if (!empty($request)) {
			
			// drop $_GET params
			if (strpos($request, '?') !== false) {
				
				$tmp = explode('?', $request);
				$request = $tmp[0];
			}
			
			// get controller and method names
			$tmp = explode('/', $request);
			if (!empty($tmp[1])) $controller = $tmp[1];
			if (!empty($tmp[2])) $method = $tmp[2];
		}
		
		// connect DB
		self::dbConnect();
	
		// use controller
		$controller = '\\Test\\C\\'.$controller;
		$app = new $controller;
		
		// method
		try {
			$app-> $method();
		} 
		// errors within a controller
		catch(\Exception $e) {
			$data['header'] = 'Error';
			$data['error'] = $e-> getMessage();
			$app-> render('error', $data);
		}
	}
	
	private static function dbConnect(): void 
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
}
