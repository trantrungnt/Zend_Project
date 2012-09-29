<?php
defined('APP_PATH')
	|| define('APP_PATH', realpath(dirname(__FILE__) . '/app'));
defined('APP_ENV')
		|| define('APP_ENV',
				  (getenv('APP_ENV') ? getenv('APP_ENV') : 'developer'));

set_include_path(implode(PATH_SEPARATOR, array(
				dirname(__FILE__) . '/lib',
				get_include_path(),)));
				
define('PUBLIC_PATH', realpath(dirname(__FILE__) ."/public"));
define('TEMP_PATH',realpath(PUBLIC_PATH ."/tmp"));
define('BASE_PATH', realpath(dirname(__FILE__)));
define('TEMPLATE_PATH', realpath(PUBLIC_PATH ."/templates"));
define('SCRIPT_PATH', realpath(PUBLIC_PATH . '/scripts'));
define('FILE_PATH', PUBLIC_PATH . '/files');
define('CAPTCHA_PATH', PUBLIC_PATH . '/captcha');
define('CONFIG_PATH', APPLICATION_PATH . '/configs');
define('CACHE_PATH', APPLICATION_PATH . '/cache');

define('TEMPLATE_URL', '/public/templates');
define('APP_URL', '/fashion4u');
define('SCRIPT_URL', APPLICATION_URL . '/public/scripts');
define('FILE_URL', APPLICATION_URL . '/public/files');
define('CAPTCHA_URL', APPLICATION_URL.'/public/captcha');