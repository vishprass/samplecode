<?php
	include_once("cmsController.php");   
	class createPageController extends cmsController{		
		public function __construct(){
		
		}
		
		public function createpage_form($err, $page=''){
			$xtpl = new Xtemplate(APP_VIEW.DS."cms".DS."createpage.xtpl");
			$cms_model = new cmsModel();
			$res = $cms_model->getPageList();	
			if($page!=''){
				$filename = "view/theme1/pagetemplate/".$page.".html";
				$content = $cms_model->getPageContent($filename);
			}
			$xtpl->assign('PNAME', stripslashes($page));
			$xtpl->assign('CONTENT',$content);
			foreach($res as $key => $val){	
					$menu_list = array(
							"NAME"=>$val,
							"URL"=>"<a href='./dynamic.php?page=".array_shift(explode(".", $val))."'>View</a>",
							"EDIT"=>"<a href='./createpage.php?page=".array_shift(explode(".", $val))."'>Edit</a>",
							"DEL"=>"<a href='./createpage.php?delpage=".array_shift(explode(".", $val))."' onclick='return confirm(\" Are you sure you want to delete this record\")'>Delete</a>"
		   			);
		   		$xtpl->assign('DATA',$menu_list);
		   		$xtpl->parse('main.row.columns');
		   		$i++;
	       }
			$xtpl->parse('main.row');
			$xtpl->assign('ERR', $err);
			$xtpl->parse('main');
			$xtpl->out('main');
		}
        
		public function admin_createpage($err, $page){
			$this->admin_head();
			$this->admin_left();
			$this->admin_right();
			$this->createpage_form($err, $page);
			$this->admin_foot();
		}
		
		public function deleteRecord($id=''){
			$menu_model = new menuModel();
			$res = $menu_model->deleteRecord($id);
		}
		
   }
?>