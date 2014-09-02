<?php
define('DS', DIRECTORY_SEPARATOR);
define('APP_DIR','app');
define('CTRL_DIR','controllers');
define('XTPL_DIR','view'.DS.'themes'.DS.'default');
define('ROOT',dirname(__FILE__));

if(!defined('CORE_DIR')){
	define('CORE_DIR',ROOT.DS.'core');	
}
if (function_exists('ini_set')) {
		ini_set('include_path',
			ini_get('include_path') . PATH_SEPARATOR.ROOT.DS.PATH_SEPARATOR.ROOT.DS.APP_DIR.DS.PATH_SEPARATOR.ROOT.DS.APP_DIR.DS.CTRL_DIR.DS.PATH_SEPARATOR
		);
		define('APP_DIR', null);
	//	define('CORE_PATH', null);
}
	//echo APP_DIR.DS.'index.php';
require_once(APP_DIR.DS.'index.php');
?>
