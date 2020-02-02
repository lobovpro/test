<?php
namespace Test\Core;

/**
 * Config  
 *
 * DB settings, default app settings
 */
class Config 
{
	
	const DB_HOST 				= '127.0.0.1';
	const DB_USER 				= 'lobov';
	const DB_PASSWD 			= 'cntrfh12k';
	const DB_NAME 				= 'lobov_ticket';
	
	const DEFAULT_CONTROLLER 	= 'Tasks';
	const DEFAULT_METHOD 		= 'index';
	const DEFAULT_PER_PAGE 		= 3;
	const DEFAULT_ORDER_BY		= 'id';
	const DEFAULT_ORDER_SORT	= 'desc';
	
	const PERMITTED_ORDER_BY 	= ['id', 'name', 'email', 'text'];
	const PERMITTED_ORDER 		= ['asc', 'desc'];
}