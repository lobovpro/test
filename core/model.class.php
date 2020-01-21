<?php
/**
 * class Model 
 * отвечает за общие для всех моделей функции
 * инициализирует ORM
*/
Class Model extends Core {
	
	/**
	 *  инициируем модель
	 *  
	 */
	public function __construct() {
		
		// подключаем ORM
		require_once $_SERVER['DOCUMENT_ROOT'].'/lib/rb.php';
		
		try {
			R::setup('mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME, Config::DB_USER, Config::DB_PASSWD);
		}
		catch (Exception $e) {
		}
		
	}
	
}