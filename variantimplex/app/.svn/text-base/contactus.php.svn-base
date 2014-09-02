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
session_start();
require_once('../core/DB.php');
include_once('cmsController.php');
include_once('cmsModel.php');
include_once('menuModel.php');
include_once('contactusController.php');
include_once('validation.php');
$contactus = new contactusController();
if(count($_POST)){
	$validation  = new Validation();
	$err = "";
	foreach ($_POST as $key => $val) {
		${$key} = get_magic_quotes_gpc()?html_entity_decode(utf8_encode(trim(urldecode($val))), ENT_QUOTES):addslashes(html_entity_decode(trim(urldecode($val)), ENT_QUOTES));
	}
	
	if($name == '') $err .="<br/>Contact name must not be blank.";
	if($email == '') $err .="<br/>Email address must not be blank.";
	elseif(!($validation->validateEmail($email))) $err .="<br/> Please provide vaild email address.";
	if($comments=='') $err .= "<br/> Comments may not be blank.";
	if($err==''){
		$contactus->saveData($_POST);
	} 
}

$contactus->index($err, $_POST);

?>