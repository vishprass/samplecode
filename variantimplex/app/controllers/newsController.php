<?php  
include_once('indexController.php');
include_once('cmsController.php');
include_once('cmsModel.php');
include_once('tstmnyModel.php');
include_once('menuModel.php');

class newsController extends indexController{
	
	public function index($id){
		$this->head();
		$this->body_left_top();
		$this->body_right_top($id);
		$this->body_left_bottom($id);		
		$this->body_right_bottom($id);
		$this->foot();
	}
	

	public function body_left_bottom($id){
		$tst = new tstmnyModel();
		$res = $tst->getNewsDetail($id, 1);
		$xtpl = new Xtemplate("users".DS."bodyinnerleftbottom.xtpl");	
		$xtpl->assign('TITLE', stripslashes($res[0]['title']));
		$xtpl->assign('CONTAINT', stripslashes($res[0]['body']));
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	public function body_right_bottom($id){
		$this->rightmenu();
	}
	
	
	public function rightmenu(){
		$xtpl = new Xtemplate("users".DS."rightmenu.xtpl");
		$menumodel = new menuModel();
		$links = $menumodel->getPublishMenues('1', 'topmenu');
		$xtpl->assign('RIGHTMENU', $links);
		$xtpl->assign('HOST', HOST);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
}
?>