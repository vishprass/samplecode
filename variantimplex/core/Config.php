<?php
    /*
    * Created on 12-Aug-08
     *
     * To change the template for this generated file go to
     * Window - Preferences - PHPeclipse - PHP - Code Templates
     */
    
    Class Config  {
       
      const CONFIG_FILE ='config/config.ini';
       
      public $properties = array();
      
      function __construct()
      {
        return  $this->properties = parse_ini_file(self::CONFIG_FILE,true);
      }
      
    }
?>