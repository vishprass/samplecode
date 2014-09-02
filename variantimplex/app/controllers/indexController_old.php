<?php
include_once('menuModel.php');
include_once('cmsModel.php');
include_once('tstmnyModel.php');
include_once('categoryModel.php');
class indexController extends baseController {
	public function index(){
		$this->head();
		$this->body();
		$this->foot();
	}
	public function head($title = '', $meta_keys = '', $meta_desc = ''){
		$xtpl = new Xtemplate("users".DS."header.xtpl");
		$title = empty($title)? 'First Media Partners': $title;
		$meta_desc = empty($meta_desc)? 'First Media Partners': $meta_desc;
		$meta_keys = empty($meta_keys)? 'First Media Partners': $meta_keys;
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
	
	public function body( $page_id='' ){
		$cms = new cmsModel();
		$modules = $cms->getUiModulesByPage($page_id);
		$news = array_shift($cms->getLatestNews());
		$content = array_shift($cms->getHomeContent());
		$body = stripslashes($content['body']);
		$replace = "src=".IMAGE;
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, $body);
		
	/*	if(preg_match_all("#<img[^>]+>#si", $body ,$a)){
			$p = array_shift($a);
			foreach($p as $c){
				if(preg_match("#src=\"\.\.\/\.\.\/\.\.\/app\/view\/themes\/media\/images\/(.*)\"#", $c,$k)){
					if(preg_match("#(.*)\.(jpeg|jpg|png|gif)#", $k[1], $p)){
						$img[] = $replace.$p[0];
					//	echo $img."<br />";
					}
				}
			}
			
			$body = preg_replace("#src=\"\.\.\/\.\.\/\.\.\/app\/view\/themes\/media\/images(.*)#U", $img, $body);
			//echo '\\1';
		}*/		
		//echo $body;
		$xtpl = new Xtemplate("users".DS."body.xtpl");
		$xtpl->assign('BODY', $body);
		//$xtpl->assign('BODY', $body);
		if(count($news) != 0){
			$xtpl->assign('TITLE', $news['title']);
			$xtpl->assign('NEWS', str_replace("../../../app/view/themes/media/images/", IMAGE, stripslashes($news['body'])));
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
		
			$this->head($page_title, $meta, $description);
			
			switch($pagename){
				case 'home':
					$this->body( $page_id);
					break;
				case '404':
					
					$this->notfound();	
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
		//echo "here";
		$cms = new cmsModel();
		$modules = $cms->getUiModulesByPage($page_id);
		$xtpl = new Xtemplate("users".DS."body2.xtpl");
		$xtpl->assign('TITLE',$title);
		$body = str_replace("../../../app/view/themes/media/images/", IMAGE, stripslashes($body));
		$xtpl->assign('BODY_CONTENT',$body);
		//$xtpl->assign('NEWS',$this->getLatestNews());
		/*if(count($modules) !=0 ){
			for($i=0; $i< count($modules); $i++){
				$xtpl->assign(strtoupper($modules[$i]['name']), $this->getModules($modules[$i]['name']));
				$xtpl->parse('main.'.strtolower($modules[$i]['name']));
			}
		}*/
		$xtpl->assign('HOST', HOST);
		$xtpl->assign('IMAGES', IMAGE.'users/');
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
			///	$xtpl->assign("ADD_SUCCESS","Client added successfully");
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
		//echo $pageno; 
		$this->head();
		//print_r($_GET);
		$xtpl = new Xtemplate("users".DS."search.xtpl");
		if(filter_has_var(INPUT_GET, 'search') || !empty($search)){
			
			$arg = array( 'search'=>array('filter'=>FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW));
			$form_variable = filter_input_array(INPUT_GET, $arg);
			$search = !empty($search)?$search: trim($form_variable['search']);
			if(!empty($search)){
				
				$cms = new cmsModel();
				$search_res = $cms->search($search, HOST.'index/search/'.$search, $pageno );
			//	print_r($search_res);
				if(count($search_res)!=0){
					$links = $cms->getPagelinks();
					foreach($search_res as $d=>$matter){
						$matter['body'] = preg_replace("#<img[^>]+>#si", '',$matter['body']);
						$matter['body'] = preg_replace("#$search#si", "<b>$search</b>",$matter['body']);
						$data = array(
								"PAGENAME"=>$matter['pagename'],
								"TITLE"=>$matter['title'],
								"BODY"=>stripslashes(substr($matter['body'],0,300))
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
				return $this->getLatestNews();
				break;
			case 'news-flash':
				return $this->newsFlash();
				break;	
			case 'signup':
				return $this->signup();
				break;	
		}
	}
	
	protected function newsFlash($content =''){
		$xtpl = new Xtemplate("users".DS."news-flash.xtpl");
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	public function sitemap(){
		$this->head();
		$cms = new cmsModel();
		$app = $cms->getSiteMap();
		//print_r($app);
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
				//	echo $str;
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
		//$this->body();
		$this->foot();
				
	}
}
?>