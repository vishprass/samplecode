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
require("loginCheck.php");
session_start();
include_once('menuController.php');
include_once('menuModel.php');
if(isset($_GET['action']) && ($_GET['action']== 'handler')){

}
$err = '';
if(count($_POST)){
	if($_POST['menutype'] == '') $err = 'Please select menu type.';
	elseif($_POST['menuname']=='') $err = 'Please enter menu name.';
	elseif($_POST['link']=='') $err = 'Please enter menu link.';
	elseif($_POST['internal'] =='' && (!preg_match("#^http://www\.[a-z0-9-_.]+\.[a-z]{2,4}$#i",$_POST['link']))) $err = "Please Enter valid URL. \n http://www.goole.com";
	$link = $_POST['link'];
	if($_POST['internal']!='') { 
						if(preg_match("/^(.*)\.(html|php|cgi|htm)+$/i",$_POST['pagelist'],$k)){
							$_POST['pagelist'] = $k[1];
						}
						$link = "./dynamic.php?page=".$_POST['pagelist'];
			}
	if($err==''){
		$menu = new menuModel();
		$res= $menu->saveMenues($_POST['menutype'], $_POST['menuname'], $link, $_POST['publish'], $_POST['id']);
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

	$menu = new menuController();
	if($_GET['delid']!=''){
		$menu->deleteRecord($_GET['delid']);
		header("Location:./menumanager.php");
	}
	if($_GET['dir']!='' && $_GET['id']!=''){
		$menu->orderMenu($_GET['dir'], $_GET['id']);
	}
	
	if($_GET['id']!='') $id = $_GET['id'];
	$menu->admin_index($err, $id);
	
?>