<?php 
namespace Test;
use Test\Core\Core;

// use autoload for classes
require_once('autoload.php');

// use RedBeans PHP as ORM
require_once('lib/rb.php');

try {
	
	// init
	Core::init($_SERVER['REQUEST_URI']);
}
catch (\Error $e) {
	
	// Critical errors
	die($e-> getMessage() . ' in ' . $e-> getFile() . ':' . $e-> getLine());
}
