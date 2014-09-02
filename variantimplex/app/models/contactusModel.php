<?
include_once('../core/DB.php');
class contactusModel extends DB{
  public $file;
  public $fhnd; 

  public function __construct(){
		 parent::__construct();
  } 
  
  public function saveContactusDetails($arr ){
		$fields = array('name', 'email', 'comments', 'created');
		$values = array($arr['name'], $arr['email'], $arr['comments'], date("Y-m-d H:i:s"));
		$insertid = $this->executeInsertSQL($fields, $values, 'contcactus');
		return $insertid;
  }
 
}

?>