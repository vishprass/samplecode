<?php
include_once("cmsController.php");
include_once("cmsModel.php");
class pageController extends cmsController{		
	public function __construct(){
	
	}
	
	public function createpage_form($err, $arr, $id){
		if(count($arr)>1){
			$page = $arr['name'];
		}
		
		$xtpl = new Xtemplate("admin".DS."createpage.xtpl");
		$cms_model = new cmsModel();
		$modules = $cms_model->getUiModules();
		
		$validation  = new Validation();
		if($id!=''){
			$content = $cms_model->getPageContent($id);
			$page_modules = $cms_model->getPageModules($id);
			foreach($page_modules as $p=>$mid){
				$mod[] = $mid['module_id'];
			}
			
			$arr['desc'] = stripslashes($content[0]['body']);
			$arr['id'] = $content[0]['id'];
			$arr['description'] = $content[0]['description'];
			$arr['meta'] = $content[0]['meta'];
			$arr['name'] = $content[0]['pagename'];
			$arr['title'] = $content[0]['title'];
			$arr['page_title'] = $content[0]['page_titles'];
		}
		
		foreach($arr as $key =>$val){
			$xtpl->assign(strtoupper($key), $val);	
		}
		
		if(count($modules) !=0){
			foreach($modules as $d=>$matter){
				
				$checked = false;
				
				if ((count($mod) != 0) && in_array($matter['id'],$mod)){
					$checked = "checked=true";
				}
				$data = array(
					"ID"=>$matter['id'],
					"NAME"=>ucfirst($matter['name']),
					"CHECKED"=>$checked
				);
				
				$xtpl->assign('DATA',$data);
				$xtpl->parse('main.row.coloumns');	
			}
			$xtpl->parse('main.row');
		}	
		$xtpl->assign('IMAGE', IMAGE.'admin/');
		$xtpl->assign('ERR', $err);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
        
	public function index($id = ''){
	   if(count($_POST)){
	   		
			$validation  = new Validation();
			$cms = new cmsModel();
			$cms_model = new cmsModel();
			$modules = $cms_model->getUiModules();
						
			foreach($modules as $d=>$matter){
				if(isset($_POST[ucfirst($matter['name'])])){
					$ui[] = $_POST[ucfirst($matter['name'])];
				}
			}
			
			if($_POST['name'] == '') $err = '<br/>Page name must not be blank.';
			elseif($validation->countWords($_POST['name']))
			if($cms->isExistsPagename($_POST['name'], $_POST['id']) )  $err .= '<br/>This page already exist.';
		//	if($_POST['title'] == '') $err .= "<br/> Page title may not be blank.";
			if($_POST['desc'] == '') $err .= '<br/>Page content must not be blank.';
			
			if($err ==''){
				//echo stripslashes(stripslashes($_POST['title']))."<br>";
				//echo $_POST['title']."<br>";
				//echo eregi_replace("\'", "'", $_POST['title']); die;
				$res = $cms->savePages(strip_tags($_POST['name']), stripslashes(stripslashes($_POST['title'])),$_POST['page_title'], $_POST['meta'], $_POST['description'], $_POST['desc'], '1',$_POST['id']);
			
			if(intval($res)) {
				if($_POST['id']){
					$msg = "Page updated successfully.";
				}else{
					$msg = "Page created successfully.";
				}
				$page_id = ($res!==true)? $res: $_POST['id'];
				$cms->saveModules($page_id,$ui);
				
				echo "<script>alert('$msg'); document.location.href='".HOST."page/pages';</script>";
		  	}
	 	}
	   }
		$this->admin_head();
		$this->top_menu();
		$this->createpage_form($err, $_POST, $id);
		$this->admin_foot();
	}
	
	public function deleteRecord($id=''){
		$menu_model = new menuModel();
		$res = $menu_model->deleteRecord($id);
	}
	
	public function delete($id=''){
	    
		if($id != ''){
			$cms_model = new cmsModel();
			$res = $cms_model->deletePage($id);
		    header('Location:'.HOST.'page/pages/');
		}
	}
	public function pages($pageno='', $pname = '', $title = ''){
		$this->admin_head();
		$this->top_menu();
		$this->pagelist($pageno, $pname, $title);
		$this->admin_foot();
	}
	
	public function pagelist($pageno, $search1 = '', $search2 = ''){
		//print_r(func_get_args());
	#print_r(func_get_args());
	    $cms_model = new cmsModel();
	   // echo "asdadadada";
		$clrresult = '';
		//$search1 = "p=";
		//$search2 = "t=";

		if(count($_POST))
		{
			$pname = isset($_POST['pagename']) ? filter_var($_POST['pagename'],FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW): '';
			$title = isset($_POST['title']) ? filter_var($_POST['title'],FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW): '';
	//		echo $pname;
		//	echo $title;
			$search1 = "p=".$pname;
			$search2 = "t=".$title;
			$clrresult = "<a href='".HOST."page/pages'>Clear Result</a>";
		}
		$append = '';
		if(!empty($search1) && !empty($search2)){
			$append = $search1."/".$search2;
		
			$clrresult = "<a href='".HOST."page/pages'>Clear Result</a>";
		}else if (!empty($search1) && empty($search2)){
			$append = $search1;
			$clrresult = "<a href='".HOST."page/pages'>Clear Result</a>";
		}else if (empty($search1) && !empty($search2)){
			$append = $search2;
			$clrresult = "<a href='".HOST."page/pages'>Clear Result</a>";
		}else{
			$append = "";
		}
		//echo $append;
		$p = explode("=", $search1);
		//print_r($p);
		$q = explode("=",$search2);
		//print_r($q);
		$pname = isset($p['1'])?filter_var($p['1'],FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW):'';
	//	echo $pname;
		$title = isset($q['1'])?filter_var($q['1'],FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW):'';	
		//echo $title;
		$res = $cms_model->getPageList('', '', $title, $pname, HOST.'page/pages', $pageno, $append);
		$pagelinks = $cms_model->getPagelinks();
		//echo $pagelinks;
//		echo $pagelinks;
		$xtpl = new Xtemplate("admin".DS."pagelist.xtpl");
		$max = count($res);
		if($max>0){	
			foreach($res as $key => $val){
					$titles = !empty($val['title']) ?( (strlen($val['title'])> 30) ? substr($val['title'],0,30).".." : $val['title']  ) : '';	
					$menu_list = array(
							"NAME"=>$val['pagename'],
							"TITLE"=>$titles,
							"EDIT"=>"<a href='".HOST.'page/index/'.$val['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
							"DEL"=>"<a href='".HOST.'page/delete/'.$val['id']."' onclick='return confirm(\"Are you sure to delete this page? On Deleting this all the associated menu links would be removed.\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>"
					);
				$xtpl->assign('DATA',$menu_list);
				$xtpl->parse('main.row.columns');
				$i++;
		   }
	   }else{
	   		$xtpl->assign('NORECORD', 'No record Found.');
	   }
	   foreach($_POST as $key =>$val){
			${$key} = htmlentities($val, ENT_QUOTES);
			$xtpl->assign(strtoupper($key), stripslashes(${$key}));	 	
	   }
	   //echo $title; die;
       $xtpl->assign('CLRRESULT', $clrresult);
	   $xtpl->assign('PAGINATION', $pagelinks);
	   $xtpl->assign('HOST', HOST);
	   $xtpl->assign('PNAME', stripslashes($pname));
	   $xtpl->assign('TITLE', stripslashes($title));
	   $xtpl->assign('IMAGE', IMAGE.'admin/');
	   $xtpl->parse('main.row');
	   $xtpl->parse('main');
	   $xtpl->out('main');
	}
  }
?>