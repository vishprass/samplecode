<?php
	include_once("cmsController.php");
	include_once("menuModel.php");
	//include_once("validate.php");   
	class menuController extends cmsController{
		
		public function __construct(){
		
		}
		public function menu_form($err, $id=''){
			$menu_model = new menuModel();
			$data = array();
			$internalchk = '';
			$externalchk = '';
			$menulbl = '';
			$sel = '';
			$pagesel = '';
			$txtlink = '';
			$publish = '';
			$hidden = '';
			$xtpl = new Xtemplate("admin".DS."menuform.xtpl");
			$xtpl->assign('ERR', $err);
			if($id!=''){
				$data = $menu_model->getMenues($id);
				$id = $data[0]['id'];
				if($data[0]['linktype']==1) $externalchk = "checked='checked'";
				if($data[0]['linktype']==2) $internalchk = "checked='checked'";
				$sel = $data[0]['parent'];
				$menulbl = $data[0]['label'];
				if($data[0]['linktype']==1) $txtlink = $data[0]['link'];
				if($data[0]['linktype']==2) $pagesel = $data[0]['link'];
				if($data[0]['publish']==1) $publish = "selected='selected'";
				if($data[0]['publish']==0) $hidden = "selected='selected'";
				
			}
			if(count($_POST)){
				if($_POST['mtype']==1) $externalchk = "checked='checked'";
				if($_POST['mtype']==2) $internalchk = "checked='checked'";
				$sel = 	$_POST['parent'];			
				$menulbl = $_POST['menulabel'];
				$id = $_POST['id'];
				$pagesel = $_POST['linkdrpdn'];
				$txtlink = $_POST['linktxt'];
				if($_POST['publish'] == 1) $publish = "selected='selected'";
				if($_POST['publish'] == 0) $hidden = "selected='selected'";
				//print_r($_POST);
			}
			
			$xtpl->assign('EXTERNALCHK',$externalchk);
			$xtpl->assign('INTERNALCHK',$internalchk);
			$xtpl->assign('MENULABEL',$menulbl);
			$xtpl->assign('LINKTXT',$txtlink);
			$xtpl->assign('FID',$id);
			$xtpl->assign('FPUBLISHSELECT1',$publish);
			$xtpl->assign('FPUBLISHSELECT0',$hidden);
			
			include("cmsModel.php");
			$cms_model = new cmsModel();
			$menu_list = $cms_model->getPageSelectBox('', $pagesel);
			$xtpl->assign('INTERNAL',$menu_list);
			if($err!='') $xtpl->assign('ERRCLS','err');	
			$res = $menu_model->getParentMenus($sel);
			$xtpl->assign('PARENTMENUES',$res);
			$xtpl->assign('IMAGE', IMAGE.'admin/');
	      	$xtpl->parse('main.row');
		  	$xtpl->parse('main');
		  	$xtpl->out('main');
		}
		
        public function index( $id='') {
			if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'cms/');
			}
			
			$err = '';
			
			if(count($_POST)){
				$valid = new Validation();
				$menu = new menuModel();
				$max_parent = $menu->getMaxParentMenus();
			     $num = $max_parent['num'];
				
			//	if (mysql_num_rows(mysql_query("SELECT id FROM users WHERE username='$username' AND status!='0' AND id!='$id' LIMIT 1")) > 0 ) $err[] = 'User name already exists.';
				
				$res=$menu->getres($_POST['menulabel'],$id);
				$max1=count($res);
				$res1=$menu->getres1($_POST['linkdrpdn'],$id);
				$max2=count($res1);
				
				if($id==''){
				
					if($num>5) $err .='Maximum menu limit reached.';
					if($_POST['mtype'] == '') $err .= '<br/>Please select Link type.';
					if(($_POST['menulabel']=='') && ($_POST['link']=='')) $err .= '<br/>Menu label must not be blank.';
					elseif($menu->isLabelExists($_POST['menulabel'], $id)) $err .="<br/> Menu Label already exists."; 
					}
					else
					{
					if($max1>0){
					  $err .="<br/> Menu Label already exists."; 
					}
					
					}
				if(($_POST['mtype'] ==1) && (!($valid->validateUrl($_POST['linktxt'])))) $err .= "<br/>Please Enter valid URL.";
				/*if(($_POST['mtype']==2) &&($_POST['parent']=='')) $err .= "<br/>Please select parent menu.";*/
				$link = ($_POST['mtype']=='1')?$_POST['linktxt']:$_POST['linkdrpdn'];
				if(($_POST['linktxt']=='') && ($_POST['mtype']=='')) $err .='<br/> Menu Link must not be blank.'; 
				if(($_POST['mtype']==1) && ($_POST['linktxt']=='')) $err .='<br/> External URL must not be blank.'; 
				if(($_POST['mtype']==2) && ($_POST['linkdrpdn']=='')) $err .='<br/> Please select a link.'; 
				if($_POST['mtype']==2){
				if($id==''){
				
					//$r = $menu->isLinkExists($_POST['linkdrpdn']);
					if($menu->isLinkExists($_POST['linkdrpdn'])) $err.="<br/>This page already Linked.";//
					}
					else{
					if($max2>0){
					
					$err.="<br/>This page already Linked.";
					}
					}
				}
				if($err=='') {
				$res= $menu->saveMenues(stripslashes($_POST['menulabel']), $link, $_POST['publish'], $_POST['id'], 0, $_POST['mtype']);										
					if($res!=''){ 
						if($_POST['id']){
							$msg = "Data updated Successfully.";
						}else{
							$msg = "Data inserted Successfully.";
						}
					}
					header('Location: '.HOST.'menu/'.menuList);
				}
				
			}
			$this->admin_head();
			$this->top_menu();
			$this->menu_form($err, $id);
			$this->admin_foot();
		}
		
		
		public function delete($id=''){
			$menu_model = new menuModel();
			$res = $menu_model->deleteRecord($id);
			header('Location: '.HOST.'menu/menuList');
		}
		
		public function ordermenu($dir='', $mid=''){
			$menu_model = new menuModel();
			$menu_model->rearangeMenuOrder($dir, $mid);
			header('Location: '.HOST.'menu/menuList');
		}
		
		public function menulist(){
		if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'cms/');
			}
			$this->admin_head();
			$this->top_menu();
			$this->display_menulist();
			$this->admin_foot();
		}
		
		public function display_menulist(){
		#session_start();
		#print '-->'.$_SESSION['username'];
		/*if(! isset($_SESSION['username']))
			{
				header('Location:http://www.google.com');
			}*/
			$menu_model = new menuModel();
			$mname = '';
			$clrresult = '';
			if(count($_POST)){
					$mname = $_POST['menuname'];
					$clrresult = "<a href='".HOST."menu/menulist'>Clear Result</a>"; 
			}
			$menus = $menu_model->getMenuesByGroup($_POST['menuname']);
			
			$xtpl = new Xtemplate("admin".DS."menulist.xtpl");
			
			
		



			
			$upimage = "<img src='".IMAGE."admin/up_arr.png'>";
			$downimage = "<img src='".IMAGE."admin/down_arr.png'>";
			$max = count($menus);
			if($max>0){
			for($rt=0;$rt<$max;$rt++){
				if($menus[$rt]['menuorder'])		
					$menu_list = array(
						"ID"=>$menus[$rt]['id'],
						"NAME"=>$menus[$rt]['label'],
						"EDIT"=>"<a href='".HOST.'menu/index/'.($menus[$rt]['id'])."'><img src='".IMAGE."admin/vpedit.gif'></a>",
						"MENUORDER" => "<a href='".HOST.'menu/ordermenu/up/'.$menus[$rt]['id']."'>".$upimage."</a>&nbsp;&nbsp;&nbsp;<a href='".HOST.'menu/ordermenu/down/'.$menus[$rt]['id']."'>".$downimage."</a>",
						"DEL"=>"<a href='".HOST.'menu/delete/'.($menus[$rt]['id'])."' onclick='return confirm(\" Are you sure you want to delete this record.\")'><img src='".IMAGE."admin/delete.gif'></a>"
		   		    );
		   		$xtpl->assign('DATA',$menu_list);
		   		$xtpl->parse('main.row.columns');
		   		$i++;
	       }
		   }else{
		   		$xtpl->assign('NORECORD', 'No record Found.');
		   }
		   $xtpl->assign('MENUNAME', $mname);
		   $xtpl->assign('IMAGE', IMAGE.'admin/');
	       $xtpl->assign('CLRRESULT', $clrresult);
		   $xtpl->parse('main.row');
		   $xtpl->parse('main');
		   $xtpl->out('main');
		}
   }
?>