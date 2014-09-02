<?php
include_once('menuModel.php');
include_once('productModel.php');
include_once('tstmnyModel.php');
include_once('cmsModel.php');

class productdetailController extends baseController{

	public function index($id ='',$pgno ='',  $deleteError = false){ 

		$this->head();

		$this->product($id,$pgno,  $deleteError = false);
		
		$this->foot();
		$time_end = microtime(true);
		global $time_start;
		$time = $time_end -$time_start;
		//echo $time; 
	}
	
	public function head($title = '', $meta_keys = '', $meta_desc = ''){
		$cms = new cmsModel();
		$xtpl = new Xtemplate("users".DS."header.xtpl");
		$title = empty($title)? 'Biosfera': $title;
		$meta_desc = empty($meta_desc)? 'Biosfera': $meta_desc;
		$meta_keys = empty($meta_keys)? 'Biosfera': $meta_keys;
		$xtpl->assign('STYLE', STYLE.'users/');
		$xtpl->assign('SCRIPT', SCRIPT.'users/');
		$xtpl->assign('IMAGE', IMAGE.'users/');
		$xtpl->assign('TITLE', $title);
		$username=$_SESSION['username']?$_SESSION['username']:$_POST['username'];
		if ($username) $_SESSION['username'] = $username;
		$xtpl->assign("CLICK","<a href='".HOST."clientlogin'>".Login."</a>");
		if (isset($_SESSION['username'])) {
			$xtpl->assign('WELCOME',"<b><i>Bienvenido ".$_SESSION['username']."</b></i>");
			$xtpl->assign("LOG","Logout");
			$xtpl->assign("LOGOUTLINK",HOST."index/logout");
        } else {
			$xtpl->assign("LOG","Login");
			$xtpl->assign("LOGOUTLINK",HOST."clientlogin");
		}
		$xtpl->assign('META_DESC', $meta_desc);
		$xtpl->assign('META_KEYS', $meta_keys);
		$menumodel = new menuModel();
		$links = $menumodel->getPublishMenues('1', 'topmenu');
		$res=$cms->getpros();
		$max=count($res);
		for($i=0;$i<$max;$i++){
		$menu_list = array(
		  "NAME"=>"<a href='".HOST."productdetail/index/".$res[$i]['id']."'>".$res[$i]['name']."</a>"
		 
		 );
		        $xtpl->assign('DATA',$menu_list);
				$xtpl->parse('main.row');
		
		}
		
		$res1=$cms->getcatemenu();
		$max=count($res1);
		for($i=0;$i<$max;$i++){
		$menu_list = array(
		  "NAME"=>"<a href='".HOST."categoriesview/index/".$res1[$i]['id']."'>".$res1[$i]['name']."</a>"
		 
		 );
		        $xtpl->assign('DATA',$menu_list);
				$xtpl->parse('main.abc');
		
		}
		$xtpl->assign('TOPMENU', $links);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	public function product($id='', $deleteError = 'delete' )
	{
				
		$cms = new cmsModel();
		$xtpl = new Xtemplate("users".DS."productdetail.xtpl");
		$product = new productModel();
		$res = $product->getProductData($id);
		if($res['image']==''){$path="notAvailable.gif";}else{$path=$res['image'];}
			$product_list1 = array(
			"ID"=>$res['id'],
			"PRODUCT_NAME"=>$res['name'],
			"DESCRIPTION"=>$res['description'],
			"LONG_DESCRIPTION"=>$res['longdescription'],
			"IMAGE1"=>$res['img'],
			"CATEGORY"=>$res['catname'],
			"PRICE"=>$res['price'],
			"CODE"=>$res['code'],
			"VIEW"=> IMAGE.'products/original/'.$path,
			"CROP"=> IMAGE.'products/cropped/'.$path
//								
		);
						//print_r($product_list1);
			$xtpl->assign('DATA',$product_list1);
			$xtpl->parse('main.aaa');




$word="buildings";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE1"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA1',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE1"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA1',$cates_li);
		  }
		
		$word="cleaning";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE2"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA2',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE2"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA2',$cates_li);
		  }
		
		$word="coffee";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE3"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA3',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE3"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA3',$cates_li);
		  }
		
		$word="insurance";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE4"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA4',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE4"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA4',$cates_li);
		  }
		
		
		$word="materials";
		$res1=$cms->getcate1ink($word);
		$res2=$cms->getcatelink2($res1[0]['id']);
		if(count($res2)!=0){
		$cates_li = array(
		"CATE5"=>HOST."categoriesview/index/".$res1[0]['id']
		);
		  $xtpl->assign('DATA5',$cates_li);
	     }
		 else{
		 $cates_li = array(
		"CATE5"=>HOST."productview/index/".$res1[0]['id']
		 );
		  $xtpl->assign('DATA5',$cates_li);
		  }




		$xtpl->assign('IMAGES', IMAGE.'users/');
		$xtpl->assign('HOST', HOST);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	
	
	
	
	
	
	
	public function foot( $analytics = ''){
		$xtpl = new Xtemplate("users".DS."footer.xtpl");
		$xtpl->assign('IMAGE', IMAGE.'users/');
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	public function topmenu(){
		$xtpl = new Xtemplate("users".DS."topmenu.xtpl");
		$menumodel = new menuModel();
		$links = $menumodel->getPublishMenues('1', 'topmenu');
		$xtpl->assign('TOPMENU', $links);
		$xtpl->assign('HOST', HOST);
		$xtpl->parse('main');
		$xtpl->out('main');
	}
	
	
}
?>