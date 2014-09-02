<?php   
	include_once('userModel.php');
	include_once('cmsController.php');
	class usersController extends cmsController{
		
		public function __construct(){
			
		}
		
        public function index($pgno=''){
		if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'cms/');
			}
			$this->admin_head();
			$this->top_menu();
			$this->userslist($pgno);
			$this->admin_foot();
		}
		
		public function userslist($pgno){
			$clrresult = '';
			$username = '';
			$email = '';
			$accesslevel = '';
			if(count($_POST)){
				$username = $_POST['username'];
				$email = $_POST['email'];
				$accesslevel = $_POST['accesslevel'];
				$clrresult = "<a href='".HOST."users/'>Clear Result</a>";
			}
			$user_model = new userModel();
			$res = $user_model->getUserList('', $username, $email, $accesslevel, HOST.'users/index', $pgno);
			$pagelinks = $user_model->getPagelinks();
			$xtpl = new Xtemplate("admin".DS."userslist.xtpl");
			$max = count($res);
			$actimg = "<img src='".IMAGE."admin/status.gif' alt='Active' title='Active'>";
			$inactimg = "<img src='".IMAGE."admin/busy.gif' alt='Inactive' title='Inactive'>";
			if($max>0){
				for($rt=0;$rt<$max;$rt++){
						$user_list = array(
								"FIRSTNAME"=>$res[$rt]['firstname'],
								"USERNAME"=>$res[$rt]['username'],
								"EMAIL"=>$res[$rt]['email'],
								"LEVEL"=>$res[$rt]['accesslevel']==2?"Administrator":($res[$rt]['accesslevel']==3?"Client":""),
								"STATUS"=>"<a href='".HOST."users/userstatus/".$res[$rt]['id']."' onclick='return confirm(\"Are you sure you want to ".($res[$rt]['status']==1?'Inactivate':'Activate') ." this User? \")'>".($res[$rt]['status']==1?$actimg:$inactimg)."</a>",
								"EDIT"=>"<a href='".HOST."users/add/".$res[$rt]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"DEL"=>"<a href='".HOST."users/userdel/".$res[$rt]['id']."' onclick='return confirm(\" Are you sure you want to delete this record\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>"
						);
					
					$xtpl->assign('DATA',$user_list);
					$xtpl->parse('main.row.columns');
					$i++;
			   }
			} else {
				$xtpl->assign('NORECORD', 'No record Found.');
			}
			foreach($_POST as $key =>$val) {
				${$key} = htmlentities($val, ENT_QUOTES);
			}
			if($accesslevel !='' && $accesslevel==2){
				$xtpl->assign('ACCESSLEVEL2', "selected='selected'");
			} else if($accesslevel !='' && $accesslevel==3) {
				$xtpl->assign('ACCESSLEVEL3', "selected='selected'");
			}
			$xtpl->parse('main.row');
			$xtpl->assign('USERNAME', stripslashes($username));
			$xtpl->assign('EMAIL', stripslashes($email));
			$xtpl->assign('PAGINATION', $pagelinks);
			$xtpl->assign('STYLE', STYLE.'admin/');
			$xtpl->assign('IMAGE', IMAGE.'admin/');
			$xtpl->assign('CLRRESULT', $clrresult);
			$xtpl->assign('HOST', HOST);
			$xtpl->parse('main');
			$xtpl->out('main');
		}
		
		public function add($id=''){
		if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'cms/');
			}
			$validation = new Validation();
			$user = new userModel();
			$arr = array();
			if(count($_POST)){
				$err = '';
				$id = $_POST['id']?$_POST['id']:'';
				if($_POST['firstname'] == '') $err = "<br/> Name must not be blank.";
				if($_POST['accesslevel'] == '') $err .= "<br/> Access Level must not be blank.";
				if($_POST['email'] == '') $err .= "<br/> Email must not be blank.";
				elseif(!($validation->validateEmail($_POST['email']))) $err .="<br/> Please enter valid Email address.";
				elseif($user->isEmailExists($_POST['email'], $id)) $err .="<br/> This Email address already exists.";
				if($_POST['username']=='') $err .="<br/> User Name must not be blank.";
				elseif($user->isUserNameExists($_POST['username'], $id)) $err .="<br/> User Name already exists.";
				elseif(strlen($_POST['username']) < 4) $err .="<br/> User Name must be greater than four characters.";
				elseif ($_POST['username'] != '' && !eregi('^[a-zA-Z0-9_]{4,60}$', $_POST['username'])) $err .="<br/> User Name must not contain any special characters.";
				if(($id=='') && ($_POST['password']=='')) $err.="<br/> Password must not be blank."; 
				elseif($id=='' && strlen($_POST['password']) < 4) $err .="<br/> Password must be greater than four characters.";
				elseif ($id=='' && $_POST['password'] != '' && !eregi('^[a-zA-Z0-9_]{4,60}$', $_POST['password'])) $err .="<br/> Password must not contain any special characters.";
				elseif(($id=='') && ($_POST['cpassword']=='')) $err.="<br/> Confirm Password must not be blank."; 
				elseif(($id=='') && ($_POST['password']!=$_POST['cpassword'])) $err .="<br/> Password and confirm password does not match.";
				if($err==''){
					if($id!=''){
						$exq = "";
						if($_POST['password']!=''){
							$exq .= ", password = :password";
							$params = array(':firstname'=>stripslashes(stripslashes($_POST['firstname'])), ':username'=>stripslashes(stripslashes($_POST['username'])), ':email'=>$_POST['email'], ':accesslevel'=>$_POST['accesslevel'], ':id'=>$id , ':password'=>md5($_POST['password']));
						}else{
							$params = array(':firstname'=>stripslashes(stripslashes($_POST['firstname'])), ':username'=>stripslashes(stripslashes($_POST['username'])), ':email'=>$_POST['email'], ':accesslevel'=>$_POST['accesslevel'], ':id'=>$id);
						}
						$sql = "UPDATE users SET firstname=:firstname, username=:username, email=:email, accesslevel=:accesslevel ".$exq." WHERE id=:id";
						$res = $user->updateUserData($sql, $params);
					}else{
						$values = array(stripslashes(stripslashes($_POST['firstname'])), stripslashes(stripslashes($_POST['username'])), md5($_POST['password']), $_POST['email'], $_POST['accesslevel'], '1', date("Y-m-d H:i:s"));
					    $fields = array('firstname', 'username', 'password', 'email', 'accesslevel', 'status', 'created');
						$res = $user->saveUserData($values, $fields);
					}
					
					 header("Location: ".HOST."users/");
				}
				$arr = $_POST;
			}
			if($id!=''){
				$res = $user->getUserList($id);
				$arr = $res[0];
				$arr['password'] = '';
			}
			
			$this->admin_head();
			$this->top_menu();			
			$this->usersadd($err, $arr);
			$this->admin_foot();
		}
		
		public function usersadd($err, $arr=array()){
			$xtpl = new Xtemplate("admin".DS."useradd.xtpl");
			foreach($arr as $key =>$val){
				$xtpl->assign(strtoupper($key), $val);	
			}
			/*$xtpl = new Xtemplate("admin".DS."useradd.xtpl");
			$xtpl->assign('FIRSTNAME', $arr['firstname']);
			$xtpl->assign('EMAIl', $arr['email']);
			$xtpl->assign('USERNAME', $arr['username']);
			$xtpl->assign('PASSWORD', $arr['password']);
			$xtpl->assign('CPASSWORD', $arr['cpassword']);
			$xtpl->assign('ID', $arr['id']);*/
			if($arr['accesslevel']==2) {
				$xtpl->assign('ACCESSLEVEL2', "selected='selected'");
			}
			if($arr['accesslevel']==3) {
				$xtpl->assign('ACCESSLEVEL3', "selected='selected'");
			}
			$xtpl->assign('IMAGE', IMAGE.'admin/');		
			$xtpl->assign('ERR', $err);
			$xtpl->parse('main');
			$xtpl->out('main');
		}
		
		public function userdel($id=''){
			if($id!=''){
				$user = new userModel();
				$user->deleteRecord($id);
			}
			header("Location: ".HOST."users/");
		}
		
		public function userstatus($id=''){
			if($id!=''){
				$user = new userModel();
				$user->chageStatus($id);
			}
			header("Location: ".HOST."users/");
		}
		
   }
?>