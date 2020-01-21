<?php
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
	 *  @param string $viewname имя view 
	 */
	public function __render($viewname, $data = null) {
		
		// если не найден - бросаем ошибку
		if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/v/'.$viewname.'.php')) throw new Exception('"'.$viewname.'" doesn\'t exist', 1);
		
		if (isset($data) && count($data)) foreach($data as $k=>$v) {
			$$k = $v;
		}
		
		$user = self::load_model('user');
		if ($user-> check_auth()) $admin = true;
		else $admin = false;
		
		require($_SERVER['DOCUMENT_ROOT'].'/v/'.$viewname.'.php');
	}
}