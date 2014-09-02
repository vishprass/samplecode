<?php
class DB{
	
	protected $db;
	protected $encrypt_key = 'TLIFRAMEWORK';
	
	public function __construct($config_path = 'config/config.ini'){
		$db_array = parse_ini_file($config_path,true);
		$this->getDsn($db_array);
	}
	
	private function getDsn($db_array){
		
		$dbhost = $db_array['DB']['host'];
		$dbuser = $db_array['DB']['dbuser'];
		$dbpass = $db_array['DB']['dbpass'];
		$persistent = $db_array['DB']['dbpersistent'];
		$dbtype = $db_array['DB']['dbtype'];
		$dbname = $db_array['DB']['dbname'];
		
		switch ($dbtype){
			
			case "mysql":
				
				if(!$persistent){
					$this->db = new PDO("$dbtype:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
				}else{
					$this->db = new PDO("$dbtype:host=$dbhost;dbname=$dbname",$dbuser,$dbpass,array( PDO::ATTR_PERSISTENT=>true));
				}
					$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				break;
				
			case "oracle":
				//Code for oracle dsn  
				break;
		}
		//return $this->db;	
		
	}
	
	public function selectArrayNumeric($sql, $params = array()){
		try{
			$sth = $this->db->prepare($sql);
			$sth->execute($params);
			$result = $sth->setFetchMode(PDO::FETCH_NUM);
			return $sth->fetchAll();
		}catch(PDOException $e){
			print $e->getMessage();
			//Log this to a file later when in production
			exit;
		}
		
	}
	
	public function selectArrayAssoc($sql, $params = array()){
		try{
			$sth = $this->db->prepare($sql);
			$sth->execute($params);
			$result = $sth->setFetchMode(PDO::FETCH_ASSOC);
			return $sth->fetchAll();
		}catch(PDOException $e){
			print $e->getMessage();
			//Log this to a file later when in production
			exit;
		}
	}
	
	public function selectObj($sql, $params = array()){
		
		try{
			$sth = $this->db->prepare($sql);
			$sth->execute($params);
			$result = $sth->setFetchMode(PDO::FETCH_OBJ);
			return $sth->fetchAll();
		}catch(PDOException $e){
			print $e->getMessage();
			//Log this to a file later when in production
			exit;
		}
	}
	
	public function executeInsertSQL($fields=array(), $values=array(),$table=''){
		if(!empty($fields) && !empty($values) && !empty($table)){
			if(count($fields) !=count ($values)){
				throw new Exception("Field count does not match the values count");
				exit;
			}
			
			$sql = "INSERT INTO $table ";

			$sql_fields = "(";
			$sql_values = "(";

			for($i=0; $i<count($fields);$i++){
				$sql_fields .=  $fields[$i].",";
				$sql_values .=  ":".$fields[$i].",";
			}

			$sql_fields = substr($sql_fields,0,strlen($sql_fields)-1);
			$sql_values = substr($sql_values,0,strlen($sql_values)-1);
			$sql_values = substr($sql_values,1,strlen($sql_values));
		 	$sql_params = explode(',',$sql_values);
		 	$params =array_combine($sql_params,$values);
		 	$sql = $sql." ".$sql_fields.") VALUES (".$sql_values.");";
			$sth = $this->db->prepare($sql);
			$sth->execute($params);
			$last_insert_id = $this->db->lastInsertId();
			return $last_insert_id;			
		}
		
	}
	
	public function executeQuery($query){
        try{
            $pass = false;
            $query = trim($query);
            if($query === NULL || empty($query)){
                return true;
            }
            if(!$pass){
                $affected_rows = $this->db->exec($query);
            }
            
        }catch (PDOException $e){
            //echo "Caught Exception:".$e->getMessage();
        }
     return $affected_rows;
    }
    
 	public function buildMultiInsertSQL($table, $coloumnnames, $rowvals){
        
        $data = "";
        
        for($i=0; $i<count($rowvals); $i++){
                
            $actual_rowvals = array_values($rowvals[$i]);
            
            if(count($coloumnnames) != count($actual_rowvals)){
                $msg = true;
            }
            
            if(!$msg){
                $data   .= "(".implode(',',$actual_rowvals)."),";
            }
        }
        
        if($msg == true){
            throw new Exception("An array field count and column names does not match");
            exit;
        }
        
        $dbcolumnames = implode(',',$coloumnnames);
        $sql = "insert into $table ($dbcolumnames) values $data";
        $sql = substr($sql,0,-1);
        
        return $sql;
    }
    
	public function prepareStmt($sql ){
		try{
			$sth = $this->db->prepare($sql);
			return $sth;
		}catch(PDOException $e){
			print $e->getMessage();
			//Log this to a file later when in production
			exit;
		}
	}
	
	public function prepareStmtExecute($sth){
		try{
			$sth->execute();
			$result = $sth->setFetchMode(PDO::FETCH_ASSOC);
			return $sth->fetchAll();
		}catch(PDOException $e){
			print $e->getMessage();
			//Log this to a file later when in production
			exit;
		}
	}
	
    public function executeUpdate($sql,$params){
   		 try{
    		$q = $this->db->prepare($sql);
    		$q->execute($params);
    	}catch(PDOException $e){
			print $e->getMessage();
			//Log this to a file later when in production
			exit;
		}
    }
	
	public function executeDelete($sql,$params){
   		 try{
    		$q = $this->db->prepare($sql);
    		$q->execute($params);
    	}catch(PDOException $e){
			print $e->getMessage();
			//Log this to a file later when in production
			exit;
		}
    }
	
	public function Test(){
		$sql =" SELECT* from users where user_id = :user_id ";
		$params = array(':user_id'=>$user_id);
		$result = $this->db->selectArrayAssoc($sql,$params);
	}
}
?>