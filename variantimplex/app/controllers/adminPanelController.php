<?php   
	include_once('cmsController.php');
	include_once('userModel.php');
	class adminPanelController extends cmsController{

		public function index(){
			$this->admin_head();
			$this->top_menu();
			$xtpl = new Xtemplate("admin".DS."landing.xtpl");
			$xtpl->assign('STYLE', STYLE.'admin/');
			$xtpl->assign('IMAGE', IMAGE.'admin/');
			$xtpl->assign('HOST', HOST);
			$xtpl->parse('main');
			$xtpl->out('main');
			$this->admin_foot();
		} 
		
		
		
		public function changepass(){
			session_start();
			if(count($_POST)){
				$err = '';
				if($_POST['oldpassword']=='') $err .="<br/> Old Password must not be blank.";
				if($_POST['newpassword']=='') $err .="<br/> New Password must not be blank.";				
				elseif(strlen($_POST['newpassword']) < 4) $err .="<br/> New Password must have minimum four characters.";
				elseif ($_POST['newpassword'] != '' && !eregi('^[a-zA-Z0-9_]{4,60}$', $_POST['newpassword'])) $err .="<br/> Password must not contain any special characters.";				
				if($_POST['cpassword']=='') $err .="<br/> Confirm Password must not be blank.";				
				elseif($_POST['newpassword']!=$_POST['cpassword']) $err .="<br/> Password and Confirm Password does not match.";
				if($err == ''){
					$umodel = new userModel();
					$res = $umodel->checkOldPassword($_POST['oldpassword'], $_SESSION['userid']);
					if(!$res) {$err.="<br/> Old Password does not match.";}
					else {$umodel->changeOldPassword($_POST['newpassword'], $_SESSION['userid']);
					echo "<script>alert('Password Changed'); document.location.href='".HOST."adminPanel';</script>";
						//header('Location: '.HOST.'adminPanel/');
					}					
				}
			}
			$this->admin_head();
			$this->top_menu();
			$xtpl = new Xtemplate("admin".DS."changepass.xtpl");
			$xtpl->assign('STYLE', STYLE.'admin/');
			$xtpl->assign('IMAGE', IMAGE.'admin/');
			$xtpl->assign('HOST', HOST);
			$xtpl->assign('ERR', $err);
			$xtpl->assign('OLDPASSWORD', $_POST['oldpassword']);
			$xtpl->assign('NEWPASSWORD', $_POST['newpassword']);
			$xtpl->assign('CPASSWORD', $_POST['cpassword']);
			$xtpl->parse('main');
			$xtpl->out('main');
			$this->admin_foot();
		}
   }
?>