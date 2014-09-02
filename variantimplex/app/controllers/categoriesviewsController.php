<?
/**
  * File Name    : category file (front Section).
  * Date Created : jun 15 2010    
  * Team         : Vibhors,vishnu
  * Contents     : Dispalying categories 
  * Date Created : jun 17 2010   By Vibhor 
  **/ 
?>
<?php
include_once('menuModel.php');
include_once('cmsModel.php');
include_once('tstmnyModel.php');
include_once('userModel.php');

class categoriesviewsController extends baseController{

	public function index($pgno ='', $id ='', $deleteError = false){ 
		$this->head();
		$this->product($pgno, $id, $deleteError = false);
		$this->foot();
		$time_end = microtime(true);
		global $time_start;
		$time = $time_end -$time_start;
		}
	
	public function head($title = '', $meta_keys = '', $meta_desc = ''){
	     $cms = new cmsModel();
		$xtpl = new Xtemplate("users".DS."header.xtpl");
		$title = empty($title)? 'Biosfera': $title;
		$meta_desc = empty($meta_desc)? 'Biosfera': $meta_desc;
		$meta_keys = empty($meta_keys)? 'Biosfera': $meta_keys;
		$xtpl->assign('STYLE', STYLE.'users/');
		$xtpl->assign('SCRIPT', SCRIPT.'users/');
		$xtpl->assign('IMAGE', IMAGE.'users/');
		$xtpl->assign('TITLE', $title);
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
		$xtpl->assign('META_DESC', $meta_desc);
		$xtpl->assign('META_KEYS', $meta_keys);
		$menumodel = new menuModel();
		$links = $menumodel->getPublishMenues('1', 'topmenu');
	   $res=$cms->getpros();
		$max=count($res);
		for($i=0;$i<$max;$i++){
		$menu_list = array(
		  "NAME"=>"<a href='".HOST."productdetail/index/".$res[$i]['id']."'>".$res[$i]['name']."</a>"
		 
		 );
		        $xtpl->assign('DATA',$menu_list);
				$xtpl->parse('main.row');
		
		}
		
		$res1=$cms->getcatemenu();
		$max=count($res1);
		for($i=0;$i<$max;$i++){
		$menu_list = array(
		  "NAME"=>"<a href='".HOST."categoriesview/index/".$res1[$i]['id']."'>".$res1[$i]['name']."</a>"
		 
		 );
		        $xtpl->assign('DATA',$menu_list);
				$xtpl->parse('main.abc');
		
		}
		
		$xtpl->assign('TOPMENU', $links);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	public function product( $pgno, $id, $deleteError = 'delete' ){
		$cms = new cmsModel();
		$user_model = new userModel();
		$modules = $cms->getUiModulesByPage($page_id);
		$content = array_shift($cms->getHomeContent());
		$body = stripslashes($content['body']);
		$replace = "src=".IMAGE;
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, $body);
		$cates = $cms->getCates('', $username, $email, $accesslevel, HOST.'categoriesviews/index', $pgno);
		
		$pagelinks = $cms->getPagelinks();
		$xtpl = new Xtemplate("users".DS."categoriesviews.xtpl");
		$max=count($cates);
		for($i=0;$i<$max;$i++){
	    
	if($cates[$i]['image_path']==""){$path="notAvailable.png";}else{$path=$cates[$i]['image_path'];}
				$cate_list = array(
							"NAME1"=>"<a href='".HOST."categoriesview/index/".$cates[$i]['id']."'>".ucfirst($cates[$i]['name'])."</a>",
							"LINK1"=>"<a href='".HOST."productview/index/".$cates[$i]['id']."'>View Products</a>",
							"DESCRIPTION1"=>ucfirst($cates[$i]['description']),
							"IMAGE1"=>$path
							);
					
		$xtpl->assign('DATA',$cate_list);
	   $xtpl->parse('main.abc');
		}
		    $news = $cms->getNews();
			if(count($news) >5){$max=5;}else{$max=count($news);}
  			for($i=0;$i<$max;$i++){
			if($news[$i]['image_path']==""){$path="notAvailable.png";}else{$path=$news[$i]['image_path'];}
	        $cates_list = array(
				            "ID1"=>ucfirst($news[$i]['id']),
							"TITLE"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>".ucfirst($news[$i]['title'])."</a>",
							"LINK"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>",
							"IMAGE2"=>$path,
							"CREATED"=>ucfirst($news[$i]['date']),
							"NEWS"=>wordwrap(substr(ucfirst($news[$i]['body']), 0, 60), 30, "<br>\n")
						
					);
		  $xtpl->assign('DATA',$cates_list);
	      $xtpl->parse('main.cde');
		 }
		 
		 
		 
		
		
		$word="buildings";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE1"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA1',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE1"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA1',$cates_li);
		  }
		
		$word="cleaning";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE2"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA2',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE2"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA2',$cates_li);
		  }
		
		$word="coffee";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE3"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA3',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE3"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA3',$cates_li);
		  }
		
		$word="insurance";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE4"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA4',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE4"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA4',$cates_li);
		  }
		
		
		$word="materials";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE5"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE5"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA',$cates_li);
		  }
		
		
		
		
		 
		 
		 
		 
		$xtpl->assign('PAGINATION', $pagelinks);
		$xtpl->assign('IMAGES', IMAGE.'users/');
		$xtpl->assign('HOST', HOST);
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
	
	}
?>