<?php   
	include_once('resourceModel.php');
	include_once('cmsController.php');
	class resourceController extends cmsController{
		
		public function __construct(){
			
		}
		
        public function index($id=''){
		   $min_lvl = '';
		   $name = '';
		   $id = $id;
		   $rsc = new resourceModel();
			if(count($_POST)){
				$err = "";
				$id = $_POST['id'];
				if($_POST['name'] == '') $err.="<br/>Please enter a name.";
				if($_POST['min_level'] == '') $err.="<br/>Please Select minimum level.";
				if($_POST['min_level'] != '') $min_lvl = $_POST['min_level'];
				if($_POST['name'] != '') $name = $_POST['name'];
				if($err==''){
					if($id==''){
					 	$fields = array('name', 'min_level');
					 	$values = array($_POST['name'], $_POST['min_level']);
					 	$res = $rsc->saveData($fields, $values);
					 }else{
					 	$res = $rsc->updateData($_POST['name'], $_POST['min_level'], $id);
					 }
					 header('Location:'.HOST.'resource/rlist/');
				}
			}
			if($id!=''){
				$res = $rsc->getResourceList($id);
				$name = $res[0]['name'];
				$min_lvl = $res[0]['min_level'];
			}
			
			$res = $rsc->getUserList();
			$levels = "<select name='min_level' id='min_level' style='width:160px; font-size: 12px;'>";
			$levels .= "<option value=''>Select Minimun level</option>";
			$max = count($res);
			for($f=0;$f<$max;$f++){
				$sel = (($res[$f]['id']==$min_lvl)?"selected='selected'":'');
				$levels .="<option value='".$res[$f]['id']."' $sel >".$res[$f]['name']."</option>";
			}
			$levels .="</select>";
			$this->admin_head();
			$this->top_menu();
			$xtpl = new Xtemplate("admin".DS."addresource.xtpl");
			$xtpl->assign('ERR', $err);
			$xtpl->assign('ID', $id);
			$xtpl->assign('USERLEVEL', $levels);
			$xtpl->assign('RESOURCENAME', $name);
			$xtpl->assign('HOST', HOST);
			$xtpl->parse('main');
			$xtpl->out('main');
			$this->admin_foot();
		}
		
		public function rlist(){
			$cresult = "";
		    if(count($_POST)){
				$resname = $_POST['resourcename'];
				$level = $_POST['level'];
				$cresult = "<a href='".HOST."resource/rlist'>Clear result</a>";	
			}
			$this->admin_head();
			$this->top_menu();
			$xtpl = new Xtemplate("admin".DS."resourcelist.xtpl");
			$rsc = new resourceModel();
			$res = $rsc->getUserList();
			$levels = "<select name='level' id='level' style='width:150px; font-size: 11px;'>";
			$levels .= "<option value=''>Select Minimun level</option>";
			$max = count($res);
			for($f=0;$f<$max;$f++){
				$sel = (($res[$f]['id']==$level)?"selected='selected'":'');
				$levels .="<option value='".$res[$f]['id']."' $sel >".$res[$f]['name']."</option>";
			}
			$levels .="</select>";
			$res = $rsc->getResourceList('', $resname, $level);
			$max = count($res);
			if($max>0){
				for($t=0;$t<$max;$t++){
						$resource_list = array(
								"NAME"=>$res[$t]['name'],
								"LEVEL"=>$res[$t]['accessname'],
								"EDIT"=>"<a href='".HOST."resource/index/".$res[$t]['id']."'><img src='".IMAGE."admin/vpedit.gif'></a>",
								"DEL"=>"<a href='".HOST."resource/delete/".$res[$t]['id']."' onclick='return confirm(\" Are you sure you want to delete this record\")'><img src='".IMAGE."admin/delete.gif'></a>"								
								
								
						);
					$xtpl->assign('DATA',$resource_list);
					$xtpl->parse('main.row.columns');
					$i++;
			   }
		   }else{
		   		$xtpl->assign('NORECORD', 'No record Found.');
		   }
			$xtpl->parse('main.row');
			$xtpl->assign('IMAGE', IMAGE.'/admin/');
			$xtpl->assign('USERLEVEL', $levels);
			$xtpl->assign('RSNAME', $resname);
			$xtpl->assign('CLRRES', $cresult);
			$xtpl->parse('main');
			$xtpl->out('main');
			$this->admin_foot();
		}
		
		
		public function delete($id=''){
			if($id!=''){
				$rsc = new resourceModel();
				$res = $rsc->deleteResource($id);
			}
		    header("Location:".HOST."resource/rlist");
		}
		
		
   }
?>