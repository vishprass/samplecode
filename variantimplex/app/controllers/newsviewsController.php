<?
/**
  * File Name    : news file (front Section).
  * Date Created : jun 15 2010    
  * Team         : Vibhor,vishnu
  * Contents     : Dispalying news 
  **/ 
  ?>
<?php
include_once('menuModel.php');
include_once('cmsModel.php');
include_once('tstmnyModel.php');
class newsviewsController extends baseController{

	public function index($id ='',$pgno ='', $deleteError = false){ 
		$this->head();
		$this->news($id,$pgno,$deleteError = false);
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
	
	public function news($id,$pgno,$deleteError = 'delete' ){
	    $cms = new cmsModel();
		$modules = $cms->getUiModulesByPage($page_id);
		$content = array_shift($cms->getHomeContent());
		$body = stripslashes($content['body']);
		$replace = "src=".IMAGE;
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, $body);
		$xtpl = new Xtemplate("users".DS."newsviews.xtpl");
	   if($id){
			$news = $cms->getNews1($id);
			if($news[0]['image_path']==""){$path="notAvailable.png";}else{$path=$news[0]['image_path'];}
             $cates_list = array(
				            "ID"=>ucfirst($news[0]['id']),
							"TITLE"=>ucfirst($news[0]['title']),
							"IMAGE2"=>$path,
							"CREATED"=>ucfirst($news[0]['date']),
							"NEWS"=>wordwrap(ucfirst($news[0]['body']), 20, "<br>\n")
						
					);
		$xtpl->assign('DATA',$cates_list);
	    $xtpl->parse('main.abc');
		
		} 
    $news = $cms->getNews();
	if(count($news) >5){$max=5;}else{$max=count($news);}
  			for($i=0;$i<$max;$i++){
	
			if($news[$i]['image_path']==""){$path="notAvailable.png";}else{$path=$news[$i]['image_path'];}
             $cates_list = array(
				            "ID1"=>ucfirst($news[$i]['id']),
							"TITLE1"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>".ucfirst($news[$i]['title'])."</a>",
							"LINK"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>",
							"IMAGE1"=>$path,
							"CREATED1"=>ucfirst($news[$i]['date']),
							"NEWS1"=>wordwrap(substr(ucfirst($news[$i]['body']), 0, 60), 30, "<br>\n")
						
					);
		$xtpl->assign('DATA',$cates_list);
	    $xtpl->parse('main.cde');
		}
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