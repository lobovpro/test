<?php
namespace Test\Core;
/**
 * class Config  
 * отвечает за параметры по умолчанию
*/
class Config {
	
	const DEFAULT_CONTROLLER 	= 'Tasks';
	const DEFAULT_METHOD 		= 'index';
	
	const DB_HOST 				= 'localhost';
	const DB_USER 				= 'testuser';
	const DB_PASSWD 			= 'testuserpass';
	const DB_NAME 				= 'test';
	
	const DEFAULT_PER_PAGE = 3;
}