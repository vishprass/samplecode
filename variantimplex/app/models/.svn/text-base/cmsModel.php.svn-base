<?php
class cmsModel extends PDB{
  
  public $file;
  
  public $fhnd;
  
  private $pagelinks;
   
  public function __construct(){
  	 parent::__construct();
  } 
  
  public function savePages($pagename, $title,  $page_titles , $meta , $description , $body, $status='1',$id=''){
	if($id){
	    $sql = "UPDATE cms SET pagename=:pagename, title=:title, body=:body,  page_titles=:page_titles, meta=:meta, description=:description WHERE id=:id";
		$params = array(':pagename'=>strtolower($pagename), ':title'=>$title, ':body'=>$body, ':meta'=>$meta,  ':page_titles'=>$page_titles, ':description'=>$description, ':id'=>$id);
		$this->executeUpdate($sql, $params);
		return true;
	}else{
		$created = date("Y-m-d H:i:s", time());
		$fields = array('pagename', 'title', 'body', 'created', 'meta', 'description', 'status','page_titles');
		$values = array($pagename, $title, $body, $created, $meta, $description, $status, $page_titles);
		$insertid = $this->executeInsertSQL($fields, $values, 'cms');
		return $insertid;
	}
  }
  
  public function saveModules($page_id, $modules){
  	$fields = array('page_id','module_id');
  	$this->executeQuery("DELETE FROM page_modules where page_id='$page_id'");
  	/*foreach($modules as $mod=>$id){
  		$a[] = array($page_id, $id);
  	}*/
  	$sql = $this->buildMultiInsertSQL('page_modules',$fields, $a );
  	$this->executeQuery($sql);
  }
  
  public function getPageList($status=1, $id='', $title='', $pname='', $pagelink='', $pageno=1){
    
	$filds['status'] = $status!=''?$status:'1';
	$filds['id'] = $id;
	$filds['title'] = $title;
	$filds['pagename'] = $pname;
	$params = array();
	$vars = array();
  	foreach($filds as $key=>$val){
			if(trim($val)!=''){
				$params[':'.$key] = $val;
			   	if($key == 'status'){
					$vars[$key] = $key." = '".$val."' ";
				} else {
					$vars[$key] = $key." LIKE '%".$val."%' ";
				}				
			}
		}
	$exq =count($vars)?" WHERE ".implode('AND ', $vars):'';
	$sql = "SELECT * FROM cms ".$exq;
	$result = $this->selectArrayAssoc($sql, $params);
	$pgn = new Paginated($this->db, $sql, 10, $links_per_page = 5, $append = "", count($result), $pageno, $pagelink);
	$newsql = $pgn->paginate();
	$this->pagelinks=$pgn->renderFullNav();
	$res = $this->selectArrayAssoc($newsql, $params);
	return $res;
  }
  
   public function getPageContent($id=0, $status=1){
  	$sql = "SELECT * FROM cms WHERE status =:status AND id=:id";
	$params = array(':status'=>$status, ':id'=>$id);
	$res = $this->selectArrayAssoc($sql, $params);
	return $res;
	
  }
  
  function getPageSelectBox($name='', $sel=''){
 	 $set = $this->getPageList();
	 $cn = count($set);
	 $k='';
	 for($i=0;$i<$cn;$i++){
	 	$selected = '';
	 	if($set[$i]['pagename'] == $sel){
			$selected = "selected='selected'";
		}
		$k .="<OPTION VALUE='".$set[$i]['pagename']."' $selected>".$set[$i]['title']."</OPTION>";
	 }
 	 return $k;
 }
 
 /**
  * Below function will check for dynamic created pages in CMS table 
  */
  
 public function isExistsPagename($pagename='', $id=''){
 	if($id!=''){
		$sqls = "SELECT id FROM cms WHERE pagename=:pagename AND id !=:id";
		$params = array(':pagename'=>$pagename, ':id'=>$id);
		}else{
		$sqls = "SELECT id FROM cms WHERE pagename=:pagename ";
		$params = array(':pagename'=>$pagename);
	}
	
	$res = $this->selectArrayAssoc($sqls, $params);
	if($res[0]['id']!=''){
		return $res[0]['id'];
	}else{
		return "";
	}
 }
 
 public function deletePage($id){
 	$sqls = "UPDATE cms SET status=0 WHERE id=:id";
	$params = array(':id'=>$id);
	$res = $this->executeUpdate($sqls, $params);
	return $res;
 }
 
 public function getPageIdFromName($pagename=''){
 	if($pagename!=''){
		$sql = "SELECT id FROM cms WHERE LOWER(pagename)=:pagename AND status=:status";
		$params = array(':pagename'=>strtolower($pagename), ':status'=>'1');
		$res = $this->selectArrayAssoc($sql, $params);
		return $res[0]['id'];
	}
 
 } 
 
  public function getPagelinks(){
		return $this->pagelinks;
  }
  
   public function getHeaderDetails($id=''){
  	if($id!=''){
  		$sql = "SELECT title, meta, description FROM cms WHERE id=:id";
		$params = array(':id'=>$id);
		$res = $this->selectArrayAssoc($sql, $params);
		return $res[0];
  	}
  
  }
  
 
 public function getPartnersDetails($id=''){
	if($id!=''){
		$sql = "SELECT * FROM cms WHERE id=:id";
		$params = array(':id'=>$id);
		$res = $this->selectArrayAssoc($sql, $params);
		return $res;
	} else {
		$sql = "SELECT id, body FROM cms WHERE id=:id";
		$params = array(':id'=>10);
		$res = $this->selectArrayAssoc($sql, $params);
		return $res;				
	}
}

 public function getTeamDetails($id=''){
	if($id!=''){
		$sql = "SELECT * FROM cms WHERE id=:id";
		$params = array(':id'=>$id);
		$res = $this->selectArrayAssoc($sql, $params);
		return $res;
	} else {
		$sql = "SELECT id, body FROM cms WHERE id=:id";
		$params = array(':id'=>11);
		$res = $this->selectArrayAssoc($sql, $params);
		return $res;				
	}
}

 public function searKeyWord($keyword){	
 	$keyword = $keyword !=''?strip_tags($keyword):' ';
 	if($keyword){
		$samplear  = array();
		$sql = "SELECT id, body FROM cms WHERE title LIKE ':keyword' OR body LIKE :keyword AND status!='0'";
		$params = array(':keyword'=>'%'.$keyword.'%');
		$res = $this->selectArrayAssoc($sql, $params);
		$max = count($res);
		for($r=0;$r<$max;$r++){
			$samplear[$res[$r]['id']] = substr(stripslashes($res[$r]['body']),0,180);
		}
		return $samplear;
	}
  
  }  
  
  public function getPartnersList(){
		$sql = 'SELECT * FROM partners WHERE status=:status';
		$params = array(':status'=>'1');
		$result = $this->selectArrayAssoc($sql, $params);
		return $result;
 }
 
 public function getPageDetails($page = '',$pageurl = ''){
 	$sql = "SELECT * from cms where pagename = :pagename and status !=0";
 	$params = array(':pagename'=>$page );
 	$result = $this->selectArrayAssoc($sql, $params);
	return $result;
 }

 
 public function getLatestNews(){
 	$sql = "SELECT id, title, body, DATE_FORMAT(created,'%D %M, %Y') as date from news order by created desc limit 1";
 	$params = array();
 	$result = $this->selectArrayAssoc($sql, $params);
	return $result;
 }
 
 public function getUiModules($id=''){
 	if (empty($id)){
 		$sql = "SELECT id, name from uimodules";
 		$params = array();
 	}else{
 		$sql = "SELECT id, name, order from uimodules where id = :id";
 		$params = array(':id'=>$id);
 	}
 	$result = $this->selectArrayAssoc($sql, $params);
	return $result;
 	
 }
 
 public function getPageModules($page_id){
 	$sql = "SELECT  module_id from page_modules where page_id = :page_id";
 	$params = array(':page_id'=>$page_id);
 	$result = $this->selectArrayAssoc($sql, $params);
	return $result;
 }

 public function getNews($pagelink = '', $pageno=1){
 	$sql = "SELECT id,title, body, DATE_FORMAT(created,'%D %M, %Y') as date from news order by created desc";
 	$params = array();
 	$result = $this->selectArrayAssoc($sql, $params);
 	$pgn = new Paginated($this->db, $sql, 2, $links_per_page = 5, $append = "", count($result), $pageno, $pagelink);
 	$newsql = $pgn->paginate();
 	$this->pagelinks = $pgn->renderFullNav();
	$res = $this->selectArrayAssoc($newsql, $params);
	return $res;
 }
 
 public function getUiModulesByPage($page_id){
 	if(empty($page_id)) return;
 	$sql = "SELECT m.id, m.name, m.sequence from page_modules as pm, uimodules as m  where m.id = pm.module_id and pm.page_id=:page_id  order by sequence asc";
 	$params = array(':page_id'=>$page_id);
 	$res = $this->selectArrayAssoc($sql, $params);
 	return $res;
 }
 
 public function getHomeContent(){
 	$sql = "SELECT * from cms where landing_page=1 ";
 	$params = array();
 	$res = $this->selectArrayAssoc($sql, $params);
 	return $res;
 }
 
public function search($search , $pagelink, $pageno){
	$sql = "SELECT * FROM cms WHERE ( ( title LIKE :search ) OR ( body LIKE :search ) OR ( pagename LIKE :search ) ) ORDER BY pagename, title, body";
	$params = array(':search'=>"% $search%");
 	$result = $this->selectArrayAssoc($sql, $params);
 	$pgn = new Paginated($this->db, $sql, 5, $links_per_page = 5, $append = "", count($result), $pageno, $pagelink);
 	$newsql = $pgn->paginate();
 	$this->pagelinks = $pgn->renderFullNav();
	$res = $this->selectArrayAssoc($newsql, $params);
 	return $res;		
}

public function saveSignUp($fields, $values){
	$insertid = $this->executeInsertSQL($fields, $values, 'contactus');
	return $insertid;
}

public function getSiteMap(){
	$sql = "SELECT id, label, link FROM `menus` WHERE parent =0 AND publish =1 ORDER BY menuorder";
	$params = array();
 	$result = $this->selectArrayAssoc($sql, $params);
	return $result;
}

public function getChildLinks($parent){
	$sql = "SELECT id, label, link FROM `menus` WHERE parent =:parent AND publish =1 ORDER BY menuorder";
	$params = array(':parent'=>$parent);
 	$result = $this->selectArrayAssoc($sql, $params);
	return $result;
	
}

}
?>