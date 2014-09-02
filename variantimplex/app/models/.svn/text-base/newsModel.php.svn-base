<?

class newsModel extends PDB{
	function __construct(){
		parent::__construct();
    }
	
  /*  public function savedate($fields, $values){
		$table = 'testimonies';
		$res = $this->executeInsertSQL($fields, $values, $table);
		return $res;
	}	
	
	public function updateData($pageid, $body, $title, $id){
		$sql = "UPDATE testimonies SET pageid=:pageid, body=:body, title=:title WHERE id=:id";
		$params = array(':pageid'=>$pageid, ':body'=>$body, ':id'=>$id, ':title'=>$title);
		return $this->executeUpdate($sql, $params);
	}
	
	public function getTstmnyLists($pagename=''){
		$sql = "SELECT T.* , C.title FROM testimonies T LEFT JOIN cms C ON (C.id = T.pageid)";
	    $params = array();
		if($pagename!=''){
			$sql = "SELECT T.* , C.title FROM testimonies T LEFT JOIN cms C ON (C.id = T.pageid) WHERE pagename LIKE :pagename";
	    	$params = array(':pagename'=>"%".$pagename."%");
		}
		$res = $this->selectArrayAssoc($sql, $params);
		return $res;
	}
	*/
	public function getNewsDetail($id=''){
	   if($id!=''){
			$sql = "SELECT * FROM news WHERE id=:id";
			$params = array(':id'=>$id);
			$res = $this->selectArrayAssoc($sql, $params);
			return $res;
		} else {
			$sql = "SELECT id, body FROM news ORDER BY id DESC LIMIT 3";
			$res = $this->selectArrayAssoc($sql, $params);
			return $res;
			
		}
	}
	
	public function isTestmonyExist($id=''){
		if($id!=''){
			$sql = "SELECT id FROM testimonies WHERE id=:id";
			$params = array(':id'=>$id);
			$res = $this->selectArrayAssoc($sql, $params);
			return (intval($res[0]['id'])?1:0);
		}
	}
	
	public function getTestmonyidFromPageid($id=''){
		if($id!=''){
			$sql = "SELECT id FROM testimonies WHERE id=:id";
			$params = array(':id'=>$id);
			$res = $this->selectArrayAssoc($sql, $params);
			return (intval($res[0]['id'])?1:0);
		}
	}
}

?>