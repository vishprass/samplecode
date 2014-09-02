<?php
class Session{
	protected $db;
	
	
	public function __construct($db = null){
		if(empty($this->db)){
			$this->db = $db;
		}
		session_set_save_handler(array(&$this, 'open'),
                                array(&$this, 'close'),
                                array(&$this, 'read'),
                                array(&$this, 'write'),
                                array(&$this, 'destroy'),
                                array(&$this, 'gc'));
        session_start();
		
	}
	
	public function open($save_path,$session_name){
		return true;	
	}
	
	public function close(){
		$this->gc(ini_get('session.gc_maxlifetime'));
		return false;
	}
	
	public function read($id){
		$sql = "SELECT data from sessions where session_id= :session_id";
		$params =array(':session_id'=>$id);
		$result = $this->db->selectArrayAssoc($sql,$params);
		if(!empty($result)){
			return $result['0']['data'];
		}else{
			return;
		}
	}
		
	public function write($id,$data){
		//print_r($data);
	//	echo $id;
		$sql = "SELECT data from sessions where session_id= :session_id";
		$params =array(':session_id'=>$id);
		$result = $this->db->selectArrayAssoc($sql,$params);
		//print_r($result);
		if(count($result['0']['data'])!=0){
			//echo "here";
			$sql = "UPDATE sessions set  data = :data where session_id = :session_id ";
			$params = array(':data'=>$data,':session_id'=>$id);
			echo "<pre>";
			print_r($params);
			$this->db->executeUpdate($sql,$params);
		}else{
			$fields = array('session_id','data','created');
			$values = array($id,$data,date('Y-m-d H:i:s'));
			$this->db->executeInsertSQL($fields,$values,'sessions');
		}
		return true;
	}
	
	public function destroy($id){
		$sql = "DELETE * from sessions where session_id = :session_id";
		$params = array(':session_id'=>$id);
		$this->db->executeQuery($sql,$params);
		return true;
		
	}
	
	public function gc($max_life){
		$now = date('Y-m-d H:i:s');
		$diff = strtotime("$now-$max_life seconds");
		$cmp_date = date('Y-m-d H:i:s',$diff);
		$sql = " DELETE FROM sessions where updated<:cmp_date ";
		$params = array(':cmp_date'=>$cmp_date);
		$this->db->executeQuery($sql,$params);
		return true;
	}
	
	public function __destruct(){
		session_write_close();
	} 
	
	public static function install($db = ''){
		//if(!empty($db)){self::$db = $db;}
		$sql = " CREATE TABLE `sessions` (
				`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`user_id` INT( 11 ) NOT NULL ,
				`data` LONGTEXT NOT NULL ,
				`created` DATETIME NOT NULL ,
				`updated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL ,
				`session_id` VARCHAR( 32 ) NOT NULL
				) ENGINE = MYISAM ";
		
		$db->executeQuery($sql);
		return true;
	}
	
}
?>