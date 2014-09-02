<?php
class Acl {

   /**
    * Holds user access level, default=1
    *
    * 1 => Guest
    * 2 => Member
    * 3 => Staff
    * 4 => Publisher
    * 5 => Admin
    *
    * @var Integer
    */
   protected  $userLevel = 1;



   /**
    * Holds admin level number as using in your system. default=5
    *
    * @var integer admin level
    */
   public $adminLevel = 5;



   /**
    * Holds user ID number
    *
    * @var Integer
    */
   protected $userId = 0;



   /**
    * Resources array
    *
    * @var Array
    */
   public $resources;



   /**
    * Set individual user access to resource
    *
    * @var Array
    */
   protected  $allowUser = array();



   /**
    * Set individual level access to resource
    *
    * @var Array
    */
   protected  $allowLevel = array();



   /**
    * Constractor
    *
    * @param Integer $userId
    * @param Integer $userLevel
    */
   public function __construct($userId,$userLevel){

      $this->userId = $userId;

      $this->userLevel = $userLevel;
      

   }

 

	
   /**
    * Add a new resource
    *
    * this is the only function where user inherit privilege based on user level
    *
    * @param String $resourceName
    * @param Integer $minimunAccessLevel
    */
   public function addResource($resourceName,$minimunAccessLevel = 1){
	  $res = array();
	  if (is_array($resourceName)) {
      	foreach($resourceName as $key=>$value){
			if(intval($value)<1) $value = $minimunAccessLevel; 
			$res[$key] = $value;
      	}  
      }
      else {
         $res[$resourceName] = $minimunAccessLevel;
         
      }
	  $this->resources = $res;
   }



   /**
    * Allow current user access an resource not depending on $minimunAccessLevel
    *
    * @param $resourceName
    * @param Boolean $bool
    */
   public function allowUser($resourceName,$bool=true){
      
      if (is_array($resourceName)) {
         foreach ($resourceName as $name) {
            $this->allowUser[$name] = $bool;
         }
      }
      else {
         $this->allowUser[$resourceName] = $bool;
      }
   }



   /**
    * Allow user level to access an resource not depending on $minimunAccessLevel
    *
    * @param $resourceName
    * @param unknown_type $bool
    */
   public function allowLevel($resourceName,$bool=true,$userLevel=''){
      if (empty($userLevel)) {
         $userLevel = $this->userLevel;
      }
      $this->allowLevel[$resourceName] = array($bool,$userLevel);
   }



   /**
    * true if admin, false if not
    *
    * @return boolean
    */
   public function isAdmin(){
      if ($this->adminLevel == $this->userLevel) {
         return true;
      }
      else return false;
   }




   /**
    * Check if user is allowed to use resource
    * 
    * Note: script access procedure:
    *  1. check for user access
    *  2. check level access
    *  3. check for global access
    *  
    *  
    *   if user have user access (allowUser('post')) deny his  
    *   level (allowLevel('post',fasle)) will not affect 
    *
    * @param String $resourceName
    * @return Boolean
    */
   public function isValid($resourceName){
      //user is admin
      if ($this->isAdmin()) {
         return true;
      }
      
   	  //check if resource exists
      if (empty($this->resources) && empty($this->allowUser) && empty($this->allowLevel)) { 
         return false;                         
      }
      

      
      //check for individual allowUser() access
      if (isset($this->allowUser[$resourceName]) && $this->allowUser[$resourceName] === true) {      	 
         return true;
         exit;
      }
      elseif (isset($this->allowUser[$resourceName]) && $this->allowUser[$resourceName] === false) {      	
      	return false;
      }
      
      //check for individual user level allowLevel() access
      //good user level
      if (isset($this->allowLevel[$resourceName]) && $this->allowLevel[$resourceName][0] === true) {
         if (is_array($this->allowLevel[$resourceName][1])) {
            foreach ($this->allowLevel[$resourceName][1] as $value) {
               if ($value == $this->userLevel) {               	  
                  return true;
               }
            }
         }
         //good user level
         else {
            if ($this->allowLevel[$resourceName][1] == $this->userLevel) {               
               return true;
            }
         }
      }
      //no access for current user level
      elseif (isset($this->allowLevel[$resourceName]) && $this->allowLevel[$resourceName][0] === false) {
      	return false;
      }
      //check for addResource() global resource access
      if (isset($this->resources[$resourceName])) {
         //$this->addDebug("-isValid()- check resourced global access. (line:".__LINE__.")");
         
         if ($this->userLevel >= $this->resources[$resourceName] && $this->resources[$resourceName] != 0 ) {                  	
            return true;
         }
         else {
	         return false;
         }
      } 
      else {
	      return false;
      }
   }
}
?>