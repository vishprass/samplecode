<?php
include_once('indexController.php');
include_once('cmsController.php');
include_once('cmsModel.php');
include_once('tstmnyModel.php');
class searchController extends indexController{
	public function index($keyword ='',$pgno ='',  $deleteError = false){
		//echo $_POST['search']; die;
		$keyword = $_POST['search'];
		$this->head();
		$this->body($keyword,$pgno,$deleteError = false);
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
		$xtpl->assign('META_DESC', $meta_desc);
		$xtpl->assign('META_KEYS', $meta_keys);
		$menumodel = new menuModel();
		$links = $menumodel->getPublishMenues('1', 'topmenu');
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
	
	
	
	public function body($keyword,$pgno,$deleteError = 'delete'){
		$cms = new cmsModel();
		$keyword = addslashes($keyword);
		$xtpl = new Xtemplate("users".DS."search.xtpl");
		$res = $cms->searprod($keyword,$username, $email, $accesslevel, HOST.'search/index', $pgno);
		$max=count($res);
		$pagelinks = $cms->getPagelinks();
		
		
		if($max>0){
		$xtpl->assign('PRODUCTS', 'Products');
		for($i=0;$i<$max;$i++){
		if($res[$i]['image']==""){$path="notAvailable.png";}else{$path=$res[$i]['image'];}
		$prod_list = array(
		                    
				            "IMAGE"=>$path,
							"NAME"=>"<a href='".HOST."productdetail/index/".$res[$i]['id']."'>".ucfirst($res[$i]['name'])."</a>",
							"COST"=>$res[$i]['price'],
							"DESCRIPTION"=>wordwrap(ucfirst($res[$i]['description']), 20, "<br>\n")
					);
		 $xtpl->assign('DATA',$prod_list);
	    $xtpl->parse('main.col');
		 
		}
		}else{
		$xtpl->assign('NORECORDS', 'Sorry No Results found');
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
							"NEWS"=>wordwrap(substr(ucfirst($news[$i]['body']), 0, 50), 20, "<br>\n")
						
					);
		 $xtpl->assign('DATA',$cates_list);
	    $xtpl->parse('main.abc');
		 
		}
		
		$xtpl->assign('IMAGE', IMAGE.'users/');
		$xtpl->assign('PAGINATION', $pagelinks);
		$xtpl->assign('CONTAINT', $str);
		$xtpl->parse('main');
		$xtpl->out('main');
	}		
	

	
}
?>