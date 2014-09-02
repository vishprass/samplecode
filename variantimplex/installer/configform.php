<?

if(count($_POST)){
	foreach ($_POST as $key => $val) {
		${$key} = get_magic_quotes_gpc()?html_entity_decode(utf8_encode(trim(urldecode($val))), ENT_QUOTES):addslashes(html_entity_decode(trim(urldecode($val)), ENT_QUOTES));
	}
	$err='';
	//if($hosturl == '') $err =" &bull;Host Url must not be blank.";
	//elseif(!(preg_match("#^http://.[a-z0-9]#",$hosturl))) $err .= "<br/>&bull; Please enter valid URL"; 
	if($dbhost=='') $err .= "<br/>&bull;Database host may not be blank.";
	elseif(!preg_match("/^[a-zA-Z0-9]{2,20}/", $dbhost)) $err .="<br/>&bull;Please enter valid Data base host.";
	if($dbname=='') $err .="<br/> &bull; Database name must not be blank.";
	if($dbusername=='') $err .="<br/> &bull; Database user name must not be blank.";
	//if($dbpassword =='')  $err .="<br/> &bull; Password must not be blank.";
	//elseif($dbcpassword =='') $err .="<br/> &bull; Confirm password must not be blank.";
    //elseif($dbpassword != $dbcpassword ) $err .="<br/> &bull; Password and Confirm password does not match.";
	if($mailport!='' && (!preg_match("/^[0-9]{2,20}/", $mailport))) $err .= "<br/>&bull;Mail port must be an integer.";
	if($err==''){
		$conn = '';
		try{
			$conn =  new PDO("$dbtype:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
			$conn = 'connected';
			}catch(Exception $e){
			 $conn = '';	
			}
		if($conn==''){
			 $err=" My sql connection could not established. Please provide valid information.";
		}else{ 
			try{
			 	$con =  new PDO("$dbtype:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
			 	$res = "connected";
			 }catch(Exception $e){
			 	$res = false;
			 }
			 if(!$res) {	
			 		$err = "Mentioned database is not exists. Please create databse.";
			 }else{
			 	$contact_us = ($contactus==1?"true":"false");
				$acl_sts = ($acl==1?"true":"false");
				$dbsession_sts = ($sessiondb==1?"true":"false");
				$fp = fopen(CONFIGFILE, "w+");
				
$str="
    # This database details will be used for data base connection
	  [DB]  
    # DATABASE host name 
	  host = $dbhost; 
    # DATABASE type 
	  dbtype = $dbtype; 
    # DATABASE user Name 
	  dbuser = $dbusername; 
    # DATABASE Password
	  dbpass = $dbpassword; 
	# DATABASE name 
	  dbname = $dbname; 
	  dbpersistent = true; 
 	# This SMTP details will be used for sending mails
	  [MAIL]
	# SMTP server name 
	  server = $mailserver;
	# SMTP server port
	  port = $mailport;
	# SMTP username 
	  username = $mailusername;
	# SMTP password 
	  password = $mailpassword;				 
	# This APPLICATION details will be used path   
	  [FW]		  
    # base url will be used for viewing application on browser. \n\n  
	  base_url = $hosturl;
	#System path for file. 
	 base_path = ".ROOT."; 
	 acl = $acl_sts;
	 dbsession = $dbsession_sts;
	 contactus = $contact_us;";
				fwrite($fp, $str);
				header("location: installer.php");
			 }
		}
		     
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TLICMS INSTALLER</title>
</head>
<body>
<div style="height:50px;font-weight:bolder;color:#7B7724" align="center">TLI CMS INSTALLER</div>
<? if($err!=''){?>
<div style="font-weight:bolder;color:#CC0000;padding-top:10px;padding-bottom:20px;background-color:#353359;border-bottom-color:#FF0000;border-style:solid;" align="center"><?=$err;?></div>
<? }?>

<div align="center" style="padding-top:20px;background-color:#999999">
<form name="config" id="config" method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<table width="70%">
		<!--<tr><td colspan="2" align="left" height="30px"><span style="color:#FF0000;">*</span><strong><u>Marked fields are Mandatory</u></strong></td></tr>
		<tr><td colspan="2" height="30px"><strong><u>APPLICATION DETAILS</u></strong></td></tr>-->
		<!--<tr><td>HOST URL<span style="color:#FF0000">*</span>:</td><td>
			<input type="text" name="hosturl" id="hosturl" value="<?=$hosturl!=''?$hosturl:'http://localhost/tlicms'?>" style="width:250px">
		</td></tr>-->
		<tr><td colspan="2" height="30px"><strong><u>DATABASE DETAILS</u></strong></td></tr>
		<tr><td>Data base TYPE<span style="color:#FF0000">*</span>:</td><td>
			<select name="dbtype" id="dbtype" style="width:250px">
				<option value="mysql">My Sql</option>
			</select> &nbsp; This product works perfect with My Sql
		</td></tr>
		<tr><td>Data base HOST<span style="color:#FF0000">*</span>:</td><td>
			<input type="text" name="dbhost" id="dbhost" value="<?=$dbhost!=''?$dbhost:'localhost'?>" style="width:250px">
		</td></tr>
		<tr><td>Database Name<span style="color:#FF0000">*</span>:</td><td><input type="text" name="dbname" id="dbname" value="<?=$dbname!=''?$dbname:'tlicms'?>" style="width:250px"></td></tr>
		<tr><td>Database User Name<span style="color:#FF0000">*</span>:</td><td><input type="text" name="dbusername" id="dbusername" value="<?=$dbusername!=''?stripslashes($dbusername):"root user is not allowed"?> " style="width:250px"></td></tr>
		<tr><td>Database Password<span style="color:#FF0000">*</span>:</td><td><input type="password" name="dbpassword" id="dbpassword" value="<?=$dbpassword!=''?$dbpassword:""?>" style="width:250px"></td></tr>
		<tr><td>Confirm Password<span style="color:#FF0000">*</span>:</td><td><input type="password" name="dbcpassword" id="dbcpassword" value="<?=$dbcpassword!=''?$dbcpassword:""?>" style="width:250px"></td></tr>
		<tr><td colspan="2" height="30px"><strong><u>SMTP DETAILS (OPTIONAL)</u></strong></td></tr>
		<tr><td>SMTP Server:</td><td><input type="text" name="mailserver" id="mailserver" value="<?=$mailserver?>" style="width:250px"></td></tr>
		<tr><td>SMTP PORT:</td><td><input type="text" name="mailport" id="mailport" value="<?=$mailport!=''?$mailport:''?>" style="width:250px"></td></tr>
		<tr><td>SMTP username:</td><td><input type="text" name="mailusername" id="mailusername" value="<?=$mailusername;?>" style="width:250px"></td></tr>
		
		<tr><td>SMTP password:</td><td><input type="text" name="mailpassword" id="mailpassword" value="<?=$mailpassword;?>" style="width:250px"></td></tr>
		
		<tr><td colspan="2">Install ACL:&nbsp;<input type="checkbox" name="acl" id="acl" value="1" <?= ($acl==1)?"checked='checked'":"";?>/>&nbsp;&nbsp;Install Session DB:&nbsp;
	<input type="checkbox" name="sessiondb" id="sessiondb" value="1" <?= $sessiondb==1?"checked='checked'":"";?>/>
	&nbsp;&nbsp;Install Contact us Form<input type="checkbox" id="contactus" name="contactus" value="1" <?= $contactus==1?"checked='checked'":"";?>/></td></tr>
		
		<tr><td colspan="2" align="center" height="40px"><input type="submit" name="sub" id="sub" value="Submit"></td></tr>
	</table>
</form>
</div>
</body>
</html>
