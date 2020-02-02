<?php
namespace Test\Core;

/**
 * Config  
 *
 * DB settings, default app settings
 */
class Config 
{
	const DB_DRIVER				= 'sqlite'; // sqlite | mysql
	
	const SQLITE_STORAGE		= '/../data/test.db';
	
	const MYSQL_HOST 			= '';
	const MYSQL_USER 			= '';
	const MYSQL_PASSWD 			= '';
	const MYSQL_NAME 			= '';
	
	const DEFAULT_CONTROLLER 	= 'Tasks';
	const DEFAULT_METHOD 		= 'index';
	const DEFAULT_PER_PAGE 		= 3;
	const DEFAULT_ORDER_BY		= 'id';
	const DEFAULT_ORDER_SORT	= 'desc';
	
	const PERMITTED_ORDER_BY 	= ['id', 'name', 'email', 'text'];
	const PERMITTED_ORDER 		= ['asc', 'desc'];
}