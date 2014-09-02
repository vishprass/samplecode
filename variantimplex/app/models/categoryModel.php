<?
include_once('Paginated.php');
class categoryModel extends PDB{
   
    private $pagelinks;
	
	function __construct(){
		parent::__construct();
    }
	
	public function validateLoginDetails($username='', $password='', $status='1'){
		$sql = "SELECT id, username, accesslevel FROM users WHERE username=:username AND password=:password AND status=:status"; 
		$params = array(':username'=>$username, ':password'=>md5($password), ':status'=>$status);
		$res = $this->selectArrayAssoc($sql, $params);
		return $res;
	}
	

	
	
	
	
	public function getParentMenus($sel){
  	$sql = "SELECT id, name,parent FROM categories WHERE  status!=0  ";
	$params = array();
	$res = $this->selectArrayAssoc($sql, $params);
	return $this->createDropdown($res, $sel);
  }
  
  public function createDropdown($arr=array(), $sel='') {	
 
	$max = count($arr);
	$i=0;
	while($i<$max){
		$selected = '';
		if(intval($arr[$i]['id']) == $sel){
		   $selected = "selected='selected'";
		}
		if($arr[$i]['parent'] == 0){
		$select .="<option value='".$arr[$i]['id']."' $selected>".$arr[$i]['name']."</option>";
		$sql = "SELECT id, name FROM categories WHERE parent=".$arr[$i]['id']." AND status!=0";
	     $params = array();
	      $res = $this->selectArrayAssoc($sql, $params);
		  $max1=count($res);
		  $j=0;
		  while($j<$max1){
		  $select .="<option value='".$res[$j]['id']."' $selected>&nbsp;&nbsp;-".$res[$j]['name']."</option>";
		  $j++;
		  
		  }
		  
		}
		$i++;
	}
	return $select;
 } 
	
	public function saveCategoryData($values, $fields){
		$table = "categories";
		$res = $this->executeInsertSQL($fields, $values, $table);
		return $res;
	}
	
	public function getCategoriesList($id='',$id1='', $name='', $description='', $parent='', $pagelink='', $pageno=1,$append=''){
		$filds['name'] = $name;
		$filds['description'] = $description;
		
		$params = array();
		$vars = array();
		foreach($filds as $key=>$val){
			if(trim($val)!=''){
				$params[':'.$key] = $val;
			   {
					$vars[$key] = $key." LIKE '%".$val."%' ";		
				}
			}
		}
		if($_POST['name']=='' && $_POST['description']=='' )
			$exq =count($vars)?" AND ".implode('AND ', $vars):'';
		else
			$exq =count($vars)?" WHERE ".implode('AND ', $vars):'';
		if($id1){
	$sql = "SELECT * FROM categories WHERE parent=".$id1." ORDER BY id desc";
		$result = $this->selectArrayAssoc($sql, $params);}else{
		
		if($_POST['name']!='' || $_POST['description']!='' )
			$sql = 'SELECT * FROM categories '.$exq;
		else
			$sql = 'SELECT * FROM categories  where parent=0'.$exq." ORDER BY id desc";	
		
		$result = $this->selectArrayAssoc($sql, $params); }
		$pgn = new Paginated($this->db, $sql, 10, $links_per_page = 5, $append = "", count($result), $pageno, $pagelink);
		$newsql = $pgn->paginate();
		$this->pagelinks=$pgn->renderFullNav();
		return $this->selectArrayAssoc($newsql, $params);
	}
	
	public function updateCategoryData($sql, $params){
		$res = $this->executeUpdate($sql, $params);
		return $res;
	}
	
	public function deleteRecord($id){
		
		$sql = "DELETE FROM categories WHERE status!=2 AND  (id=:id OR parent=:id) ";
		$param = array(':id'=>$id);
		$this->executeDelete($sql, $param);
	}
	
	
	
	public function getPagelinks(){
		return $this->pagelinks;
	}
	
	
	public function getrecords($id=''){
	$params = array();
	$sql = "SELECT * FROM categories WHERE parent=".$id;
		$result = $this->selectArrayAssoc($sql, $params);
		return $result;
	
	}
	public function chageStatus($id){
		$sql = "SELECT status,parent FROM categories WHERE id=:id ";
		$param = array(':id'=>$id);
		$res = $this->selectArrayAssoc($sql, $param);
		
		$sql1 = "SELECT status FROM categories WHERE id=".$res[0]['parent'];
		$param1 = array(':id'=>$id);
		$res1 = $this->selectArrayAssoc($sql1, $param1);
		
		
		if($res[0]['status']==2 AND $res1[0]['status']==2){  }else{
		$ustat = $res[0]['status'];
	    $updatesql = "UPDATE categories SET status='".(($ustat ==1)?2:1)."' WHERE id=:id OR parent=:id";
			
		$param = array(':id'=>$id);
		$res = $this->executeUpdate($updatesql, $param);		
	}}
	
	public function getCategoryData($uid){
		$sql = "SELECT * from categories where id=:id";
		$params = array(':id'=>$uid);
		$res = array_shift($this->selectArrayAssoc($sql, $params));
		return $res;
		
	}
	
	
	
}

?>