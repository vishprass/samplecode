<?
 /**
  * File Name    : categories file (Admin Section).
  * Date Created : jun 15 2010    
  * Team         : Vibhors,vishnu
  * Contents     : Dispalying and adding categories 
  **/ 
  ?>
<?php   
	include_once('categoryModel.php');
	include_once('cmsController.php');
	class categoriesController extends cmsController{
		public function __construct(){
			
		}
        public function index($pgno ='', $deleteError = false){
			if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'cms/');
			}
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
				$search1 = "p=".$name;
       			$search2 = "t=".$description;
				$clrresult = "<a href='".HOST."categories/'>Clear Result</a>";
			}
			
			
			
			$append = '';
		if(!empty($search1) && !empty($search2)){
			$append = $search1."/".$search2;
		
			$clrresult = "<a href='".HOST."categories'>Clear Result</a>";
		}else if (!empty($search1) && empty($search2)){
			$append = $search1;
			$clrresult = "<a href='".HOST."categories'>Clear Result</a>";
		}else if (empty($search1) && !empty($search2)){
			$append = $search2;
			$clrresult = "<a href='".HOST."categories'>Clear Result</a>";
		}else{
			$append = "";
		}
		//echo $append;
		$p = explode("=", $search1);
		//print_r($p);
		$q = explode("=",$search2);
		//print_r($q);
		$name = isset($p['1'])?filter_var($p['1'],FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW):'';
	//	echo $pname;
		$description = isset($q['1'])?filter_var($q['1'],FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW):'';	
			
			
			
			$cat_model = new categoryModel();
			$res = $cat_model->getCategoriesList('','', $name, $description, $parent, HOST.'categories/index', $pgno,$append);
		
			$pagelinks = $cat_model->getPagelinks();
			$xtpl = new Xtemplate("admin".DS."categorieslist.xtpl");
			$max = count($res);
			$actimg = "<img src='".IMAGE."admin/status.gif' alt='Active' title='Active'>";
			$inactimg = "<img src='".IMAGE."admin/busy.gif' alt='Inactive' title='Inactive'>";
			if($max>0){
				for($rt=0;$rt<$max;$rt++){
				if($res[$rt]['image_path']==''){$path="notAvailable.png";}else{$path=$res[$rt]['image_path'];}
				if($res[$rt]['parent']==0){
						$cate_list = array(
								"NAME"=>$res[$rt]['name'],
								"DESCRIPTION"=>$res[$rt]['description'],
								"EMAIL"=>$res[$rt]['email'],
								"STATUS"=>"<a href='".HOST."categories/categorystatus/".$res[$rt]['id']."' onclick='return confirm(\"Are you sure you want to ".($res[$rt]['status']==1?'Inactivate':'Activate') ." this Category? \")'>".($res[$rt]['status']==1?$actimg:$inactimg)."</a>",
								"EDIT"=>"<a href='".HOST."categories/add/".$res[$rt]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"VIEW"=>"<a href='".IMAGE.'categories/'.$path."' rel='lytebox[vacation]' ><img src='".IMAGE."admin/im.png' alt='Image' title='Image'></a>",
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
				if($res1[$j]['image_path']==''){$path="notAvailable.png";}else{$path=$res1[$j]['image_path'];}
				    $cate_list = array(
								"NAME"=>" &nbsp;-".$res1[$j]['name'],
								"DESCRIPTION"=>$res1[$j]['description'],
								"EMAIL"=>$res1[$j]['email'],
								"STATUS"=>"<a href='".HOST."categories/categorystatus/".$res1[$j]['id']."' onclick='return confirm(\"Are you sure you want to ".($res1[$j]['status']==1?'Inactivate':'Activate') ." this Category? \")'>".($res1[$j]['status']==1?$actimg:$inactimg)."</a>",
								"EDIT"=>"<a href='".HOST."categories/add/".$res1[$j]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"VIEW"=>"<a href='".IMAGE.'categories/'.$path."' rel='lytebox[vacation]' ><img src='".IMAGE."admin/im.png' alt='Image' title='Image'></a>",
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
								"VIEW"=>"<a href='".IMAGE.'categories/'.$path."' rel='lytebox[vacation]' ><img src='".IMAGE."admin/imageIcon.gif' alt='Image' title='Image'></a>",
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
				if($res1[$j]['image_path']==''){$path="notAvailable.png";}else{$path=$res1[$j]['image_path'];}
				    $cate_list = array(
								"NAME"=>" &nbsp;-".$res1[$j]['name'],
								"DESCRIPTION"=>$res1[$j]['description'],
								"EMAIL"=>$res1[$j]['email'],
								"STATUS"=>"<a href='".HOST."categories/categorystatus/".$res1[$j]['id']."' onclick='return confirm(\"Are you sure you want to ".($res1[$j]['status']==1?'Inactivate':'Activate') ." this Category? \")'>".($res1[$j]['status']==1?$actimg:$inactimg)."</a>",
								"VIEW"=>"<a href='".IMAGE.'categories/'.$path."' rel='lytebox[vacation]' ><img src='".IMAGE."admin/imageIcon.gif' alt='Image' title='Image'></a>",
								"EDIT"=>"<a href='".HOST."categories/add/".$res1[$j]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"DEL"=>"<a href='".HOST."categories/categorydel/".$res1[$j]['id']."' onclick='return confirm(\" Are you sure you want to delete this record ?\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>"
						);
					
					$xtpl->assign('DATA',$cate_list);
					$xtpl->parse('main.row.columns');
				  
				  
				  $j++;
				}
				/*****************end new code*************************************/	
				/*****
				
				added "VIEW"=>"<a href='".IMAGE.'categories/'.$res1[$j]['image_path']."' rel='lytebox[vacation]' ><img src='".IMAGE."admin/imageIcon.gif' alt='Image' title='Image'></a>", in all
				******/
					
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
		if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'cms/');
			}
		
		    $validation = new Validation();
			$category = new categoryModel();
			$arr = array();
			if(count($_POST)){
				$id = $_POST['id']?$_POST['id']:'';
				if($_POST['name'] == '') $err = "<br/> Name must not be blank.";
			    if($_POST['description'] == '') $err .= "<br/> Please enter the description.";
				$ext = strtolower(array_pop(split("\.", $_FILES['image']['name']))); 
			if($ext!='jpg' && $ext!='png'&& $ext!='jpeg' && $ext!='') $err.="<br/> Please upload valid format";
			
				
				if($err == ''){
				
					if($id!=''){
					
					/********************************************************************************************/
					$ext = strtolower(array_pop(split("\.", $_FILES['image']['name']))); 
					
						if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif')
						{
						 $filename = substr(preg_replace(array('/0/', '/O/'), array('',''), strtoupper(md5(uniqid(microtime())))), 0,12);
						 move_uploaded_file($_FILES['image']['tmp_name'], "./app/view/themes/media/images/categories/$filename.$ext");
						
						 $filename = $filename.".".$ext;
						 $path = "$filename";
						 $size = $_FILES['image']['size'];
						 $type = $_FILES['image']['type'];
						 $image_ext = $ext;
	
						}
						if($_FILES['image']['name']!='') {
					$this->resizeImage(100,100, "./app/view/themes/media/images/categories/thumbnails/".$filename, "./app/view/themes/media/images/categories/$filename");
					$params = array(':name'=>stripslashes(stripslashes($_POST['name'])), ':description'=>stripslashes(stripslashes(strip_tags($_POST['description']))), ':id'=>$id,':path'=>$path);
					
					$sql = "UPDATE categories SET name=:name, description=:description,image_path=:path WHERE id=:id";
					/***********************************************************************************************/
					}
					else {
					$params = array(':name'=>stripslashes(stripslashes($_POST['name'])), ':description'=> stripslashes(stripslashes(strip_tags($_POST['description']))), ':id'=>$id,':path'=>$path);
					
						$sql = "UPDATE categories SET name=:name, description=:description,image_path=:path WHERE id=:id";}
						$res = $category->updateCategoryData($sql, $params);
						
							header("Location: ".HOST."categories/index/1/updated");
						
						exit;
					}else{
					
					/*****************************ADDED FOR UPLODED IMAGE*****************************/
					
					$ext = strtolower(array_pop(split("\.", $_FILES['image']['name']))); 
					
						if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif')
						{
						 $filename = substr(preg_replace(array('/0/', '/O/'), array('',''), strtoupper(md5(uniqid(microtime())))), 0,12);
						 move_uploaded_file($_FILES['image']['tmp_name'], "./app/view/themes/media/images/categories/$filename.$ext");
						
						 $filename = $filename.".".$ext;
						 $path = "$filename";
						 $size = $_FILES['image']['size'];
						 $type = $_FILES['image']['type'];
						 $image_ext = $ext;
	
						}
					$this->resizeImage(100,100, "./app/view/themes/media/images/categories/thumbnails/".$filename, "./app/view/themes/media/images/categories/$filename");
					
						$values = array( $_POST['subcates'], stripslashes(stripslashes(strip_tags($_POST['description']))), stripslashes(stripslashes($_POST['name'])), '1', date("Y-m-d H:i:s"),$path);
					  
					    $fields = array( 'parent', 'description', 'name', 'status', 'created','image_path');
						$res = $category->saveCategoryData($values, $fields);
						/*****************************END ADDED FOR UPLODED IMAGE*************************/
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
			}else{
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
		
		
		/*******************newly added**************************/
		
	public function	resizeImage($ow, $oh, $path, $opath){
			list($width, $height)= getimagesize($opath);
			$src = @imagecreatefromjpeg($opath);
			if(!$src) $src = @imagecreatefrompng($opath);
			if(!$src) $src = @imagecreatefromwbmp($opath);
			if(!$src) $src = @imagecreatefromxbm($opath);
			if(!$src) $src = @imagecreatefromxpm($opath);
			if(!$src) $src = @imagecreatefromgif($opath);
			$nw = $ow; $nh = $oh;
			$dw = $width / $nw; $dh = $height / $nh;
			if ( $dw > $dh )
				$nw = $nh * $width / $height;
			else
				$nh = $nw * $height / $width;
			$mx = 1;
			$nh *= $mx; $nw *= $mx;
			$nx = ($nw - $ow) / 2;
			$ny = ($nh - $oh) / 2;
			$dest = imagecreatetruecolor($ow, $oh);
			imageantialias($dest, TRUE);
			$bg = imagecreatetruecolor($nw, $nh);
			imageantialias($dest, TRUE);
			imagecopyresampled($bg, $src, 0, 0, 0, 0, $nw, $nh, $width, 

$height);
			imagecopy($dest, $bg, 0, 0, $nx, $ny, $ow, $oh);
			imagejpeg($dest, $path, 80);
	}


		/****************************ends newly added*********************/
		
		
   }
?>