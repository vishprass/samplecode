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
include_once('../core/DB.php');
include_once('userModel.php');
include_once('cmsController.php');
include_once('cmsModel.php');

$err = '';
if($_GET['logout']==1) { 
	session_destroy();
	header("Location: ./index.php");
}
if(count($_POST)){
	if($_GET['login']==1) {
		$res = validateLogin($_POST['username'], $_POST['password']);
		if($res==1){
			header("Location: ./admin.php");
		}else{
			$err = $res;
		}
	}else{
		$cms = new cmsModel();
		$res= $cms->saveData($_POST['body'], $_POST['title']);
		if($res){
			echo "<script>alert('data successfully inserted.'); document.location.href=document.location.href;</script>";
		}
	}
}


 function validateLogin($uname, $password){
    $err = '';
	if($uname=='' || $password=='') {
		$err = " User Name or Password may not be blank.";
	}else{
		$umodel = new userModel();
		$res = $umodel->validateLoginDetails($uname, $password);
		if($res[0]['id'] == '') $err = " User Name and Password does not match.";
		else $err = '';
	}
	if($err != ''){
		return $err;
	}else{
		$_SESSION['user'] = $res[0]['id'];
		return 1;
	}
}

$cms = new cmsController();
if($_SESSION['user']!=''){
	$cms->admin_index();
}else{
	
	$cms->admin_login($err);
}

?>