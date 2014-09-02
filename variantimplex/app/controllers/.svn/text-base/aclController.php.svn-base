<?php
	include_once('resourceModel.php');
	class aclController extends Acl{
		var $latestar;
		var $userid = NULL;
		var $userlbl = NULL;
		
		public function __construct($userid, $userlbl){
			parent::__construct($userid, $userlbl);
			$fnalar = array();
			$this->userid = $userid;
			$this->userlbl = $userlbl;
			$resou = array();
			$minlvl = array();
			$resm = new resourceModel();
			$res = $resm->getResourceList();
			//print_r($res);
			$max = count($res);
			for($i=0;$i<$max;$i++){
				array_push($resou, $res[$i]['name']);
				array_push($minlvl, $res[$i]['min_level']);   
			}
			
			$fnalar = array_combine($resou, $minlvl);
			$this->latestar = $fnalar;
		}
		
		public function checkAccess($resourcename){
			$res = $this->addResource($this->latestar);
			 
			 if($this->isValid($resourcename)) 
			  return true;
			else
			  return false;
		}
		
   }
?>