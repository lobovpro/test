<?php
namespace Test\Core;
use Test\Core\Config as Config;
use Test\C\Tasks as Tasks;
use Test\C\Login as Login;
/**
 * class Core 
 * отвечает за инициализацию
 * маршрутизацию, автозагрузку классов и вызов требуемого контроллера
*/
class Core {
	
	/**
	 * инициализация приложения
	 * 
	 * @param 	string 	$request - URI
	*/
	public static function __init($request) {
		
		// контроллер по умолчанию 
		$controller = Config::DEFAULT_CONTROLLER;
		$method = Config::DEFAULT_METHOD;
		
		// если строка не пустая, обрабатываем
		if (!empty($request)) {
			
			// отбрасываем GET-параметры
			if (strpos($request, '?') !== false) {
				
				$tmp = explode('?', $request);
				$request = $tmp[0];
			}
			
			// разбиваем строку запроса на контроллер, функцию и параметры 
			$tmp = explode('/', $request);
			if (!empty($tmp[1])) $controller = $tmp[1];
			if (!empty($tmp[2])) $method = $tmp[2];
		}
		
		// пробуем обратиться к контроллеру 
		try {
			
			// загружаем контроллер 
			$controller = '\\Test\\C\\'.$controller;
			$app = new $controller;
			
			// если не найден метод - бросаем ошибку
			if (!method_exists($controller, $method)) throw new \Exception('Method "'.$method.'" doesn\'t exist in controller "'.$controller.'"');
			
			// вызываем метод
			try {
				$app-> $method();
			}
			// перехватываем ошибки, возникшие при выполнении
			catch(\Exception $e) {
				$data['header'] = 'Error';
				$data['error'] = $e-> getMessage();
				$app-> __render('header', $data);
				$app-> __render('error', $data);
				$app-> __render('footer', $data);
			}
		}
		catch (\Exception $e) {
			
			// обрабатываем критическую ошибку
			die('Error: '.$e-> getMessage());
		}
	}
}
