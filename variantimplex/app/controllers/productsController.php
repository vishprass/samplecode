<?php
	include_once('productModel.php');
	include_once('cmsController.php');
	class productsController extends cmsController {
		
		public function __construct(){
			
		}
		
        public function index($pgno ='', $deleteError = false){
		if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'cms/');
			}
			$this->admin_head();
			$this->top_menu();
			$this->productslist($pgno, $deleteError);
			$this->admin_foot();
		}
		public function productslist($pgno, $deleteError = 'delete') {
			$clrresult = '';
			$name = '';
			$description = '';
			$accesslevel = '';
			
			if(count($_POST)){
				$name = $_POST['name'];
				$description = $_POST['description'];
				$accesslevel = $_POST['accesslevel'];
				$search1 = "p=".$name;
			    $search2 = "t=".$description;
				$clrresult = "<a href='".HOST."products/'>Clear Result</a>";
			}
			
			
			$append = '';
		if(!empty($search1) && !empty($search2)){
			$append = $search1."/".$search2;
		
			$clrresult = "<a href='".HOST."products'>Clear Result</a>";
		}else if (!empty($search1) && empty($search2)){
			$append = $search1;
			$clrresult = "<a href='".HOST."products'>Clear Result</a>";
		}else if (empty($search1) && !empty($search2)){
			$append = $search2;
			$clrresult = "<a href='".HOST."products'>Clear Result</a>";
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
			
			
			
			$product_model = new productModel();
			$res = $product_model->getProductList('', $name, $description, $accesslevel, HOST.'products/index', $pgno,$append);
			$pagelinks = $product_model->getPagelinks();
			$xtpl = new Xtemplate("admin".DS."productslist.xtpl");
			$max = count($res);
			$actimg = "<img src='".IMAGE."admin/status.gif' alt='Active' title='Active'>";
			$inactimg = "<img src='".IMAGE."admin/busy.gif' alt='Inactive' title='Inactive'>";
			if($max>0) {
				for($rt=0;$rt<$max;$rt++){
					$cate=explode(':',$res[$rt]['catname']);
						$product_list = array(
								"NAME"=>stripslashes($res[$rt]['name']),
								"DESCRIPTION"=>stripslashes($res[$rt]['description']),
								"PRICE"=>stripslashes(number_format($res[$rt]['price'], 2)),
								"CATEGORY"=>$res[$rt]['catname'],
								"IMAGE"=>$res[$rt]['image'],
								"STATUS"=>"<a href='".HOST."products/productstatus/".$res[$rt]['id']."' onclick='return confirm(\"Are you sure you want to ".($res[$rt]['status']==1?'Inactivate':'Activate') ." this User? \")'>".($res[$rt]['status']==1?$actimg:$inactimg)."</a>",
								"EDIT"=>"<a href='".HOST."products/add/".$res[$rt]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"DEL"=>"<a href='".HOST."products/productdel/".$res[$rt]['id']."' onclick='return confirm(\" Are you sure you want to delete this record ?\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>",
								"VIEW"=>"<a href='".IMAGE.'products/original/'.$res[$rt]['img']."' rel='lytebox[vacation]' ><img src='".IMAGE."admin/im.png' alt='Image' title='Image'></a>");
					$xtpl->assign('DATA',$product_list);
					$xtpl->parse('main.row.columns');
					$i++;
			   }
			} else {
				$xtpl->assign('NORECORD', 'No record Found.');
			}
			foreach($_POST as $key =>$val){
				${$key} = htmlentities($val, ENT_QUOTES); 	
			}
			
			$xtpl->parse('main.row');
			$xtpl->assign('NAME', stripslashes($name));
			$xtpl->assign('DESCRIPTION', stripslashes($description));
			switch($deleteError){
				case 'delete':
					$xtpl->assign('ERROR', "Admin user cannot be deleted");
					$xtpl->assign('ERROR_COLOR', "red");
					break;
				case 'password':
					$xtpl->assign('ERROR', "Password has been modified successfully");
					$xtpl->assign('ERROR_COLOR', "green");
					break;
				case 'updated':
					$xtpl->assign('ERROR', "Product details has been updated succesfully");
					$xtpl->assign('ERROR_COLOR', "green");
					break;
				case 'added':
					$xtpl->assign('ERROR', "Product has been added successfully");
					$xtpl->assign('ERROR_COLOR', "green");
					break;			
			}
			if($deleteError=''){
				$xtpl->assign('ERROR', "Admin user cannot be deleted");
			}
			
			
			$xtpl->assign('PAGINATION', $pagelinks);
			$xtpl->assign('STYLE', STYLE.'admin/');
			//$xtpl->assign('IMAGE', IMAGE.'admin/');
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
			$product = new productModel();
			$arr = array();
		//	echo $id;
				foreach($_POST['category'] as $k=>$v) {
                	$cate .= $v.':';
                }
				$cate = chop($cate,':');
		if(count($_POST)){
				$err = '';
			    $id = $_POST['id']?$_POST['id']:'';
				if($_POST['name'] == '') $err = "<br/> Name must not be blank.";
				elseif(!eregi("[A-Z,a-z]", $_POST['name'])) $err = "<br/> Name should be A-Z.";
//				if($_POST['accesslevel'] == '') $err .= "<br/> Access Level must not be blank.";
				if($_POST['category']=='') $err .="<br/> Please select the category.";
				if($_POST['price'] == '') $err .= "<br/> Price must not be blank.";
				if($_POST['description']=='') $err .="<br/> Description must not be blank.";
				if($_POST['code']=='') $err .="<br/>  Product Code must not be blank.";
				elseif($product->isCodeExists($_POST['code'], $id)) $err .="<br/> Code already exists.";
				elseif(strlen($_POST['code']) < 2 || strlen($_POST['code']) > 12) $err .="<br/> Code must be between 2 and 12 digits.";
				$ext = strtolower(array_pop(split("\.", $_FILES['image']['name']))); 
			if($ext!='jpg' && $ext!='png'&& $ext!='jpeg' ) $err.="<br/> Please upload valid format";
				//elseif(strlen($_POST['code']) > 12) $err .="<br/> Code must be less than twelve(12) digits.";
				if($err == ''){
				$name = isset($_POST['name']) ? filter_var($_POST['name'],FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW): '';
				//echo "test".$_POST[id];
				  $id = $_POST['id']?$_POST['id']:'';
				
					if($id!='') {
						$ext = strtolower(array_pop(split("\.", $_FILES['image']['name'])));
						if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						 $filename = substr(preg_replace(array('/0/', '/O/'), array('',''), strtoupper(md5(uniqid(microtime())))), 0,12);
						 move_uploaded_file($_FILES['image']['tmp_name'], "./app/view/themes/media/images/products/original/$filename.$ext");
						 //$cms_model->resizeImage(854,83, "./app/view/themes/media/images/products/$filename.$ext", $_FILES['footerImage']['tmp_name'],$ext);
						 $filename = $filename.".".$ext;
						 $path = "$filename";
						 $size = $_FILES['image']['size'];
						 $type = $_FILES['image']['type'];
						 $image_ext = $ext;
							$this->resizeImage(60,60, "./app/view/themes/media/images/products/thumbnails/".$filename, "./app/view/themes/media/images/products/original/$filename");
							$this->resizeImage(221,227, "./app/view/themes/media/images/products/cropped/".$filename, "./app/view/themes/media/images/products/original/$filename");
							$params = array(':name'=>$name, ':description'=>strip_tags($_POST['description']), ':longdescription'=>strip_tags($_POST['longdescription']),':image'=>$path, ':price'=>strip_tags($_POST['price']), ':code'=>strip_tags($_POST['code']),':category'=>$cate,':id'=>$id);
							$sql = "UPDATE products SET name=:name, description=:description, longdescription=:longdescription, image=:image, price=:price, code=:code, category=:category ".$exq." WHERE id=:id";
						} else {
							$params = array(':name'=>$name, ':description'=>strip_tags($_POST['description']), ':longdescription'=>strip_tags($_POST['longdescription']),':price'=>strip_tags($_POST['price']), ':code'=>strip_tags($_POST['code']),':category'=>$cate, ':id'=>$id);
							$sql = "UPDATE products SET name=:name, description=:description, longdescription=:longdescription, price=:price, code=:code, category=:category ".$exq." WHERE id=:id";
						}
						$res = $product->updateProductData($sql, $params);
						header("Location: ".HOST."products/index/1/updated");
						exit;
					} else {
						$ext = strtolower(array_pop(split("\.", $_FILES['image']['name'])));
						if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						 $filename = substr(preg_replace(array('/0/', '/O/'), array('',''), strtoupper(md5(uniqid(microtime())))), 0,12);
						 move_uploaded_file($_FILES['image']['tmp_name'], "./app/view/themes/media/images/products/original/$filename.$ext");
						 //$cms_model->resizeImage(854,83, "./app/view/themes/media/images/products/$filename.$ext", $_FILES['footerImage']['tmp_name'],$ext);
						 $filename = $filename.".".$ext;
						 $path = "$filename";
						 $size = $_FILES['image']['size'];
						 $type = $_FILES['image']['type'];
						 $image_ext = $ext;
						}
						$this->resizeImage(60,60, "./app/view/themes/media/images/products/thumbnails/".$filename, "./app/view/themes/media/images/products/original/$filename");
						$this->resizeImage(221,227, "./app/view/themes/media/images/products/cropped/".$filename, "./app/view/themes/media/images/products/original/$filename");
						$values = array($_POST['name'], strip_tags($_POST['description']),strip_tags($_POST['longdescription']), $path, strip_tags($_POST['price']), $cate, strip_tags($_POST['code']) , date("Y-m-d H:i:s"),1);
					    $fields = array('name', 'description', 'longdescription', 'image', 'price', 'category' , 'code' , 'created','status');
						$res = $product->saveProductData($values, $fields);
						header("Location: ".HOST."products/index/1/added");
						exit;
					}
				}
				$arr = $_POST;
			}
			if($id!=''){
				$res = $product->getProductList1($id);
				//print_r($res);
				$arr = $res[0];
				$arr['password'] = '';
			}
			$this->admin_head();
			$this->top_menu();
			$this->productsadd($err, $arr);
			$this->admin_foot();
		}
		
		public function productsadd($err, $arr=array()) {
			$product_model = new productModel();
			$xtpl = new Xtemplate("admin".DS."productadd.xtpl");
			foreach($arr as $key =>$val){
				$xtpl->assign(strtoupper($key), stripslashes($val));
			}
			$sel2 = explode(":", $arr['category']);
			$res = $product_model->getCategoryMenus($sel2);
			//print_r ($res);
			$xtpl->assign('CATEGORY',$res);
			$xtpl->assign('IMAGE', IMAGE.'admin/');
			$xtpl->assign('ERR', $err);
			$xtpl->parse('main');
			$xtpl->out('main');
		}
		public function productdel($id='') {
			$error = array();
			if($id!=''){
				$product = new productModel();
				$error = $product->deleteRecord($id);
			}
			if(count($error) ==0){
				header("Location: ".HOST."products/");
			}else{
				header("Location: ".HOST."products/index/1/delete");
			}
		}
		
		public function productstatus($id=''){
			if($id!=''){
				$product = new productModel();
				$product->chageStatus($id);
			}
			header("Location: ".HOST."products/");
		}
		
		//***********************************************************************************
		
			
			public function	resizeImage($ow, $oh, $path, $opath){
			
			//echo"$path";die;
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
			imagecopyresampled($bg, $src, 0, 0, 0, 0, $nw, $nh, $width, $height);
			imagecopy($dest, $bg, 0, 0, $nx, $ny, $ow, $oh);
			imagejpeg($dest, $path, 80);
	}


		


		//***********************************************************************************
		
		
		
		
		
		
   }
?>
