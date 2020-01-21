<?php
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
			$app = self::load_controller($controller);
			
			// если не найден метод - бросаем ошибку
			if (!method_exists($controller, $method)) throw new Exception('Method "'.$method.'" doesn\'t exist in controller "'.$controller.'"');
			
			// вызываем метод
			try {
				$app-> $method();
			}
			// перехватываем ошибки, возникшие при выполнении
			catch(Exception $e) {
				$data['header'] = 'Error';
				$data['error'] = $e-> getMessage();
				$app-> __render('header', $data);
				$app-> __render('error', $data);
				$app-> __render('footer', $data);
			}
			
		}
		catch (Exception $e) {
			
			// обрабатываем критическую ошибку
			die('Error: '.$e-> getMessage());
		}
	}
	
	/**
	 *  инииализация модели
	 *  
	 *  @param 	string 	$name - название можели
	 */
	public static function load_model($name) {
		
		try {
			$model = self::_load('m', $name);
			return $model;
		}
		catch(Exception $e) {
			throw new Exception('Model '.$e-> getMessage());
		}
	}
	
	/**
	 *  инииализация контроллера
	 *  
	 *  @param 	string 	$name - название контроллера
	 */
	public static function load_controller($name) {
		
		try {
			$controller = self::_load('c', $name);
			return $controller;
		}
		catch(Exception $e) {
			throw new Exception('Controller '.$e-> getMessage());
		}
	}
	
	/**
	 *  инииализация модели/контроллера из класса 
	 *  
	 *  @param 	string	$type(m|c) - тип модель или контроллер
	 *  @param 	string 	$name - название можели
	 */
	private static function _load($type, $name) {
		
		// если не найден - бросаем ошибку
		if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$type.'/'.$name.'.php')) throw new Exception('"'.$name.'" doesn\'t exist', 1);
		
		// подключаем файл
		require_once($_SERVER['DOCUMENT_ROOT'].'/'.$type.'/'.$name.'.php');
		
		// инициализируем и отдаем объект
		$app = new $name;
		return $app;
	}
}
