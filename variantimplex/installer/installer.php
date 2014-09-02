<?
/**
 * Checking config.ini file exists or not.
 */
 define("CONFIGFILE", "../config/config.ini");
 define("SQLFILE", "TLICMS.sql");
 define("CONTACTUS", "contactus.sql");
 include("../core/PDB.php");
 if(!file_exists(CONFIGFILE)){
 	/** 
	  *include the form wich will create config.ini file 	 
	  */
	 include("configform.php");
 }else{
   $dberror = '';
 	try{
		$db  = new PDB(CONFIGFILE);
	}catch(Exception $e){
		$dberror = "Db connection is not successfull."; 
	}
	if($dberror!=''){
		echo $dberror;
	}else{
		$fp = fopen(SQLFILE, "r");
		$content = fread($fp, filesize(SQLFILE));
		$db  = new PDB(CONFIGFILE);
		$tmpar = parse_ini_file(CONFIGFILE, true);
		if($tmpar['FW']['contactus']){
			$fp = fopen(CONTACTUS, "r");
			$content .= fread($fp, filesize(CONTACTUS));
		}
		$res = $db->executeQuery($content);

		include("adminlogin.php");
	}
 }
 
?>