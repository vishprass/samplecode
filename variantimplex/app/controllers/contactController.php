<?php  
include_once('menuModel.php');
include_once('cmsModel.php');
include_once('indexController.php');
include_once('contactModel.php');
include_once('validation.php');
class contactController extends indexController{

	public function index(){
		$this->head();
		$this->body_left_top();
		$this->body_right_top($id);
		$this->body_left_bottom($id);		
		$this->body_right_bottom($id);
		$this->foot();
	}



	public function body_left_bottom(){
		$valid = new Validation();
		if(count($_POST)){
			$err = '';
			foreach($_POST as $key =>$val){
				${$key} = htmlentities($val, ENT_QUOTES); 	
			}
			if($name=='') $err.="<br/>Name must not be blank.";
			if($company=='') $err.="<br/>Comapny Name must not be blank.";
			if($telephone=='') $err.="<br/>Telephon Name must not be blank.";
			elseif(!($valid->validatePhoneNumber($telephone))) $err.="<br/> Please enter valid phone number.";
			if($email=='') $err.="<br/>Email address must not be blank.";
			elseif(!($valid->validateEmail($email))) $err.="<br/> Please enter valid email address.";
			if($message=='')$err.="<br/> Message must not be blank.";
			if($err==''){
				$con_modle = new contactModel();
				$con_modle->saveData($name, $company, $telephone, $email, $message);
			}
		}
		$xtpl = new Xtemplate("users".DS."contactform.tpl");
		if(count($_POST)){
			foreach($_POST as $key=>$val)
			  	$xtpl->assign(strtoupper($key), $val);
		}
		$xtpl->assign('HOST', HOST);
		$xtpl->assign('ERR', $err);
		$xtpl->assign('IMAGE', IMAGE.'users/');
		
		$xtpl->parse('main');
		$xtpl->out('main');		
	}
	
	public function body_right_bottom($id){
		$this->rightmenu();
	}
	
	
	public function rightmenu(){
		$xtpl = new Xtemplate("users".DS."rightmenu.xtpl");
		$menumodel = new menuModel();
		$links = $menumodel->getPublishMenues('1', 'topmenu');
		$xtpl->assign('RIGHTMENU', $links);
		$xtpl->assign('HOST', HOST);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	
}
?>