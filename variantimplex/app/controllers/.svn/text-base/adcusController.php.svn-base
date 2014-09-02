<?php
    include_once("cmsController.php");
	include_once("contactModel.php");
	class adcusController extends cmsController{
		
		public function __construct(){
				
		}
		
		
        public function index( $pgno='' ){
			$pagename = '';
			$clrresult = '';
			if(count($_POST)){
				$name = $_POST['name'];
				$email = $_POST['email'];
				$clrresult = "<a href='".HOST."adcus/'>Clear Result</a>";
			}
	   		$this->admin_head();
			$this->top_menu();
			$cmdl = new contactModel();
			$res = $cmdl->getContactusList($name, $email,  HOST.'adcus/', $pgno);
			$max = count($res);
			$states = array('AB'=>'Alberta',
							'BC'=>'British Columbia',
							'MB'=>'Manitoba',
							'NB'=>'New Brunswick',
							'NL'=>'Newfoundland and Labrador',
							'NS'=>'Nova Scotia',
							'NT'=>'Northwest Territories',
							'NU'=>'Nunavut',
							'ON'=>'Ontario',
							'PE'=>'Prince Edward Island',
							'QC'=>'Quebec',
							'SK'=>'Saskatchewan',
							'YT'=>'Yukon',
							'AL'=>'Alabama',
							'AK'=>'Alaska',
							'AZ'=>'Arizona',
							'AR'=>'Arkansas',
							'CA'=>'California',
							'CO'=>'Colorado',
							'CT'=>'Connecticut',
							'DE'=>'Delaware',
							'DC'=>'District Of Columbia',
							'FL'=>'Florida',
							'GA'=>'Georgia',
							'HI'=>'Hawaii',
							'ID'=>'Idaho',
							'IL'=>'Illinois',
							'IN'=>'Indiana',
							'IA'=>'Iowa',
							'KS'=>'Kansas',
							'KY'=>'Kentucky',
							'LA'=>'Louisiana', 
							'ME'=>'Maine',
							'MD'=>'Maryland',
							'MA'=>'Massachusetts',
							'MI'=>'Michigan',
							'MN'=>'Minnesota',
							'MS'=>'Mississippi',
							'MO'=>'Missouri', 
							'MT'=>'Montana',
							'NE'=>'Nebraska',
							'NV'=>'Nevada',
							'NH'=>'New Hampshire',
							'NJ'=>'New Jersey',
							'NM'=>'New Mexico',
							'NY'=>'New York',
							'NC'=>'North Carolina',
							'ND'=>'North Dakota',
							'OH'=>'Ohio',
							'OK'=>'Oklahoma',
							'OR'=>'Oregon',
							'PA'=>'Pennsylvania',
							'RI'=>'Rhode Island',
							'SC'=>'South Carolina',
							'SD'=>'South Dakota',
							'TN'=>'Tennessee',
							'TX'=>'Texas',
							'UT'=>'Utah',
							'VT'=>'Vermont',
							'VA'=>'Virginia',
							'WA'=>'Washington',
							'WV'=>'West Virginia',
							'WI'=>'Wisconsin',
							'WY'=>'Wyoming');
			$xtpl = new Xtemplate("admin".DS."contactuslist.tpl");
			if($max>0){
				for($e=0;$e<$max; $e++){	
						$tst_list = array(
								"NAME"=>ucFirst($res[$e]['name']),
								"PHONE"=>$res[$e]['telephone'],
								"UNITS"=>$res[$e]['units'],
								"STREET"=>$res[$e]['street'],
								"STATE"=>$states[$res[$e]['state']],
								"CITY"=>$res[$e]['city'],
								"ZIP"=>$res[$e]['zip'],
								"DEL"=>"<a href='".HOST."adcus/delete/".$res[$e]['id']."' onclick='return confirm(\" Are you sure you want to delete this record?\")'><img src='".IMAGE."admin/delete.gif' alt='Delete' title='Delete'/></a>"
						);
					$xtpl->assign('DATA',$tst_list);
					$xtpl->parse('main.row.columns');
			   }
			  
			   $xtpl->assign('IMAGE', IMAGE.'admin/');
			   $xtpl->assign('PAGINATION', $cmdl->getPagelinks());
			   $xtpl->assign('CLRSULT', $clrresult);
			   $xtpl->assign('NAME', stripslashes($name));
			   $xtpl->assign('EMAIL', stripslashes($email));
			   $xtpl->parse('main.row');
			   $xtpl->parse('main');
			   $xtpl->out('main');
			}else{
				$xtpl->assign('NORECORD','No Record found.');
			}
			$this->admin_foot();
		}
		
		
		public function delete($id=''){
			$cmdl = new contactModel();
			$cmdl->deleteRecord($id);
			header('Location: '.HOST.'adcus/');
		}
		
	}
?>