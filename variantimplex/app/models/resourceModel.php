<?php
class resourceModel extends PDB{
  
  public function __construct(){
  	 parent::__construct();
  } 
  
 
 public function getUserList($id=''){
    if($id!=''){
		$sql = "SELECT id, name FROM acl_groups WHERE id=:id";
		$params = array(':id'=>$id);
	}else{
		$sql = "SELECT * FROM acl_groups";
		$params = array();
	}
	$res = $this->selectArrayAssoc($sql, $params);
 	return $res;
 } 
 
 public function saveData($fields, $values){
 	$table = 'acl_resources';
	$res = $this->executeInsertSQL($fields, $values, $table);
 }
 
 public function getResourceList($id='', $name='', $level=''){
 		$filds['id'] = $id;
		$filds['name'] = $name;
		$filds['min_level'] = $level;
		$params = array();
		$vars = array();
		foreach($filds as $key=>$val){
			if(trim($val)!=''){
				$params[':'.$key] = $val;
			    if($key == 'min_level'){
					$vars[$key] = 'AC.'.$key." = '".$val."' ";
				}else{
					$vars[$key] = 'AC.'.$key." LIKE '%".$val."%' ";		
				}
			}
		}
 
       $exq =count($vars)?" WHERE ".implode('AND ', $vars):'';
       $sql = 'SELECT AC.*, ACG.name AS accessname FROM acl_resources AC LEFT JOIN acl_groups ACG ON(ACG.id=AC.min_level) '.$exq;
	   $res = $this->selectArrayAssoc($sql, $params);
 	   return $res;
 }
 
 
 public function deleteResource($id){
 	if($id!=''){
		$sql = "DELETE FROM acl_resources WHERE id=:id";
		$params = array(':id'=>$id);
		$this->executeDelete($sql, $params);
	}
 }
 
 public function updateData($name='', $min_level='', $id){
     if($id!=''){
	 	$sql = "UPDATE acl_resources SET name=:name, min_level=:min_level WHERE id=:id";
		$params	 = array(':name'=>$name, ':min_level'=>$min_val, ':id'=>$id);
		print_r($params);
		//$res = $this->executeUpdate($sql, $params);
	 }
 }
 
}
?>