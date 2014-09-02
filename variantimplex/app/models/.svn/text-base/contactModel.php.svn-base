<?
include_once("Paginated.php");
class contactModel extends PDB{
	 private $pagelinks;
	
	function __construct(){
		parent::__construct();
    }
	
	public function saveData($name, $company, $telephone, $email, $message){
		$fields = array('name', 'company', 'email', 'telephone',  'message', 'created', 'status');
		$values = array($name, $company, $email, $telephone, $message, date("Y-m-d H:i:s"), '1');
		$this->executeInsertSQL($fields, $values, 'contactus');
	}	
	
	public function getContactusList(){
		$totalrec = 10;
		$sql = "SELECT * FROM contactus ORDER BY created DESC";
		$params = array();
		//return $this->selectArrayAssoc($sql, $params = array());
		$result = $this->selectArrayAssoc($sql, $params);
		
		$pgn = new Paginated($this->db, $sql, $totalrec, $links_per_page = 5, $append = "", count($result), $pageno, $pagelink);
		$newsql = $pgn->paginate();
		if(count($result)>$totalrec){
			$this->pagelinks=$pgn->renderFullNav();
		}else{
			$this->pagelinks='';
		}
		return $this->selectArrayAssoc($newsql, $params);
	}
	
	
	public function deleteRecord($id){
		$sql = "DELETE FROM contactus WHERE id=:id";
		$params = array(':id'=>$id);
	    $this->executeDelete($sql, $params);
	}
	
	public function getPagelinks(){
		return $this->pagelinks;
	}
}

?>