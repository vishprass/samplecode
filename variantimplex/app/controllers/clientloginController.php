<?php
include_once('menuModel.php');
include_once('cmsModel.php');
include_once('tstmnyModel.php');

class clientloginController extends baseController{

	public function index(){
		$this->head();
		$this->body();
		$this->foot();
		$time_end = microtime(true);
		global $time_start;
		$time = $time_end -$time_start;
	}
	
	public function head($title = '', $meta_keys = '', $meta_desc = ''){
		$xtpl = new Xtemplate("users".DS."header.xtpl");
		$title = empty($title)? 'Biosfera': $title;
		$meta_desc = empty($meta_desc)? 'Biosfera': $meta_desc;
		$meta_keys = empty($meta_keys)? 'Biosfera': $meta_keys;
		$xtpl->assign('STYLE', STYLE.'users/');
		$xtpl->assign('SCRIPT', SCRIPT.'users/');
		$xtpl->assign('IMAGE', IMAGE.'users/');
		$xtpl->assign('TITLE', $title);
	    $cms=new cmsModel();
		if($_POST){
	    $res=$cms->check_login($_POST);
		if($res[0]['count']==1)
			{ 
		$username=$_SESSION['username']?$_SESSION['username']:$_POST['username'];
		if ($username) $_SESSION['username'] = $username;
		$xtpl->assign("CLICK","<a href='".HOST."clientlogin'>".Login."</a>");
		if (isset($_SESSION['username'])) {
			$xtpl->assign('WELCOME',"<b><i>Bienvenido ".$_SESSION['username']."</b></i>");
			$xtpl->assign("LOG","Logout");
			$xtpl->assign("LOGOUTLINK",HOST."index/logout");
        } else {
		    $xtpl->assign("LOG","Login");
			$xtpl->assign("LOGOUTLINK",HOST."clientlogin");
		}
		header('Location:'.HOST."index");
	    }
		else{
		
		
		}
		}
		
		$xtpl->assign('META_DESC', $meta_desc);
		$xtpl->assign('META_KEYS', $meta_keys);
		$menumodel = new menuModel();
		$links = $menumodel->getPublishMenues('1', 'topmenu');
		$xtpl->assign('HOST', HOST);
		$xtpl->assign('TOPMENU', $links);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	

	public function foot( $analytics = ''){

		$xtpl = new Xtemplate("users".DS."footer.xtpl");
		$xtpl->assign('IMAGE', IMAGE.'users/');
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	public function topmenu(){
		$xtpl = new Xtemplate("users".DS."topmenu.xtpl");
		$menumodel = new menuModel();
		$links = $menumodel->getPublishMenues('1', 'topmenu');
		$xtpl->assign('TOPMENU', $links);
		$xtpl->assign('HOST', HOST);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
		public function body(){
		
		$cms = new cmsModel();
		$modules = $cms->getUiModulesByPage($page_id);
		$content = array_shift($cms->getHomeContent());
		$body = stripslashes($content['body']);
		$replace = "src=".IMAGE;
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, $body);
		$xtpl = new Xtemplate("users".DS."clientlogin.xtpl");
	
		
		$cms=new cmsModel();
		if($_POST)
		{
			//print_r($_POST);
		$res=$cms->check_login($_POST);
		//print_r($res);
		if($res[0]['count']==1)
			{ 
		$username=$_SESSION['username']?$_SESSION['username']:$_POST['username'];
		if ($username) $_SESSION['username'] = $username;
		$xtpl->assign("CLICK","<a href='".HOST."clientlogin'>".Login."</a>");
		if (isset($_SESSION['username'])) {
			$xtpl->assign('WELCOME',"<b><i>Bienvenido ".$_SESSION['username']."</b></i>");
			$xtpl->assign("LOG","Logout");
			$xtpl->assign("LOGOUTLINK",HOST."index/logout");
        } else {
		    $xtpl->assign("LOG","Login");
			$xtpl->assign("LOGOUTLINK",HOST."clientlogin");
		}
		header('Location:'.HOST."index");
	    }
		
	   else{
	   $xtpl = new Xtemplate("users".DS."clientlogin.xtpl");
	 	$xtpl->assign('WRONG',"Wrong username or password");
		}
		}
		/*$xtpl->assign('DATA',$men_list);
		$xtpl->assign('BODY1', $body);
		if(count($news) != 0){
			$xtpl->assign('TITLE', $news['title']);
			} 
			
		$xtpl->assign('IMAGES', IMAGE.'users/');
		$xtpl->assign('HOST', HOST);
		$login_status = (isset($_REQUEST['stat']) && $_REQUEST['stat']==0)?false:true;
		if(!$login_status) $xtpl->assign('WRONG',"Wrong username or password");
		else $xtpl->assign('WRONG',"");*/
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	public function notfound(){
		$xtpl = new Xtemplate("users".DS."notfound.xtpl");
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
}
?>