<?php   
	include_once('partnerModel.php');
	include_once('cmsController.php');
	include_once('imagehandler.php');
	class partnersController extends cmsController{
		
		public function __construct(){
			
		}
		
        public function index($pgno=''){
			$this->admin_head();
			$this->top_menu();
			$this->partnerslist($pgno);
			$this->admin_foot();
		}
		
		/**
		 * This will dynamically resize your image
		 */
		
		public function imageResize($width, $height, $target)
		{
			if (intval($width) > intval($height)) {
				$percentage = ($target / $width);
			} else {
				$percentage = ($target / $height);
			}
			
			//gets the new value and applies the percentage, then rounds the value
			$imageWidth = round($width * $percentage);
			$imageHeight = round($height * $percentage);	
			
			return array($imageWidth, $imageHeight);
		}



		
		public function partnerslist($pgno){
			$clrresult = '';
			$name = '';
			$url = '';
			if(count($_POST)){
				$name = $_POST['name'];
				$url = $_POST['url'];
				$clrresult = "<a href='".HOST."partners/'>Clear Result</a>";
			}
			$partner_model = new partnerModel();
			
			$res = $partner_model->getPartnersList('', $name, $url, HOST.'partners/index', $pgno);
			
			
			$pagelinks = $partner_model->getPagelinks();
			$xtpl = new Xtemplate("admin".DS."partnerslist.tpl");
			$max = count($res);
			$actimg = "<img src='".IMAGE."admin/status.gif' alt='Active' title='Active'>";
			$inactimg = "<img src='".IMAGE."admin/busy.gif' alt='Inactive' title='Inactive'>";
			if($max>0){
				for($rt=0;$rt<$max;$rt++){
						$partner_list = array(
								"NAME"=>$res[$rt]['name'],							
								"URL"=>$res[$rt]['url'],
								"LOGO"=>$res[$rt]['logo'],
								"STATUS"=>"<a href='".HOST."partners/partnerstatus/".$res[$rt]['id']."' onclick='return confirm(\"Are you sure you want to ".($res[$rt]['status']==1?'Inactivate':'Activate') ." this Partner? \")'>".($res[$rt]['status']==1?$actimg:$inactimg)."</a>",
								"EDIT"=>"<a href='".HOST."partners/add/".$res[$rt]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"DEL"=>"<a href='".HOST."partners/partnerdel/".$res[$rt]['id']."' onclick='return confirm(\" Are you sure you want to delete this Client?\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>"
						);
					
					$xtpl->assign('DATA',$partner_list);
					$xtpl->parse('main.row.columns');
					$i++;
			   } 	
			}else{
				$xtpl->assign('NORECORD', 'No record Found.');
			}
			foreach($_POST as $key =>$val){
				${$key} = htmlentities($val, ENT_QUOTES); 	
			}
			
			$xtpl->parse('main.row');
			$xtpl->assign('NAME', stripslashes($name));
			$xtpl->assign('URL', stripslashes($url));
			$xtpl->assign('PAGINATION', $pagelinks);
			$xtpl->assign('STYLE', STYLE.'admin/');
			$xtpl->assign('IMAGE', IMAGE.'admin/');
			$xtpl->assign('CLRRESULT', $clrresult);
			$xtpl->assign('HOST', HOST);
			$xtpl->assign('THUMB', THUMB);			
			$xtpl->parse('main');
			$xtpl->out('main');
		}
		
		public function add($id=''){
			$validation = new Validation();
			$imgHandler = new Imagehandler();
			$partner = new partnerModel();
			$arr = array();
			if(count($_POST)){
				$err = '';
				$fileInfo = '';
				$xtpl = new Xtemplate("admin".DS."partnerslist.tpl");
				$xtpl->assign('THUMB', THUMB);	
				
				$id = $_POST['id']?$_POST['id']:'';
				if($_POST['name'] == '') $err = "<br/> Company Name must not be blank.";
				elseif($partner->isNameExists($_POST['name'], $id)) $err .="<br/> Company Name already exists.";				
				elseif(strlen($_POST['name']) < 3) $err .="<br/> Company Name must be greater than three characters.";
				elseif ($_POST['name'] != ''  && !eregi('^[A-Za-z0-9 ?.-]{3,100}$', $_POST['name'])) $err .="<br/> Company Name must not contain any special characters.";				
				
				if($_POST['url'] == '') $err .= "<br/> URL must not be blank.";
				elseif(!($validation->validateUrl($_POST['url']))) $err .="<br/> Please enter a valid URL.";
				
				if(($id=='') && ($_FILES['logo']['name'] == '')) $err.="<br/> Logo Image must not be blank."; 
				if($_FILES['logo']['size'] > 2000000 ) $err.="<br/> The image size must be below 2MB.";
				if($_FILES['logo']['name'] !='') {
					$fileInfo = getimagesize($_FILES['logo']['tmp_name']);
					
					if ($fileInfo[2] != 2 && $fileInfo[2] != 3) $err.="<br/> This is not a valid JPG/PNG image.";
	
					// Get the resized value for Thumbs and Resize images
					$thumbSize = $this->imageResize ($fileInfo[0], $fileInfo[1], 150);	
					
				}
						
				
				if($_FILES['logo']['name'] != '' ){
					
					$directory = array();
					$directory['targetpath'] = "app/Pictures/";
					$directory['original'] = "app/Pictures/originals/";
					$directory['thumb_width'] = intval($thumbSize[0]);
					$directory['thumb_height'] = intval($thumbSize[1]);
					$directory['thumb'] = "app/Pictures/thumbs/";												
						do{
							$rand = rand(1, 10);
							$fname = substr(preg_replace(array('/0/', '/O/'), array('',''), strtoupper(md5(uniqid(microtime())))), 0,12);
							$fname = $fname.".jpg";							
							
							$result = $partner->isLogoExists($fname);			
							//var_dump($result);
							//$result = query("SELECT id FROM partners WHERE logo ='$fname' LIMIT 1");
						} while ($result == TRUE);
						
						$res = $imgHandler->uploadOriginals($_FILES['logo']['tmp_name'], $fname, $directory);									
					$exq = " logo='$fname' ,";
				}				
				
				if($err==''){					
					if($id!=''){
						$exq = "";
						if($_FILES['logo']['name']!=''){
							$exq = ", logo=:logo";
							$params = array(':name'=>$_POST['name'], ':url'=>$_POST['url'], ':id'=>$id, ':logo'=>$fname);	
						} else{
							$params = array(':name'=>$_POST['name'], ':url'=>$_POST['url'], ':id'=>$id);	
						}
						
						$sql = "UPDATE partners SET name=:name, url=:url ".$exq." WHERE id=:id";
						$res = $partner->updatePartnerData($sql, $params);
					}else{
						$values = array($_POST['name'], $_POST['url'], $fname, '1', date("Y-m-d H:i:s"));
						$fields = array('name', 'url', 'logo', 'status', 'created');
						$res = $partner->savePartnerData($values, $fields);
					}
					
					 header("Location: ".HOST."partners/");
				}
				$arr = $_POST;
			}
				
			if($id!=''){
				$res = $partner->getPartnersList($id);
				$arr = $res[0];
				$arr['logo'] = " <tr><td colspan='3'>&nbsp;</td></tr>
				<tr height='40'><td align='left'>&nbsp;</td><td align='left'>Current Logo&nbsp;: </td><td align='left'><img src='".THUMB.$arr['logo']."' alt='".$arr['name']."' title='".$arr['name']."'  /> </td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>";
			}
				
			$this->admin_head();
			$this->top_menu();			
			$this->partnersadd($err, $arr, $id);
			$this->admin_foot();
		}
		
		public function partnersadd($err, $arr=array(), $id){
			$xtpl = new Xtemplate("admin".DS."partneradd.tpl");
			$xtpl->assign("ID", $id);
			foreach($arr as $key =>$val){
				$xtpl->assign(strtoupper($key), $val);	
			}
			
			if($arr['image']==2){
				$xtpl->assign('ACCESSLEVEL2', "selected='selected'");
			}
			if($arr['accesslevel']==3){
				$xtpl->assign('ACCESSLEVEL3', "selected='selected'");
			}
			$xtpl->assign('IMAGE', IMAGE.'admin/');		
			$xtpl->assign('ERR', $err);
			$xtpl->parse('main');
			$xtpl->out('main');
		}
		
		public function partnerdel($id=''){
			if($id!=''){
				$user = new partnerModel();
				$user->deleteRecord($id);
			}
			header("Location: ".HOST."partners/");
		}
		
		public function partnerstatus($id=''){
			if($id!=''){
				$user = new partnerModel();
				$user->chageStatus($id);
			}
			header("Location: ".HOST."partners/");
		}
		
   }
?>