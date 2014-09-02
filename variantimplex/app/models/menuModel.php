<?php
class menuModel extends PDB{
  public $file;
  public $fhnd; 

  public function __construct(){
		 parent::__construct();
  } 
  
  public function saveMenues($label='', $link='', $publish=0, $id='', $parent, $linktype=0){
	$insertid = $id;
	if($id){
			$sql = "UPDATE menus SET label=:label, parent=$parent, link=:link, publish=:publish, linktype=:linktype WHERE id=:id";
			$params = array(':label'=>$label, ':link'=>$link, ':publish'=>$publish, ':id'=>$id, ':linktype'=>$linktype);
			$this->executeUpdate($sql, $params);
			
	}else{
			$linktype = intval($linktype)?intval($linktype):'0';
			$fields = array('label', 'link', 'publish', 'menuorder', 'parent', 'linktype');
			$maxm  = intval($this->getMaxMenuorder())+1;
			$values = array($label, $link, $publish, $maxm, $parent, $linktype);
			$insertid = $this->executeInsertSQL($fields, $values, 'menus');
	}	
	return $insertid;
  }
  
  public function getres($menulabel,$id=''){
  $sql="SELECT id FROM menus WHERE label='$menulabel' AND id!='$id' LIMIT 1";
  $params=array();
  return $this->selectArrayAssoc($sql, $params);
  }
  
   public function getres1($menulabel,$id=''){
  $sql="SELECT id FROM menus WHERE link='$menulabel' AND id!='$id' LIMIT 1";
  $params=array();
  return $this->selectArrayAssoc($sql, $params);
  }
  
 public function getPublishMenues($publish=1, $menutype=1, $parent=0) {
  	$sql = "SELECT * FROM menus WHERE  publish=:publish AND parent=:parent ORDER BY menuorder ASC";
	$params = array( ':publish'=>$publish, ':parent'=>$parent);
	$res = $this->selectArrayAssoc($sql, $params);
	/*$menu = array();
	for($ar=0; $ar<count($res); $ar++){
		$menu[$ar]['label'] = $res[$ar]['label'];
		$menu[$ar]['id'] = $res[$ar]['id'];
		$menu[$ar]['link'] = $res[$ar]['link'];
		$menu[$ar]['linktype'] = $res[$ar]['linktype'];
	}
	$res =  $this->createMenu($menu); */
	return $res;
  }
  
  public function getMenues($id='', $name=''){
  	$fields['id'] = $id;
	$fields['label'] = $name; 
	$params = array();
	$vars = array();
  	foreach($fields as $key=>$val){
			if(trim($val)!=''){
				$params[':'.$key] = $val;
			   	if($key=='id'){
					$vars[$key] = $key." = '".$val."' ";
				} else {
					$vars[$key] = $key." LIKE '%".$val."%' ";
				}
			}
		}
	$exq = count($vars)?" WHERE ".implode('AND ', $vars):'';
	$sql = "SELECT * FROM menus ".$exq." ORDER BY menuorder ASC";
	$res = $this->selectArrayAssoc($sql, $params);
	return $res;
  }
  
  public function createMenu($arr){
		$str = '';
		$max = count($arr);
		for($i=0;$i<$max;$i++){
			if($arr[$i]['link']!=''){
				$tmplink = $arr[$i]['link'];
			}
			
			
			if($arr[$i]['id']!=''){
				$res = $this->hasChildMenu($arr[$i]['id']);
				if(count($res[0])>1){
					$sub = true;
				}
			}
			if($arr[$i]['linktype']==1) {
				$str .= '<li>&nbsp;&nbsp;<a href="'.$tmplink.'">'.$arr[$i]['label']."</a>";
			} else {
				if($sub){
					$str .= '<li>&nbsp;&nbsp;<a class="sub" href="'.HOST.'index/'.$tmplink.'">'.$arr[$i]['label']."</a>";
				} else {
					$str .= '<li>&nbsp;&nbsp;<a href="'.HOST.'index/'.$tmplink.'">'.$arr[$i]['label']."</a>";
				}
			}
			if($sub){
					$chmenu = $this->preparesubCMSMenu($res);
					//$str .=$chmenu;
					$sub = false;
			}
			$str .="</li>";
		}
		return $str;
  }

  public function deleteRecord($id){
  	$sql = "DELETE FROM menus WHERE id=:id";
	$params = array(':id'=>$id);
	$res = $this->executeDelete($sql, $params);	
	return $res;
  }
  
  public function getMenuType($id=''){
  	$sql = "SELECT menutype FROM menus WHERE id=:id";
	$params = array(':id'=>$id);
	$res = $this->selectArrayAssoc($sql, $params);	
	return $res[0]['menutype'];
  }
  
  public function rearangeMenuOrder($dir, $mid){
	// get menu group id;
	$menuorder = $this->getMenuGroupids($mid);
	$cmord = $menuorder[$mid];
	$nmord =intval($cmord) - intval($dir=='up'?1:-1);
	if(intval($nmord)>0){
		$tmpkey = array_search($nmord, $menuorder);
		$menuorder[$tmpkey] = $cmord;
		$menuorder[$mid] =  $nmord;
	}
	foreach($menuorder as $key=>$val){
	   		$sql = "UPDATE menus SET menuorder = :menuorder WHERE id=:id";
			$params = array(':menuorder'=>$val, ':id'=>$key);
			$this->executeUpdate($sql, $params);
	}
	/*$tmpar = $this->getCurrentStatus($menutype);
		for($i=0;$i<count($tmpar);$i++){
			array_push($menuids, $tmpar[$i]['id']);
			array_push($menuorders, $tmpar[$i]['menuorder']);
		}
	$farray = array_combine($menuids, $menuorders);
	
	$cur_men_ord = $farray[$mid];
	$dir = ($dir=='up'?'-1':'1');
	$neworder = intval($cur_men_ord)+$dir;
	if(!($neworder<1)){
		$tmpkey = '';
		while ($order_value = current($farray)) {
    		if ($order_value == $neworder) {
        		$tmpkey =  key($farray);
    		}
    		next($farray);
		}
	   if($tmpkey!=''){
	   	 $farray[$tmpkey] = intval($farray[$tmpkey]) - $dir;
	   }
	   $farray[$mid] = $neworder;
	   $keys = array_keys($farray);
	   foreach($farray as $key=>$val){
	   		$sql = "UPDATE menus SET menuorder = :menuorder WHERE id=:id";
			$params = array(':menuorder'=>$val, ':id'=>$key);
			$this->executeUpdate($sql, $params);
	   }
	}*/
  }
 	
  public function menuHandler(){
 	$sql = "SELECT * from menu_types";
	$result = mysql_query("SELECT * FROM menus ".$exq);
  }
  
  public function getCurrentStatus($menutype){
  	$sql = "SELECT id, menuorder FROM menus WHERE menutype=:menutype ORDER BY menuorder ASC";
	$params = array(':menutype'=>$menutype);
	$res = $this->selectArrayAssoc($sql, $params);
	return $res;		
  }
  
  public function getMaxMenuorder(){
  	$sql = "SELECT MAX(menuorder) AS mam FROM menus";
	$params = array();
	$res = $this->selectArrayAssoc($sql, $params);
	return $res[0]['mam'];
  }
  
  public function getParentMenus($sel){
  	$sql = "SELECT id, label FROM menus WHERE parent=0";
	$params = array();
	$res = $this->selectArrayAssoc($sql, $params);
	return $this->createDropdown($res, $sel);
  }
 
	public function createDropdown($arr=array(), $sel=''){	
	$max = count($arr);
	for($i=0;$i<$max;$i++){ 
		$selected='';
		if(intval($arr[$i]['id']) == $sel){
		   $selected = "selected='selected'";
		}
		$select .="<option value='".$arr[$i]['id']."' $selected>".$arr[$i]['label']."</option>";
	}
	return $select;
 } 
 
 public function hasChildMenu($id=''){
 	$sql = "SELECT id, label, link  FROM menus WHERE parent=:parent AND publish=:publish";
	$params = array(':parent'=>$id, ':publish'=>1);
	return $res = $this->selectArrayAssoc($sql, $params);
 }
 
 
  public function prepareCMSMenu($arr){
	$link = '#';
	$max = count($arr);
	//$sel = "<ul>";
	for($c=0;$c<$max;$c++){
		if(preg_match("#http\/\/\:.+#si",$arr[$c]['link'])){
			$tmplink = $arr[$c]['link'];
		}else{
			$tmplink =  HOST."index/".$arr[$c]['link'];
		}
		$sel .= "<li><a href='".$tmplink."'>".$arr[$c]['label']."</a></li>";	
	}
	//$sel .= "</ul>";
	return $sel;
 }
 
 public function preparesubCMSMenu($arr){
	/*$link = '#';
	$max = count($arr);
	$sel = "<ul>";
	for($c=0;$c<$max;$c++){
		if(preg_match("#http\/\/\:.+#si",$arr[$c]['link'])){
			$tmplink = $arr[$c]['link'];
		}else{
			$tmplink =  HOST."index/".$arr[$c]['link'];
		}
		$sel .= "<li><a href='".$tmplink."'>".$arr[$c]['label']."</a></li>";	
	}
	$sel .= "</ul>";
	return $sel;*/
	$link = '#';
	$max = count($arr);
	$sel = "<div>";
	for($c=0;$c<$max;$c++) {
		if(preg_match("#http\/\/\:.+#si",$arr[$c]['link'])){
			$tmplink = $arr[$c]['link'];
		} else {
			$tmplink =  HOST."index/".$arr[$c]['link'];
		}
		$sel .= "<a href='".$tmplink."'>".$arr[$c]['label']."</a>";
	}
	$sel .= "</div>";
	return $sel;
 }
 public function getMenuesByGroup($name='') {
 	/**
	 * Select all Parent menu 
	 */
	 
	 $fmanuarray = array();
	 if($name!=''){
	 	$sql = "SELECT * FROM menus WHERE label LIKE :name ORDER BY menuorder ASC";
	    $params = array(':name'=>'%'.$name.'%');
	    $res = $this->selectArrayAssoc($sql, $params);
	 }else{
	 	$sql = "SELECT * FROM menus WHERE parent=0 ORDER BY menuorder ASC";
	    $params = array();
	    $res = $this->selectArrayAssoc($sql, $params);
	 }
	 
	 $max = count($res);
	 $tl_mnu = -1;
	 for($i=0;$i<$max;$i++){
	 	 $tl_mnu++;
		 $fmanuarray[$tl_mnu] = $res[$i];
		 /**
	 	  * Select all child menu ids; 
	      */
		  
		  $ids = $this->getChildMenuIds($res[$i]['id']);
		  /**
	 	  * get Details from all ids; 
	      */
		  
		  $id_cnt = count($ids);
		  for($jk=0; $jk<$id_cnt; $jk++){
		  	$tl_mnu++;
			$sql = "SELECT * FROM menus WHERE id=:id";
	 	  	$params = array(':id'=>$ids[$jk]);
	 	  	$reslt = $this->selectArrayAssoc($sql, $params);
			$reslt[0]['label'] ='&nbsp;__'. $reslt[0]['label'];
		  	$fmanuarray[$tl_mnu] = $reslt[0];
		  }
	 }
	 return $fmanuarray;
 }
 
 public function getChildMenuIds($id=''){
	$ids = array();
	if($id!=''){
		$sql = "SELECT id FROM menus WHERE parent=:parent ORDER BY menuorder ASC";
		$params = array(':parent'=>$id);
		$res = $this->selectArrayAssoc($sql, $params);
		$max = count($res);
		for($k=0; $k<$max;$k++){
			array_push($ids, $res[$k]['id']);
		}	
	}
	return $ids;
 }
 
 
 public function isLinkExists($pid=''){
 	if($pid!=''){
		$sql = "SELECT id FROM menus WHERE link=:link";
		$params = array(':link'=>$pid);
	    $res =  $this->selectArrayAssoc($sql, $params);
	}
 	return intval($res[0]['id']);
 }
 
 public function getMenuGroupids($mid=''){
 	$ids = array();
	$menuorder = array();
	if($mid!=''){
		$sql = "SELECT parent FROM menus WHERE id=:id";
		$params = array(':id'=>$mid);
		$res =  $this->selectArrayAssoc($sql, $params);
		$sql = "SELECT id, menuorder FROM menus WHERE parent=:parent";
		$params = array(':parent'=>$res[0]['parent']);
		$res =  $this->selectArrayAssoc($sql, $params);
		$max = count($res);
		for($r=0;$r<$max;$r++){
			array_push($ids, $res[$r]['id']);
			array_push($menuorder, $res[$r]['menuorder']);
		}
	}
 	return array_combine($ids, $menuorder);
 }
 public function getMaxParentMenus(){
  $sql = "SELECT count(`id`) as num from menus where parent=0 and publish=1";
  $params = array();
  $res = $this->selectArrayAssoc($sql, $params);
  return array_shift($res);
 }
 
 
 public function isLabelExists($label, $id=''){
		if($id!=''){
			$sql = "SELECT id FROM menus WHERE  label=:label AND id!=:id";
			$params = array(':label'=>$label, ':id'=>$id);
		}else{
			$sql = "SELECT id FROM menus WHERE  label=:label";
			$params = array(':label'=>$label); 
		}
		$res = $this->selectArrayAssoc($sql, $params);
		return intval($res[0]['id'])?true:false;
	}
 
}

?>