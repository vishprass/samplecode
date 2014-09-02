<?php
define('APP_DIR','app');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT',dirname(__FILE__));

if(!defined('CORE_DIR')){
	define('CORE_DIR',ROOT);	
}

set_include_path(get_include_path().PATH_SEPARATOR.CORE_DIR.PATH_SEPARATOR.ROOT.DS.APP_DIR.DS);
echo get_include_path();