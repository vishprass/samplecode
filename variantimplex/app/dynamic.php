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
$pagename = $_GET['page'];
include_once('cmsController.php');
include_once('cmsModel.php');
include_once('indexController.php');
include_once('menuModel.php');
$filename = "view/theme1/pagetemplate/".$pagename.".html";
$cms = new cmsModel();
$content = $cms->getPageContent($filename);
$index_controller = new indexController();
$index_controller->head();
$index_controller->left();
$index_controller->right();
?>


<body>
<?=stripslashes($content)?>
<?php
$index_controller->foot();
?>
