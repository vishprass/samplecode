<?
include_once('Paginated.php');
class partnerModel extends PDB{
   
    private $pagelinks;
	
	function __construct(){
		parent::__construct();
    }
		
	public function isNameExists($name, $id=''){
		if($id!=''){
			$sql = "SELECT id FROM partners WHERE name=:name AND id!=:id";
			$params = array(':name'=>$name, ':id'=>$id);
		}else{
			$sql = "SELECT id FROM partners WHERE name=:name";
			$params = array(':name'=>$name);
		}
	   $res = $this->selectArrayAssoc($sql, $params);
	   return intval($res[0]['id'])?true:false;
	}
	
	public function savePartnerData($values, $fields){
		$table = "partners";
		$res = $this->executeInsertSQL($fields, $values, $table);
		return $res;
	}
	
	public function getPartnersList($id='', $name='', $url='', $pagelink='', $pageno=1){
		//print_r($this->db);
		$filds['id'] = $id;
		$filds['name'] = $name;
		$filds['url'] = $url;
		$params = array();
		$vars = array();
		foreach($filds as $key=>$val){
			if(trim($val)!=''){
				$params[':'.$key] = $val;
				$vars[$key] = $key." LIKE '%".$val."%' ";		
			}
		}
		$exq =count($vars)?" WHERE ".implode('AND ', $vars):'';
		$sql = 'SELECT * FROM partners '.$exq;
		$result = $this->selectArrayAssoc($sql, $params);
		$pgn = new Paginated($this->db, $sql, 10, $links_per_page = 5, $append = "", count($result), $pageno, $pagelink);
		$newsql = $pgn->paginate();
		$this->pagelinks=$pgn->renderFullNav();
		return $this->selectArrayAssoc($newsql, $params);
	}
	
	public function updatePartnerData($sql, $params){
		$res = $this->executeUpdate($sql, $params);
		return $res;
	}
	
	public function deleteRecord($id){
		$sql = "DELETE FROM partners WHERE id=:id";
		$param = array(':id'=>$id);
		$this->executeDelete($sql, $param);
	}
	
	public function getPagelinks(){
		return $this->pagelinks;
	}
	
	public function chageStatus($id){
		$sql = "SELECT status FROM partners WHERE id=:id ";
		$param = array(':id'=>$id);
		$res = $this->selectArrayAssoc($sql, $param);
		$pstat = $res[0]['status'];
		
		$updatesql = "UPDATE partners SET status='".(($pstat ==1)?2:1)."' WHERE id=:id";	
		$param = array(':id'=>$id);
		$res = $this->executeUpdate($updatesql, $param);		
	}
	
	public function isLogoExists($logo, $id=''){
		if($id!=''){
			$sql = "SELECT id FROM partners WHERE logo=:logo AND id!=:id";
			$params = array(':logo'=>$logo, ':id'=>$id);
		}else{
			$sql = "SELECT id FROM partners WHERE logo=:logo";
			$params = array(':logo'=>$logo);
		}
	   $res = $this->selectArrayAssoc($sql, $params);
	   
	   return intval($res[0]['id'])?true:false;
	}
	
	
	
}

?>