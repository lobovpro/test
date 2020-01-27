<?php
namespace Test\Core;
use \Test\M\User;
/**
 * class Controller
 * отвечает за общие для всех контроллеров методы
*/
Class Controller Extends Core {
	
	public function __construct() {
	}
	
	/**
	 *  рендерим вывод
	 *  
	 *  @param string 	$viewname имя view 
	 *  @param array	$data - параметры, которые должны быть выведены в шаблоне
	 */
	public function __render($viewname, $data = null) {
		
		// если не найден - бросаем ошибку
		if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/v/'.$viewname.'.php')) throw new \Exception('"'.$viewname.'" doesn\'t exist', 1);
		
		// переводим массив $data в переменные
		if (isset($data) && count($data)) foreach($data as $k=>$v) {
			$$k = $v;
		}
		
		// проверяем, авторизован ли администратор
		$user = new \Test\M\User;
		if ($user-> check_auth()) $admin = true;
		else $admin = false;
		
		// запрашиваем view
		require($_SERVER['DOCUMENT_ROOT'].'/v/'.$viewname.'.php');
	}
}