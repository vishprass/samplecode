<?
/**
  * File Name    : categories file (front Section).
  * Date Created : jun 15 2010    
  * Team         : Vibhors,vishnu
  * Contents     : Dispalying categories 
  **/ 
  ?>
  <?php
include_once('menuModel.php');
include_once('cmsModel.php');
include_once('tstmnyModel.php');
include_once('userModel.php');

class categoriesviewController extends baseController {

	public function index($id ='',$pgno ='',  $deleteError = false){ 
		$this->head();
		$this->product($id,$pgno,$deleteError = false);
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
	
	public function product($id,$pgno,$deleteError = 'delete' ){
	
		$cms = new cmsModel();
		$user_model= new userModel();
		$modules = $cms->getUiModulesByPage($page_id);
		$content = array_shift($cms->getHomeContent());
		$body = stripslashes($content['body']);
		$replace = "src=".IMAGE;
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, $body);
		$cates = $cms->getcate($id, $username, $email, $accesslevel, HOST.'categoriesview/index', $pgno);
		//$pagelinks = $cms->getPagelinks();
		
		$xtpl = new Xtemplate("users".DS."categories.xtpl");
	
				$cate_list = array(
				            
							"NAME"=>ucfirst($cates[0]['name']),
							"DESCRIPTION"=>ucfirst($cates[0]['description'])
						
					);
		$xtpl->assign('DATA',$cate_list);
	    $xtpl->parse('main.row');
		 $xtpl->parse('main.aaa');
		$res=$cms->getcate1($cates[0]['id'], $username, $email, $accesslevel, HOST.'categoriesview/index', $pgno);
	   $pagelinks = $cms->getPagelinks();
	    $max=count($res);
		for($i=0;$i<$max;$i++){
		if($res[$i]['image_path']==""){$path="notAvailable.png";}else{$path=$res[$i]['image_path'];}
		
	        $cates_list = array(
				            
							"NAME1"=>"<a href='".HOST."productview/index/".$res[$i]['id']."'>".ucfirst($res[$i]['name'])."</a>",
							"DESCRIPTION1"=>ucfirst($res[$i]['description']),
							"IMAGE1"=>$path
						
					);
	     $xtpl->assign('DATA',$cates_list);
	     $xtpl->parse('main.abc');
		 $xtpl->parse('main.bc');
		}
		$news = $cms->getNews();
		if(count($news) >5){$max=5;}else{$max=count($news);}
	  	for($i=0;$i<$max;$i++){
		if($news[$i]['image_path']==""){$path="notAvailable.png";}else{$path=$news[$i]['image_path'];}
		$cates_list = array(
				            "ID1"=>ucfirst($news[$i]['id']),
							"TITLE"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>".ucfirst($news[$i]['title'])."</a>",
							"IMAGE2"=>$path,
							"CREATED"=>ucfirst($news[$i]['date']),
							"LINK"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>",
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