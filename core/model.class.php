<?php
namespace Test\Core;
use Test\Core\Config as Config;
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
		
		// подключаемся к БД
		if (empty(\R::$currentDB)) {
			try {
				\R::setup('mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME, Config::DB_USER, Config::DB_PASSWD);
			}
			catch (\Exception $e) {
				throw new \Exception ('Ошибка подключения к БД');
			}
		}
	}
}