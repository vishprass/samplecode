<?php
include_once('Paginated.php');
class productModel extends PDB {
   
    private $pagelinks;
	
	function __construct(){
		parent::__construct();
    }
	public function isProductNameExists($username, $id=''){
		if($id!=''){
			$sql = "SELECT id FROM products WHERE  name=:name AND id!=:id";
			$params = array(':name'=>$name, ':id'=>$id);
		}else{
			$sql = "SELECT id FROM products WHERE  name=:name";
			$params = array(':name'=>$name); 
		}
		$res = $this->selectArrayAssoc($sql, $params);
		return intval($res[0]['id'])?true:false;
	}
	public function isCodeExists($code, $id=''){
		if($id!=''){
			$sql = "SELECT id FROM products WHERE  code=:code AND id!=:id";
			$params = array(':code'=>$code, ':id'=>$id);
		} else {
			$sql = "SELECT id FROM products WHERE  code=:code";
			$params = array(':code'=>$code);
		}
		$res = $this->selectArrayAssoc($sql, $params);
		return intval($res[0]['id'])?true:false;
	}
	public function saveProductData($values, $fields){
		$table = "products";
		$res = $this->executeInsertSQL($fields, $values, $table);
		return $res;
	}
	public function getProductList($id='', $name='', $description='', $price='', $pagelink='', $pageno=1,$append=''){
		//print_r($this->db);
		$filds['id'] = $id;
		$filds['name'] = $name;
		$filds['description'] = $description;
		$filds['price'] = $price;
		//$filds['accesslevel'] = trim($level);
		$params = array();
		$vars = array();
		foreach($filds as $key=>$val){
			if(trim($val)!='') {
				$params[':'.$key] = $val;
			    if($key == 'id') {
					$vars[$key] = "products.category RLIKE '(^|:)".$val."(:|$)' ";
				} else {
					$vars[$key] = 'products.'.$key." LIKE '%".$val."%' ";
				}
			}
		}
		//if($id!=''){
		$exq = count($vars)?" WHERE ".implode(' AND ', $vars):'' ;//}
		$sql = 'SELECT products.id , products.name , products.description , products.longdescription , products.image as img , products.price , products.category , products.code , products.status , products.created FROM products '.$exq;
		$result = $this->selectArrayAssoc($sql, $params);
		$pgn = new Paginated($this->db, $sql, 10, $links_per_page = 5, $append = "", count($result), $pageno, $pagelink);
		$newsql = $pgn->paginate();
		$this->pagelinks=$pgn->renderFullNav();
		//print_r($params);
		return $this->selectArrayAssoc($newsql, $params);
	}
	
	public function getProductList1($id=''){
		$params=array();
		$sql = 'SELECT * FROM products where id='.$id;
		return $this->selectArrayAssoc($sql, $params);
	}
   public function updateProductData($sql, $params){
		$res = $this->executeUpdate($sql, $params);
		return $res;
	}
	public function deleteRecord($id){
		$sql_product = "SELECT name from products where id=:id";
		$params = array(':id'=>$id);
		$res = array_shift($this->selectArrayAssoc($sql_product, $params));
		/*if($res['username']=='admin'){
			return $error['admin'] = "admin user cannot be deleted";
		}*/
		$sql = "DELETE FROM products WHERE id=:id AND status != 2";
		$param = array(':id'=>$id);
		$this->executeDelete($sql, $param);
	}
	

	
	public function getPagelinks(){
		return $this->pagelinks;
	}
	
	public function chageStatus($id){
		$sql = "SELECT status FROM products WHERE id=:id ";
		$param = array(':id'=>$id);
		$res = $this->selectArrayAssoc($sql, $param);
		$ustat = $res[0]['status'];
		$updatesql = "UPDATE products SET status='".(($ustat ==1)?2:1)."' WHERE id=:id";	
		$param = array(':id'=>$id);
		$res = $this->executeUpdate($updatesql, $param);		
	}
	
	public function getProductData($uid){
		$sql = "SELECT products.id , products.name , products.description , products.longdescription , products.image , products.price , products.category , products.code , products.status , products.created , categories.id , categories.name as catname FROM products LEFT JOIN categories ON products.category=categories.id WHERE products.id=:id ";
		$params = array(':id'=>$uid);
		$res = array_shift($this->selectArrayAssoc($sql, $params));
		return $res;
		
	}
	
	public function getProductDetail($uid){
		$sql = "SELECT products.id , products.name , products.description , products.longdescription , products.image , products.price , products.category , products.code , products.status , products.created , categories.id , categories.name as catname FROM products LEFT JOIN categories ON products.category=categories.id WHERE products.id=:id ";
		$params = array(':id'=>$uid);
		$res = array_shift($this->selectArrayAssoc($sql, $params));
		return $res;
	}
	public function getCategoryMenus($sel2){
		$sql = "SELECT id, name,parent FROM categories WHERE status!=0  ";
		$params = array();
		$res = $this->selectArrayAssoc($sql, $params);
		return $this->createDropdown($res, $sel2);
	}
  
  public function createDropdown($arr=array(), $sel2=array()) { 
 	$max = count($arr);
	$i=0;
	//print_r($arr);
	//print_r($sel2);
	while($i<$max){
		$selected = '';
		//echo intval($arr[$i]['id'])."<br>";
		//((in_array($row['id'], $cats))?' selected':'');
		if(in_array($arr[$i]['id'], $sel2)) {
			//echo "welcome";
			$selected = "selected='selected'";
		}
		//$selected = "selected='selected'";
		//$selected = "selected='selected'";
		//if (in_array("Irix", $os))
		//if(intval($arr[$i]['id']) == $sel){
			 
		//}
		/*************************************New Code****************************/
		/*$sql = "SELECT id, name FROM categories WHERE status!='0' AND parent='0";
								while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
									$dname = $row['name']?$row['name']:$row['name'];
									?><option style="background:#f0f0f0;" value="<?= $row['id']; ?>"<?= ((in_array($row['id'], $cats))?' selected':''); ?>><?= $dname; ?></option><? $res = mysql_query("SELECT id, name FROM categories WHERE flag!='0' AND parent='".$row['id']."' ORDER BY name");						while($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
										$dname = $row['name']?$row['name']:$row['name'];
										?><option value="<?= $row['id']; ?>"<?= ((in_array($row['id'], $cats))?' selected':''); ?>>&mdash; <?= $dname; ?></option><? $resn = mysql_query("SELECT id, name FROM categories WHERE flag!='0' AND parent='".$row['id']."' ORDER BY name");						while($row = mysql_fetch_array($resn, MYSQL_ASSOC)) {
										$dname = $row['name']?$row['name']:$row['name'];
										?><option value="<?= $row['id']; ?>"<?= ((in_array($row['id'], $cats))?' selected':''); ?>>&mdash;&mdash;  <?= $dname; ?></option><? } }
								}*/
		/*******************End of new code*********************************/						
		if($arr[$i]['parent'] == 0) {
			//echo $arr[$i]['id']."<br>";
			$select .="<option value='".$arr[$i]['id']."' $selected>".$arr[$i]['name']."</option>";
			$sql = "SELECT id, name FROM categories WHERE parent=".$arr[$i]['id']." AND status!=0";
			$params = array();
			$res = $this->selectArrayAssoc($sql, $params);
			$max1=count($res);
			$j=0;
			while($j<$max1) {
				if(in_array($res[$j]['id'], $sel2)) {
					$selected = "selected='selected'";
				}
				if(in_array($res[$j]['id'], $sel2))
					$select .="<option value='".$res[$j]['id']."' $selected>&nbsp;&nbsp;-".$res[$j]['name']."</option>";
				else
					$select .="<option value='".$res[$j]['id']."'>&nbsp;&nbsp;-".$res[$j]['name']."</option>";	
				$j++;
			}
		}
		$i++;
	}
	return $select;
 }
	//**********************************************************
}
?>