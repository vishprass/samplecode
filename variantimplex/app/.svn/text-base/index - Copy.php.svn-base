<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('ROOT',dirname(dirname(__FILE__)));
define('HOST', 'http://'.$_SERVER['HTTP_HOST']."/index.php/");
define('HOST2', 'http://'.$_SERVER['HTTP_HOST']."/");
define('APP_DIR','app');
define('CTRL_DIR','controllers');
define('XTPL_DIR','view'.DS.'themes'.DS.'default');
define('STYLE',HOST2.APP_DIR.'/view/themes/styles/default/');
define('SCRIPT',HOST2.APP_DIR.'/view/themes/scripts/');
define('IMAGE',HOST2.APP_DIR.'/view/themes/media/images/');
define('CONFIGS',ROOT.DS.'config');
define('CONTROLLER',ROOT.DS.APP_DIR.DS.'controllers');
define('MODEL',ROOT.DS.APP_DIR.DS.'models');
define('THUMB',HOST.'app/Pictures/thumbs/');

if(!defined('CORE_DIR')){
	define('CORE_DIR',ROOT.DS.'core');	
}
set_include_path(get_include_path() . PATH_SEPARATOR.ROOT.DS.PATH_SEPARATOR.ROOT.DS.APP_DIR.DS.PATH_SEPARATOR.ROOT.DS.APP_DIR.DS.CTRL_DIR.DS.PATH_SEPARATOR.CONTROLLER.DS.PATH_SEPARATOR.MODEL.DS.PATH_SEPARATOR.CORE_DIR);
if(!file_exists(ROOT.'\config\config.ini')){
		include(ROOT.'\installer\index.php');
		exit();
}
if (!include(CORE_DIR.DS.'bootstrap.php')) {
		trigger_error("eek....! Framework path got messed .  Check the value of CORE_DIR in APP_DIR /webroot/index.php.  It should point to the directory containing your " . DS . " core directory and your " . DS . "vendors root directory.", E_USER_ERROR);
	}
	
	require_once("aclController.php");
	//print_r($_SERVER);
	$tmp  = explode("/", $_SERVER['REQUEST_URI']);
	$controller = $tmp[2];
	if($controller=='') $controller = 'index';
	$userid=$_SESSION['userid']?$_SESSION['userid']:'';
	$userlbl=$_SESSION['userlevel']?$_SESSION['userlevel']:1;
	$acl = new aclController($userid, $userlbl);
	$res = $acl->checkAccess($controller);
	if(!$res){
		header("Location:".HOST."cms/");
	}
	if (isset($_GET['url']) && $_GET['url'] === 'favicon.ico') {
		return;
	} else {
		$Dispatcher = new Dispatcher();
		$Dispatcher->dispatch();
	}	
	

?>
