<?php  
include_once("indexController.php");
include_once("contactusModel.php");
class contactusController extends indexController{
	public function index($err='', $arr){
		$this->head();
		$this->left();
		$this->right();
		$this->body($err, $arr);
		$this->foot();
	}
	public function body($err='', $value){
		$xtpl = new Xtemplate(APP_VIEW.DS."cms".DS."contactusform.xtpl");
		$xtpl->assign('ERR', $err);
		$xtpl->assign('NAME', $value['name']);
		$xtpl->assign('EMAIL', $value['email']);
		$xtpl->assign('COMMENTS', $value['comments']);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	public function saveData($arr){
		if(count($arr)){
			$contactus_model = new contactusModel();
			$insert_id = $contactus_model->saveContactusDetails($arr);
			return $insert_id;
		}
	}
	
	
}
?>