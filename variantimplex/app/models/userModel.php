<?php
include_once('Paginated.php');
class userModel extends PDB{
   
    private $pagelinks;
	
	function __construct(){
		parent::__construct();
    }
	
	public function validateLoginDetails($username='', $password='', $status='1'){
		$sql = "SELECT id, username, accesslevel FROM users WHERE username=:username AND password=:password AND status=:status AND accesslevel=2"; 
		$params = array(':username'=>$username, ':password'=>md5($password), ':status'=>$status);
		$res = $this->selectArrayAssoc($sql, $params);
		return $res;
	}
	
	public function isUserNameExists($username, $id=''){
		if($id!=''){
			$sql = "SELECT id FROM users WHERE  username=:username AND id!=:id";
			$params = array(':username'=>$username, ':id'=>$id);
		}else{
			$sql = "SELECT id FROM users WHERE  username=:username";
			$params = array(':username'=>$username); 
		}
		$res = $this->selectArrayAssoc($sql, $params);
		return intval($res[0]['id'])?true:false;
	}
	
	public function isEmailExists($email, $id=''){
		if($id!=''){
			$sql = "SELECT id FROM users WHERE email=:email AND id!=:id";
			$params = array(':email'=>$email, ':id'=>$id);
		}else{
			$sql = "SELECT id FROM users WHERE email=:email";
			$params = array(':email'=>$email);
		}
	   $res = $this->selectArrayAssoc($sql, $params);
	   return intval($res[0]['id'])?true:false;
	}
	
	public function saveUserData($values, $fields){
		$table = "users";
		$res = $this->executeInsertSQL($fields, $values, $table);
		return $res;
	}
	
	public function getUserList($id='', $username='', $email='', $level='', $pagelink='', $pageno=1){
		//print_r($this->db);
		$filds['id'] = $id;
		$filds['username'] = $username;
		$filds['email'] = $email;
		$filds['accesslevel'] = trim($level);
		$params = array();
		$vars = array();
		foreach($filds as $key=>$val){
			if(trim($val)!=''){
				$params[':'.$key] = $val;
			    if($key == 'accesslevel'){
					$vars[$key] = $key." = '".$val."' ";
				}else{
					$vars[$key] = $key." LIKE '%".$val."%' ";		
				}
			}
		}
		$exq = count($vars)?" WHERE ".implode('AND ', $vars):'';
		$sql = 'SELECT * FROM users '.$exq;
		$result = $this->selectArrayAssoc($sql, $params);
		$pgn = new Paginated($this->db, $sql, 10, $links_per_page = 5, $append = "", count($result), $pageno, $pagelink);
		$newsql = $pgn->paginate();
		$this->pagelinks=$pgn->renderFullNav();
		return $this->selectArrayAssoc($newsql, $params);
	}
	
	public function updateUserData($sql, $params){
		$res = $this->executeUpdate($sql, $params);
		return $res;
	}
	
	public function deleteRecord($id){
		$sql = "DELETE FROM users WHERE id=:id";
		$param = array(':id'=>$id);
		$this->executeDelete($sql, $param);
	}
	
	public function checkOldPassword($oldpass='', $id=''){
		if(($oldpass!='') && ($id!='')){
			$sql = "SELECT id FROM users WHERE password=:oldpass AND id=:id";
			$params = array(':id'=>$id, ':oldpass'=>md5($oldpass));
			$res = $this->selectArrayAssoc($sql, $params);
			return (($res[0]['id']!='')?1:0);
		}
	}
	
	public function changeOldPassword($npassword='', $id=''){
		if(($npassword!='') && ($id!='')){
			$sql = "UPDATE users SET password=:pasword WHERE id=:id";
			$params = array(':id'=>$id, ':pasword'=>md5($npassword));
			$res =  $this->executeUpdate($sql, $params);
		}
	}
	
	public function getPagelinks(){
		return $this->pagelinks;
	}
	
	public function chageStatus($id){
		$sql = "SELECT status FROM users WHERE id=:id ";
		$param = array(':id'=>$id);
		$res = $this->selectArrayAssoc($sql, $param);
		$ustat = $res[0]['status'];
		
		$updatesql = "UPDATE users SET status='".(($ustat ==1)?2:1)."' WHERE id=:id";	
		$param = array(':id'=>$id);
		$res = $this->executeUpdate($updatesql, $param);		
	}
	
	
	
}

?>