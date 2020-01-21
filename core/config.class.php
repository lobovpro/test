<?php
/**
 * class Config  
 * отвечает за параметры по умолчанию
*/
class Config {
	
	const DEFAULT_CONTROLLER 	= 'tasks';
	const DEFAULT_METHOD 		= 'index';
	
	const DB_HOST 				= 'localhost';
	const DB_USER 				= 'stekar';
	const DB_PASSWD 			= 'jdQW8dMs';
	const DB_NAME 				= 'test';
	
	const DEFAULT_PER_PAGE = 3;
}

require_once('core/core.class.php');
require_once('core/controller.class.php');
require_once('core/model.class.php');