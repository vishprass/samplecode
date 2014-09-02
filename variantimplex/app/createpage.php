<?php
define('ROOT',dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT.DS.'app');
define('APP_CONTROLLER',APP_DIR.DS.'controllers'.PATH_SEPARATOR);
define('APP_MODELS',APP_DIR.DS.'models'.PATH_SEPARATOR);
define('APP_VIEW',APP_DIR.DS.'view'.DS.'theme1'.DS.'template1');
define('APP_XTEMPLATE',ROOT.DS.'vendors'.DS.'xtpl'.PATH_SEPARATOR);
if(!defined('CORE_DIR')){
	define('CORE_DIR',ROOT.DS.'core');	
}
set_include_path(get_include_path().PATH_SEPARATOR.CORE_DIR.PATH_SEPARATOR.ROOT.PATH_SEPARATOR.APP_CONTROLLER.PATH_SEPARATOR.APP_MODELS.PATH_SEPARATOR.APP_VIEW.PATH_SEPARATOR.APP_XTEMPLATE);
require_once("loginCheck.php");
session_start();
include_once('menuController.php');
//include_once('cmsController.php');
include_once('menuModel.php');
include_once('cmsModel.php');
include_once('createPageController.php');
$err = '';
if(count($_POST)){
	if($_POST['name'] == '') $err = 'Page name must not be blank.';
	elseif(strip_tags($_POST['desc'])=='') $err = 'Page content may not be blank.';
	if($err==''){
		$cms = new cmsModel();
		$res= $cms->savePages($_POST['name'], $_POST['desc']);
		if($res==1) { 
				if($_POST['id']){
					$msg = "Data updated Successfully.";
				}else{
					$msg = "Data inserted Successfully.";
				}
				echo "<script>alert('$msg'); document.location.href=document.location.href;</script>";
		}
	}
}

	$cpage = new createPageController();
	if($_GET['page']!='') $page = $_GET['page'];
	$cpage->admin_createpage($err, $page);
	
?>