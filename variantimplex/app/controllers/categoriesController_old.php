<?php   
	include_once('categoryModel.php');
	include_once('cmsController.php');
	class categoriesController extends cmsController{
		
		public function __construct(){
			
		}
        public function index($pgno ='', $deleteError = false){
			$this->admin_head();
			$this->top_menu();
			$this->categorieslist($pgno, $deleteError);
			$this->admin_foot();
		}
		public function categorieslist($pgno, $deleteError = 'delete'){
			$clrresult = '';
			$name = '';
			$description = '';
			if(count($_POST)){
				$name = $_POST['name'];
				$description = $_POST['description'];
				$parent = $_POST['parent'];
				$clrresult = "<a href='".HOST."categories/'>Clear Result</a>";
			}
			$cat_model = new categoryModel();
			$res = $cat_model->getCategoriesList('','', $name, $description, $parent, HOST.'categories/index', $pgno);
		
			$pagelinks = $cat_model->getPagelinks();
			$xtpl = new Xtemplate("admin".DS."categorieslist.xtpl");
			$max = count($res);
			$actimg = "<img src='".IMAGE."admin/status.gif' alt='Active' title='Active'>";
			$inactimg = "<img src='".IMAGE."admin/busy.gif' alt='Inactive' title='Inactive'>";
			if($max>0){
				for($rt=0;$rt<$max;$rt++){
				if($res[$rt]['parent']==0){
						$cate_list = array(
								"NAME"=>$res[$rt]['name'],
								"DESCRIPTION"=>$res[$rt]['description'],
								"EMAIL"=>$res[$rt]['email'],
								"STATUS"=>"<a href='".HOST."categories/categorystatus/".$res[$rt]['id']."' onclick='return confirm(\"Are you sure you want to ".($res[$rt]['status']==1?'Inactivate':'Activate') ." this Category? \")'>".($res[$rt]['status']==1?$actimg:$inactimg)."</a>",
								"EDIT"=>"<a href='".HOST."categories/add/".$res[$rt]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"DEL"=>"<a href='".HOST."categories/categorydel/".$res[$rt]['id']."' onclick='return confirm(\" Are you sure you want to delete this record ?\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>"
						);
					
					$xtpl->assign('DATA',$cate_list);
					$xtpl->parse('main.row.columns');
					$i++;
			
			    $res1=$cat_model->getCategoriesList('',$res[$rt]['id'], $name, $description, $parent, HOST.'categories/index', $pgno);
				$j=0;
				$max1=count($res1);
				while($j<$max1)
				{
				    $cate_list = array(
								"NAME"=>" &nbsp;-".$res1[$j]['name'],
								"DESCRIPTION"=>$res1[$j]['description'],
								"EMAIL"=>$res1[$j]['email'],
								"STATUS"=>"<a href='".HOST."categories/categorystatus/".$res1[$j]['id']."' onclick='return confirm(\"Are you sure you want to ".($res1[$j]['status']==1?'Inactivate':'Activate') ." this Category? \")'>".($res1[$j]['status']==1?$actimg:$inactimg)."</a>",
								"EDIT"=>"<a href='".HOST."categories/add/".$res1[$j]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"DEL"=>"<a href='".HOST."categories/categorydel/".$res1[$j]['id']."' onclick='return confirm(\" Are you sure you want to delete this record ?\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>"
						);
					$xtpl->assign('DATA',$cate_list);
					$xtpl->parse('main.row.columns');
				  $j++;
				}
				} else {
				/*****************new code****************************************/
				$cate_list = array(
								"NAME"=>$res[$rt]['name'],
								"DESCRIPTION"=>$res[$rt]['description'],
								"EMAIL"=>$res[$rt]['email'],
								"STATUS"=>"<a href='".HOST."categories/categorystatus/".$res[$rt]['id']."' onclick='return confirm(\"Are you sure you want to ".($res[$rt]['status']==1?'Inactivate':'Activate') ." this Category? \")'>".($res[$rt]['status']==1?$actimg:$inactimg)."</a>",
								"EDIT"=>"<a href='".HOST."categories/add/".$res[$rt]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"DEL"=>"<a href='".HOST."categories/categorydel/".$res[$rt]['id']."' onclick='return confirm(\" Are you sure you want to delete this record ?\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>"
						);
					$xtpl->assign('DATA',$cate_list);
					$xtpl->parse('main.row.columns');
					$i++;
			    $res1=$cat_model->getCategoriesList('',$res[$rt]['id'], $name, $description, $parent, HOST.'categories/index', $pgno);
				$j=0;
				$max1=count($res1);
				while($j<$max1)
				{
				    $cate_list = array(
								"NAME"=>" &nbsp;-".$res1[$j]['name'],
								"DESCRIPTION"=>$res1[$j]['description'],
								"EMAIL"=>$res1[$j]['email'],
								"STATUS"=>"<a href='".HOST."categories/categorystatus/".$res1[$j]['id']."' onclick='return confirm(\"Are you sure you want to ".($res1[$j]['status']==1?'Inactivate':'Activate') ." this Category? \")'>".($res1[$j]['status']==1?$actimg:$inactimg)."</a>",
								"EDIT"=>"<a href='".HOST."categories/add/".$res1[$j]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"DEL"=>"<a href='".HOST."categories/categorydel/".$res1[$j]['id']."' onclick='return confirm(\" Are you sure you want to delete this record ?\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>"
						);
					
					$xtpl->assign('DATA',$cate_list);
					$xtpl->parse('main.row.columns');
				  
				  
				  $j++;
				}
				/*****************end new code*************************************/	
					
				}
			   }	
			}else{
				$xtpl->assign('NORECORD', 'No record Found.');
			}
			foreach($_POST as $key =>$val){
				${$key} = htmlentities($val, ENT_QUOTES); 	
			}
			
			$xtpl->parse('main.row');
			$xtpl->assign('NAME', stripslashes($name));
			$xtpl->assign('DESCRIPTION', stripslashes($description));
			switch($deleteError){
				case 'updated':
					$xtpl->assign('ERROR', "Category information has been updated succesfully");
					$xtpl->assign('ERROR_COLOR', "green");
					break;
				case 'added':
					$xtpl->assign('ERROR', "Category has been added successfully");
					$xtpl->assign('ERROR_COLOR', "green");
					break;			
			}
			$xtpl->assign('PAGINATION', $pagelinks);
			$xtpl->assign('STYLE', STYLE.'admin/');
			$xtpl->assign('IMAGE', IMAGE.'admin/');
			$xtpl->assign('CLRRESULT', $clrresult);
			$xtpl->assign('HOST', HOST);
			$xtpl->parse('main');
			$xtpl->out('main');
		}
		
		public function add($id=''){
		    $validation = new Validation();
			$category = new categoryModel();
			$arr = array();
			if(count($_POST)){
				$id = $_POST['id']?$_POST['id']:'';
				if($_POST['name'] == '') $err = "<br/> Name must not be blank.";
			    if($_POST['description'] == '') $err .= "<br/> Please enter the description.";
				if($err == '') {
					if($id!=''){
					$params = array(':name'=>stripslashes($_POST['name']), ':description'=>stripslashes($_POST['description']), ':id'=>$id);
						$sql = "UPDATE categories SET name=:name, description=:description WHERE id=:id";
						$res = $category->updateCategoryData($sql, $params);
							header("Location: ".HOST."categories/index/1/updated");
						exit;
					} else {
						$values = array( $_POST['subcates'], stripslashes($_POST['description']), stripslashes($_POST['name']), '1', date("Y-m-d H:i:s"));
					    $fields = array( 'parent', 'description', 'name', 'status', 'created');
						$res = $category->saveCategoryData($values, $fields);
						header("Location: ".HOST."categories/index/1/added");
						exit;
					}
				}
				$arr = $_POST;
			}
			if($id!=''){
				$res = $category->getCategoryData($id);
				$arr = $res;
			}
			$this->admin_head();
			$this->top_menu();			
			$this->categoriesadd($err, $arr);
			$this->admin_foot();
		}
		public function categoriesadd($err, $arr=array()){
			$xtpl = new Xtemplate("admin".DS."categoryadd.xtpl");
			foreach($arr as $key =>$val){
				$xtpl->assign(strtoupper($key), stripslashes($val));	
			}
			if($arr['accesslevel']==2){
				$xtpl->assign('ACCESSLEVEL2', "selected='selected'");
			}
			if($arr['accesslevel']==3){
				$xtpl->assign('ACCESSLEVEL3', "selected='selected'");
			}
			$xtpl->assign('IMAGE', IMAGE.'admin/');	
			$category_model=new categoryModel();
	        $res = $category_model->getParentMenus($sel);
			$xtpl->assign('CATSEL',$res);
			$xtpl->assign('ERR', $err);
			$xtpl->parse('main');
			$xtpl->out('main');
		}
		public function categorydel($id=''){
			$error = array();
			if($id!=''){
				$category = new categoryModel();
				$error = $category->deleteRecord($id);
			}
			if(count($error) ==0){
				header("Location: ".HOST."categories/");
			} else {
				header("Location: ".HOST."categories/index/1/delete");
			}
		}
		public function categorystatus($id=''){
			if($id!=''){
				$category = new categoryModel();
				$category->chageStatus($id);
			}
			header("Location: ".HOST."categories/");
		}
   }
?>
