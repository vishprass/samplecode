<?
/**
  * File Name    : tstmny file (Admin Section).
  * Date Created : jun 15 2010    
  * Team         : Vibhors,vishnu
  * Contents     : Dispalying news 
  **/
?>
<?php
include_once("cmsController.php");
include_once("tstmnyModel.php");
include_once("cmsModel.php");
class tstmnyController extends cmsController{		
		public function __construct(){
		
		}
        
		public function index($id=''){
		if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'cms/');
			}
			$desc = '';
			$selected = '';
			$tmny = new tstmnyModel();
			
			if($id != ''){
				$res = $tmny->getTestiMonyDetail($id);
				if(count($res)>0){
					$selected = $res[0]['pageid'];
					$title = $res[0]['title'];
					$body = strip_tags($res[0]['body']); 
				}
			}
			if(count($_POST)){
			$body = trim(html_entity_decode(strip_tags($_POST['desc'])));
				$err = '';
				$id = $_POST['id']?$_POST['id']:'';
				if($_POST['title'] == '') $err .= "<br/> Title must not be blank.";
				if( $body == '') $err .= "<br/> Please enter content.";
			if($id==''){
				if($_FILES['image']['name'] == '') $err .= "<br/> Please upload an image.";
			}
			$ext = strtolower(array_pop(split("\.", $_FILES['image']['name']))); 
			if($ext!='jpg' && $ext!='png'&& $ext!='jpeg' && $ext!='') $err.="<br/> Please upload valid format";
				$desc = stripslashes($_POST['desc']);
				$title = $_POST['title'];
				//echo $_SERVER['DOCUMENT_ROOT']."vishnu"; die;
				$newpath = $_SERVER['DOCUMENT_ROOT']."/app/view/themes/media/images/news/thumbnails/";
				//echo  $_SERVER['REQUEST_URI']."-".$_SERVER['HTTP_HOST']."-".$_SERVER['REMOTE_ADDR']; die;
				//echo $_SERVER['HTTP_HOST']."/app/view/themes/media/images/news/";
				//echo realpath("./app/view/themes/media/images/news/"); die;
				if($err == '') {
					if($id == '') {
						$ext = strtolower(array_pop(split("\.", $_FILES['image']['name'])));
						if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						 $filename = substr(preg_replace(array('/0/', '/O/'), array('',''), strtoupper(md5(uniqid(microtime())))), 0,12);
						 move_uploaded_file($_FILES['image']['tmp_name'], "./app/view/themes/media/images/news/$filename.$ext");
						 $filename = $filename.".".$ext;
						 $path = "$filename";
						 $size = $_FILES['image']['size'];
						 $type = $_FILES['image']['type'];
						 $image_ext = $ext;
						}
						//die;
					$this->resizeImage(100,100, "./app/view/themes/media/images/news/thumbnails/".$filename, "./app/view/themes/media/images/news/$filename");
					
						$fields = array('pageid', 'title', 'body', 'created', 'status','image_path');
						$values = array(0, stripslashes(stripslashes($title)), strip_tags($body), date('Y-m-d H:i:s'), '1',$path);
						$tmny->savedate($fields, $values);
					}else{
					$ext = strtolower(array_pop(split("\.", $_FILES['image']['name']))); 
					
						if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif')
						{
						 $filename = substr(preg_replace(array('/0/', '/O/'), array('',''), strtoupper(md5(uniqid(microtime())))), 0,12);
						 move_uploaded_file($_FILES['image']['tmp_name'], "./app/view/themes/media/images/news/$filename.$ext");
						 $filename = $filename.".".$ext;
						 $path = "$filename";
						 $size = $_FILES['image']['size'];
						 $type = $_FILES['image']['type'];
						 $image_ext = $ext;
						 }
						 if($_FILES['image']['name']!='') {
						 $this->resizeImage(100,100, $_SERVER['DOCUMENT_ROOT']."./app/view/themes/media/images/news/thumbnails/".$filename, "./app/view/themes/media/images/news/$filename");
						
						 $res = $tmny->updateData(0,  stripslashes(stripslashes(strip_tags($body))),  stripslashes(stripslashes($title)), $_POST['id'],$path);
						} else
							$res = $tmny->updateDatanew(0,  stripslashes(stripslashes(strip_tags($body))), stripslashes(stripslashes($title)), $_POST['id']);
					 }
					header('Location:'.HOST.'tstmny/tstlst');
					exit;
				}
				}
			$this->admin_head();
			$this->top_menu();
			$cms = new cmsModel();
			$arr = $cms->getPageList();
	 		$res =  $this->createDropDown($arr, 'pageid', $selected, "style='width:260px'");
			$xtpl = new Xtemplate("admin".DS."tstmny.xtpl");
			$xtpl->assign('ERR', $err);
			$xtpl->assign('BODY', stripslashes($body));
			$xtpl->assign('PAGES', $res);
			$xtpl->assign('TITLE', $title);
			$xtpl->assign('ID', $id);	
			$xtpl->assign('IMAGE', IMAGE.'/admin/');
			$xtpl->parse('main');
			$xtpl->out('main');
			$this->admin_foot();
		}
		
		
	    public function createDropDown($arr, $name, $selected, $style){
	 		$k = "<SELECT id='$name' name='$name' $style>";
	 		$k .="<OPTION VALUE='0'>-- Select Page Name --</OPTION>";
	 		$cn = count($arr);
	 		for($i=0;$i<$cn;$i++){
				if($arr[$i]['id'] == $selected){
					$tmp = "selected='selected'";
				}else{
					$tmp = "";
				}
				$k .="<OPTION VALUE='".$arr[$i]['id']."' $tmp>".$arr[$i]['title']."</OPTION>";
	 		}
 	 		$k .="</SELECT>"; 
			return $k;
	   }
	   
	   
	   
	   public function tstlst( $pgno='', $search=''){
	   if(empty($_SESSION['username']))
			{
			header('Location:'.HOST.'cms/');
			}
	   		$pagename = '';
			$clrresult = '';
			
			$search = $title = isset($_POST['title'])?filter_var($_POST['title'],FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW):$search;
			
			$this->admin_head();
			$this->top_menu();
			$xtpl = new Xtemplate("admin".DS."tstmnylist.xtpl");
			$tmny = new tstmnyModel();
			$link =  HOST.'tstmny/tstlst';
			$append = !empty($search)? $search :'';
			if(!empty($append))	$clrresult = "<a href='".HOST."tstmny/tstlst'>Clear Result</a>";
			$search = filter_var($search, FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW);
			$res = $tmny->getTstmnyLists($search, $link, $pgno,$append);
			$pagelinks = $tmny->getPagelinks();
			$max  = count($res);
			if($max>0){
			
				for($e=0;$e<$max; $e++){	
				if($res[$e]['image_path']==''){$path="notAvailable.png";}else{$path=$res[$e]['image_path'];}
						$tst_list = array(
								"VIEW"=>"<a href='".IMAGE.'news/'.$path."' rel='lytebox[vacation]' ><img src='".IMAGE."admin/im.png' alt='Image' title='Image'></a>",
								"NAME"=>$res[$e]['title'],
								"CREATED"=>date("Y / m / d", strtotime($res[$e]['created'])),
								"EDIT"=>"<a href='".HOST.'tstmny/index/'.$res[$e]['id']."'><img src='".IMAGE."admin/vpedit.gif' alt='Edit' title='Edit'></a>",
								"DEL"=>"<a href='".HOST.'tstmny/delete/'.$res[$e]['id']."' onclick='return confirm(\" Are you sure you want to delete this record\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'></a>"
						);
					$xtpl->assign('DATA',$tst_list);
					$xtpl->parse('main.row.columns');
					$i++;
			   }
			}else{
				$xtpl->assign('NORECORD','No Record found.');
			}
			$xtpl->parse('main.row');
			foreach($_POST as $key =>$val){
			${$key} = htmlentities($val, ENT_QUOTES);
			$xtpl->assign(strtoupper($key), stripslashes(${$key}));	 	
	   }
			$xtpl->assign('IMAGE', IMAGE.'/admin/');
			$xtpl->assign('PAGINATION', $pagelinks);
			$xtpl->assign('CLRSULT', $clrresult);
			$xtpl->assign('TITLE', stripslashes($title));
			$xtpl->parse('main');
			$xtpl->out('main');
	   		$this->admin_foot();
	   }

		public function delete($id=''){
			$cmdl = new tstmnyModel();
			$cmdl->deleteRecord($id);
			header('Location: '.HOST.'tstmny/tstlst');
		}
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
}
?>