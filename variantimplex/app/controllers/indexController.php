<?php
include_once('menuModel.php');
include_once('cmsModel.php');
include_once('tstmnyModel.php');
class indexController extends baseController{
	public function index() {
/*	if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'clientlogin/');
			}*/
		#$stat=$this->login($status='');
		//$stat=3;
		$this->head($stat);
		
		$this->body();
		$this->foot();
		$time_end = microtime(true);
		global $time_start;
		$time = $time_end -$time_start;
	}
	public function login($status='') {
		    $cms=new cmsModel();
			$res=$cms->check_login($_POST);
			if($res[0]['count']==0)
			{   $xtpl = new Xtemplate("users".DS."clientlogin.xtpl");
				$time_end = microtime(true);
				global $time_start;
				$time = $time_end - $time_start;
				$this->foot();
				exit(0);
				
			}
			
	}
	
	
	public function head($stat='',$title = '', $meta_keys = '', $meta_desc = ''){
	
		$cms = new cmsModel();
		$xtpl = new Xtemplate("users".DS."header.xtpl");
		$title = empty($title)? 'Variant Implex': $title;
		$meta_desc = empty($meta_desc)? 'Variant Implex': $meta_desc;
		$meta_keys = empty($meta_keys)? 'Variant Implex': $meta_keys;
		$xtpl->assign('STYLE', STYLE.'users/');
		$xtpl->assign('SCRIPT', SCRIPT.'users/');
		$xtpl->assign('IMAGE', IMAGE.'users/');
		$xtpl->assign('TITLE', $title);
		
		$username=$_SESSION['username']?$_SESSION['username']:$_POST['username'];
		if ($username) $_SESSION['username'] = $username;
		$xtpl->assign("CLICK","<a href='".HOST."clientlogin'>".Login."</a>");
		if(isset($_SESSION['username'])){
		$xtpl->assign('WELCOME',"<b><i>Welcome ".$_SESSION['username']."</b></i>");
		$xtpl->assign("LOG","Logout");
		$xtpl->assign("LOGOUTLINK",HOST."index/logout");
		
		#$xtpl->assign("CLICK","<a href='".HOST."'>".Logout."</a>");
        }
		else
		{
			$xtpl->assign("LOG","Login");
			$xtpl->assign("LOGOUTLINK",HOST."clientlogin");
		}
		
		
		$xtpl->assign('META_DESC', $meta_desc);
		$xtpl->assign('META_KEYS', $meta_keys);
		$menumodel = new menuModel();
		$links = $menumodel->getPublishMenues();
		$max=count($links);
		for($i=0;$i<$max;$i++){
		$menu_list = array(
		  "TOPMENU"=>"<a href='".HOST.$links[$i]['link']."'>".$links[$i]['label']."</a>"
		 
		 );
		        $xtpl->assign('DATA',$menu_list);
				$xtpl->parse('main.menu');
		
		}
		
		
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
		
		
		$xtpl->assign('SPACE', IMAGE.'users/spacer_line.png');
		$xtpl->assign('HOST', HOST);
		//$xtpl->assign('TOPMENU', $links);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	public function logout(){
		session_unset($_SESSION['username']);
		header('Location:'.HOST."index");
		
	}
	
	public function body( $body_content, $title, $page_id ){
		$cms = new cmsModel();
			$news =$cms->getNews();
		
		$content = array_shift($cms->getHomeContent());
		$body = stripslashes($content['body']);
		$replace = "src=".IMAGE;
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, $body);
		$cates = $cms->getCates();
    $xtpl = new Xtemplate("users".DS."body.xtpl");
	if(count($news) >5){$max=5;}else{$max=count($news);}
  	for($i=0;$i<$max;$i++){
	//for($i=0;$i<5;$i++){
	if($news[$i]['image_path']==""){$path="notAvailable.png";}else{$path=$news[$i]['image_path'];}
				$menu_list = array(
				            "ID"=>$cates[$i]['id'],
							"ID1"=>$news[$i]['id'],
							"IMAGE2"=>$path,
							"NAME"=>ucfirst($cates[$i]['name']),
							"TITLE"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>".ucfirst($news[$i]['title'])."</a>",
							"CREATED"=>$news[$i]['date'],
							"NEWS"=>wordwrap(substr(ucfirst(utf8_encode(html_entity_decode($news[$i]['body']))), 0, 60), 25, "<br>\n"),
							//"NEWS"=>wordwrap(substr(ucfirst($news[$i]['body']), 0, 60), 30, "<br>\n"),
							"LINK1"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>",
							"LINK"=>"<a href='".HOST."categoriesview/index/".$cates[$i]['id']."'>".ucfirst($cates[$i]['name'])."</a>"
					);
				$xtpl->assign('DATA',$menu_list);
				$xtpl->parse('main.row');
				$xtpl->parse('main.abc');
		}
		$ctgry = $cms->getCates1();
		for($i=0;$i<3;$i++){
		$menu_list = array(
		"CATNAME"=>"<a href='".HOST."categoriesview/index/".$ctgry[$i]['id']."'>".$ctgry[$i]['name']."</a>",
		"CATDESC"=>substr(ucfirst(utf8_encode(html_entity_decode($ctgry[$i]['description']))), 0, 60),
		"CATLINK"=>"<a href='".HOST."categoriesview/index/".$ctgry[$i]['id']."'>Click here</a>"
		);
		$xtpl->assign('DATA',$menu_list);
    	$xtpl->parse('main.yyy');
		}
		
		$modules = $cms->getUiModulesByPage($page_id);
		$xtpl->assign('TITLE',$title);
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, $body);
		$newbody =($body);
		$xtpl->assign('BODY_CONTENT',$newbody);
		
		if(count($news) != 0){
			$xtpl->assign('TITLE', $news['title']);
			$xtpl->parse('main.newsflash');
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
	
	public function __call($name, $args=array()){
		if( filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_ENCODE_HIGH) ){
			$cms = new cmsModel();
			$content = array_shift($cms->getPageDetails($name));
			$pagename = $content['pagename'];
			$page_id = $content['id'];
			$page_title = empty($content['page_titles'])? $content['title'] :$content['page_titles'];
			$meta = $content['meta'];
			$description = $content['description'];
			$body_content = $content['body'];
			if(empty($content)){
				$pagename = "404";
			}
			$this->head($page_title, $page_title, $meta,$description);
			switch($pagename) {
				case 'home':
					$this->body( $page_id);
					break;
				case '404':
					$this->notfound();	
					break;
				default:
					$this->body2($body_content, $content['title'], $page_id);
					break;	
				}		
			$this->foot();
		 }else{
		 	$this->index();
		 }	
	}
	
	
	public function body2($body, $title ='', $page_id ){
		$cms = new cmsModel();
			$news =$cms->getNews();
		
		$content = array_shift($cms->getHomeContent());
		$body = stripslashes($content['body']);
		$replace = "src=".IMAGE;
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, $body);
		$cates = $cms->getCates();
    $xtpl = new Xtemplate("users".DS."body.xtpl");
	if(count($news) >5){$max=5;}else{$max=count($news);}
  	for($i=0;$i<$max;$i++){
	//for($i=0;$i<5;$i++){
	if($news[$i]['image_path']==""){$path="notAvailable.png";}else{$path=$news[$i]['image_path'];}
				$menu_list = array(
				            "ID"=>$cates[$i]['id'],
							"ID1"=>$news[$i]['id'],
							"IMAGE2"=>$path,
							"NAME"=>ucfirst($cates[$i]['name']),
							"TITLE"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>".ucfirst($news[$i]['title'])."</a>",
							"CREATED"=>$news[$i]['date'],
							"NEWS"=>wordwrap(substr(ucfirst(utf8_encode(html_entity_decode($news[$i]['body']))), 0, 60), 25, "<br>\n"),
							//"NEWS"=>wordwrap(substr(ucfirst($news[$i]['body']), 0, 60), 30, "<br>\n"),
							"LINK1"=>"<a href='".HOST."newsviews/index/".$news[$i]['id']."'>",
							"LINK"=>"<a href='".HOST."categoriesview/index/".$cates[$i]['id']."'>".ucfirst($cates[$i]['name'])."</a>"
					);
				$xtpl->assign('DATA',$menu_list);
				$xtpl->parse('main.row');
				$xtpl->parse('main.abc');
		}
		$ctgry = $cms->getCates1();
		for($i=0;$i<3;$i++){
		$menu_list = array(
		"CATNAME"=>"<a href='".HOST."categoriesview/index/".$ctgry[$i]['id']."'>".$ctgry[$i]['name']."</a>",
		"CATDESC"=>substr(ucfirst(utf8_encode(html_entity_decode($ctgry[$i]['description']))), 0, 60),
		"CATLINK"=>"<a href='".HOST."categoriesview/index/".$ctgry[$i]['id']."'>Click here</a>"
		);
		$xtpl->assign('DATA',$menu_list);
    	$xtpl->parse('main.yyy');
		}
		
		$modules = $cms->getUiModulesByPage($page_id);
		$xtpl->assign('TITLE',$title);
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, $body);
		$newbody =($body);
		$xtpl->assign('BODY_CONTENT',$newbody);
		
		if(count($news) != 0){
			$xtpl->assign('TITLE', $news['title']);
			$xtpl->parse('main.newsflash');
		} 
		$xtpl->assign('IMAGES', IMAGE.'users/');
		$xtpl->assign('HOST', HOST);
		$xtpl->parse('main');
		$xtpl->out('main');
		
	}
	
	public function notfound(){
		
		$xtpl = new Xtemplate("users".DS."notfound.xtpl");
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	public function news($pageno = 1){
		$cms = new cmsModel();
		$news = $cms->getNews(HOST.'/index/news/', $pageno);
		$pagelinks = $cms->getPagelinks();
		$xtpl = new Xtemplate("users".DS."full_news.xtpl");
		foreach($news as $d=>$matter){
			$data = array(
					"ID"=>$matter['id'],
					"TITLE"=>$matter['title'],
					'CREATED'=>$matter['date']
					);
			$xtpl->assign('DATA',$data);
			$xtpl->parse('main.row.columns');	
		}
		$xtpl->parse('main.row');
		$xtpl->assign('PAGINATION', $pagelinks);
		$xtpl->assign('HOST',HOST);
		$xtpl->parse('main');
		$xtpl->out('main');
		
	}
	
	protected function getLatestNews(){
		$cms = new cmsModel();
		$news = $cms->getLatestNews();
		$xtpl = new Xtemplate("users".DS."news.xtpl");
		
		foreach($news as $d=>$matter){
			$data = array(
					"ID"=>$matter['id'],
					"TITLE"=>$matter['title'],
					'CREATED'=>$matter['date']
					);
			$xtpl->assign('DATA',$data);
			$xtpl->parse('main.row.columns');	
		}	
		$xtpl->parse('main.row');
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	protected function press_release(){
		
		$xtpl = new Xtemplate("users".DS."press.xtpl");
		$xtpl->assign('TITLE',$title);
		$xtpl->assign('BODY_CONTENT',$body);
		$xtpl->parse('main');
		$xtpl->out('main');
		
	}
	
	public function signup(){
			$args = array(
			'name'=>array('filter'=>FILTER_SANITIZE_STRING,
	                    'flags' => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW),
			'unit'=>array('filter'=>FILTER_SANITIZE_INT,
	                    'flags' => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW),
			'phone'=>array('filter'=>FILTER_SANITIZE_STRING,
	                    'flags' => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW),
			'street'=>	array('filter'=>FILTER_SANITIZE_STRING,
	                    'flags' => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW),
			'city'=>array('filter'=>FILTER_SANITIZE_STRING,
	                    'flags' => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW),
			'state'=>array('filter'=>FILTER_SANITIZE_STRING,
	                    'flags' => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW),
			'zip'=>array('filter'=>FILTER_SANITIZE_STRING,
	                    'flags' => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW)
				);
									
		$form_variables = filter_input_array(INPUT_POST, $args);
		if(empty($form_variables['name'])||empty($form_variables['phone'])){
			$error = true;
		}

			$cms = new cmsModel();
			$fields = array(
						'name',
						'units',
						'telephone',
						'street',
						'city',
						'state',
						'zip'
			);
			$values = array(
						$form_variables['name'],
						$form_variables['unit'],
						$form_variables['phone'],
						$form_variables['street'],
						$form_variables['city'],
						$form_variables['state'],
						$form_variables['zip']
						);
			$id = $cms->saveSignUp($fields,$values);
			if($id !=0){
			header("Location: ".HOST);
				exit;
			}			
		$xtpl = new Xtemplate("users".DS."signup.xtpl");
		$xtpl->assign('TITLE',$title);
		$xtpl->assign('BODY_CONTENT',$body);
		$xtpl->parse('main');
		$xtpl->out('main');
		
	}
	
	protected function search($search ='' , $pageno =1){
		$pageno = intval($pageno);
		$this->head();
		$xtpl = new Xtemplate("users".DS."search.xtpl");
		if(filter_has_var(INPUT_GET, 'search') || !empty($search)){
			$arg = array( 'search'=>array('filter'=>FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW));
			$form_variable = filter_input_array(INPUT_GET, $arg);
			$search = !empty($search)?$search: trim($form_variable['search']);
			if(!empty($search)){
			$cms = new cmsModel();
				$search_res = $cms->search($search, HOST.'index/search/'.$search, $pageno);
		if(count($search_res)!=0){
					$links = $cms->getPagelinks();
					foreach($search_res as $d=>$matter){
						$matter['body'] = preg_replace("#<img[^>]+>#si", '',$matter['body']);
						$matter['body'] = preg_replace("#$search#si", "<b>$search</b>",$matter['body']);
						$data = array(
								"PAGENAME"=>$matter['pagename'],
								"TITLE"=>$matter['title'],
								"BODY"=>strip_tags(stripslashes(substr($matter['body'],0,300)))
							);
						$xtpl->assign('DATA', $data);
						$xtpl->parse('main.row.columns');	
					}
					$xtpl->parse('main.row');
					$xtpl->assign('PAGINATION', $links);
					$xtpl->assign('HOST',HOST);
				}else{
					$xtpl->assign('NORESULTS', 'Sorry No Results found');
				}
					
			}else{
				$xtpl->assign('NORESULTS', 'Sorry No Results found');
			}
			
		}
		$xtpl->parse('main');
		$xtpl->out('main');
		$this->foot();
	}
	
	
	protected function getModules($mid){
		switch($mid){
			case 'news':
				$cms = new cmsModel();
				$news = $cms->getLatestNews();
				$xtpl = new Xtemplate("users".DS."news.xtpl");
				foreach($news as $d=>$matter){
					$data = array(
						"ID"=>$matter['id'],
						"TITLE"=>$matter['title'],
						"CREATED"=>$matter['date']
					);
				$xtpl->assign('DATA',$data);
				$xtpl->parse('main.row.columns');	
			}	
			$xtpl->parse('main.row');
			$xtpl->parse('main');
			$xtpl->out('main');
			$xtpl->clear_autoreset();
			
				break;
			case 'news-flash':
				$xtpl = new Xtemplate("users".DS."news-flash.xtpl");
				$xtpl->parse('main');
				$xtpl->out('main');
				$xtpl->clear_autoreset();
				break;	
			case 'signup':
				$xtpl = new Xtemplate("users".DS."signup.xtpl");
				$xtpl->assign('TITLE',$title);
				$xtpl->assign('BODY_CONTENT',$body);
				$xtpl->parse('main');
				$xtpl->out('main');
				$xtpl->clear_autoreset();
				break;	
		}
	}
	
	protected function newsFlash($content =''){
		
		
	}
	
	public function sitemap(){
		$this->head();
		$cms = new cmsModel();
		$app = $cms->getSiteMap();
		$xtpl = new Xtemplate("users".DS."sitemap.xtpl");
		if(count($app) !=0){
			foreach($app as $key=>$values){
			$childlinks =$cms->getChildLinks($values['id']);
				$xtpl->assign('ID',$values['id']);
				if(count($childlinks)!=0){
					$str = "";
					$str = "<div style='padding-left:50px;'><ul style='list-style-type:disc'>";

					foreach($childlinks as $child=>$children){
						$str .= "<li><a href='".HOST."index/{$children['link']}' style='text-decoration:none;color:#58206D'>".$children['label']."</a></li>"; 
					}
					$str .= "</ul></div><br />";
			$xtpl->assign('STR',$str);
					$str = '';
					$xtpl->parse('main.app.subapp');
				}
				
				$xtpl->assign('NAME',$values['label']);
				$xtpl->assign('LINK',$values['link']);
				$xtpl->parse('main.app');
			}
		}
		$xtpl->parse('main');
		$xtpl->out('main');
		$this->foot();
				
	}
}
?>