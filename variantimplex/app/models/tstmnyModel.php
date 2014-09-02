<?
include_once('Paginated.php');
class tstmnyModel extends PDB{
	private $pagelinks;
	function __construct(){
		parent::__construct();
    }
	
    public function savedate($fields, $values){
		$table = 'news';
		$res = $this->executeInsertSQL($fields, $values, $table);
		return $res;
	}	
	
	public function deleteRecord($id){
		$sql = "DELETE FROM news WHERE id=:id";
		$params = array(':id'=>$id);
	    $this->executeDelete($sql, $params);;
	}
	public function updateData($pageid, $body, $title, $id,$path){
		$sql = "UPDATE news SET pageid=:pageid, body=:body, title=:title,image_path=:path WHERE id=:id";
		$params = array(':pageid'=>$pageid, ':body'=>$body, ':id'=>$id, ':title'=>$title,':path'=>$path);
		return $this->executeUpdate($sql, $params);
	}
	public function updateDatanew($pageid, $body, $title, $id){
		$sql = "UPDATE news SET pageid=:pageid, body=:body, title=:title WHERE id=:id";
		$params = array(':pageid'=>$pageid, ':body'=>$body, ':id'=>$id, ':title'=>$title);
		return $this->executeUpdate($sql, $params);
	}
	public function getTstmnyLists($title='',  $pagelink='', $pgno='', $append = ''){
		$fields['title'] = $title;		
		$params = array();
		$vars = array();
	  	foreach($fields as $key=>$val){
			if(trim($val)!=''){
				$params[':'.$key] = $val;
			   	$vars[$key] = $key." LIKE '%".$val."%' ";				
			}
		}
		$exq =count($vars)?" WHERE ".implode('AND ', $vars):'';
		$sql = "SELECT * FROM news ".$exq." ORDER BY id DESC";
		$result = $this->selectArrayAssoc($sql, $params);
		$pgn = new Paginated($this->db, $sql, 10, $links_per_page = 5, $append, count($result), $pgno, $pagelink);
		$newsql = $pgn->paginate();
		$this->pagelinks=$pgn->renderFullNav();
		$res = $this->selectArrayAssoc($newsql, $params);
		return $res;
	}
	
	public function getTestiMonyDetail($id=''){
	   if($id!=''){
			$sql = "SELECT * FROM news WHERE id=:id";
			$params = array(':id'=>$id);
			$res = $this->selectArrayAssoc($sql, $params);
			return $res;
		}
	}
	
	public function isTestmonyExist($id=''){
		if($id!=''){
			$sql = "SELECT id FROM news WHERE id=:id";
			$params = array(':id'=>$id);
			$res = $this->selectArrayAssoc($sql, $params);
			return (intval($res[0]['id'])?1:0);
		}
	}
	
	public function getTestmonyidFromPageid($id=''){
		if($id!=''){
			$sql = "SELECT id FROM news WHERE id=:id";
			$params = array(':id'=>$id);
			$res = $this->selectArrayAssoc($sql, $params);
			return (intval($res[0]['id'])?1:0);
		}
	}
	public function getPagelinks(){
		return $this->pagelinks;
	}
	
	public function getNewsDetail($id='', $status=1){
	   if($id!=''){
			$sql = "SELECT * FROM news WHERE id=:id AND STATUS = :status";
			$params = array(':id'=>$id, ':status'=>$status);
			$res = $this->selectArrayAssoc($sql, $params);
			return $res;
		} else {
			$sql = "SELECT id, body FROM news WHERE STATUS = :status ORDER BY id DESC LIMIT 3";
			$params = array(':status'=>$status);
			$res = $this->selectArrayAssoc($sql, $params);
			return $res;
			
		}
	}
	
	
}

?>