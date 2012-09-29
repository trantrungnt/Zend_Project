<?php
defined('APP_PATH')
	|| define('APP_PATH', realpath(dirname(__FILE__) . '/app'));
	
defined('APP_PATH_IMG')
	|| define('APP_PATH_IMG', realpath(dirname(__FILE__) ));

defined('IMG_PATH_FRONT')
	|| define('IMG_PATH_FRONT', realpath(dirname(__FILE__) . '/app/template/frontend/images/'));
	
	
defined('APP_ENV')
		|| define('APP_ENV',
				  (getenv('APP_ENV') ? getenv('APP_ENV') : 'f4u'));
set_include_path(implode(PATH_SEPARATOR, array(
				dirname(__FILE__) . '/library',
				get_include_path(),)));
include ('Zend/Application.php');
$app = new Zend_Application ( APP_ENV, APP_PATH . '/config/config.ini' );
//var_dump($app);die;
$app->bootstrap ()->run ();