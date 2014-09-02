<?
include_once("../core/PDB.php");
if(count($_POST)){
$err ="";
foreach ($_POST as $key => $val) {
		${$key} = get_magic_quotes_gpc()?html_entity_decode(utf8_encode(trim(urldecode($val))), ENT_QUOTES):addslashes(html_entity_decode(trim(urldecode($val)), ENT_QUOTES));
	}
	if($adminuser == '') $err = "&bull; Admin user name must not be blank.";
	if($password == '') $err .= "<br/> &bull; Password must not be blank.";
	if($email == '') $err .= "<br/> &bull; email must not be blank.";
	elseif(!eregi("[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}", $email)) $err .="<br>&bull;Please enter valid email address.";
    if($err==''){
		   $db = new PDB("../config/config.ini");
		   $created = date("Y-m-d H:i:s");
	       $fields = array("username", "firstname", "password", "email", "accesslevel", "created", "status");
		   $values = array($adminuser, $adminuser, $password, $email, '1', $created, "1");
		   $table = "users";
		   $insert_id = $db->executeInsertSQL($fields, $values,$table);
		   if(file_exists("../default.htaccess")){
		   	echo "<h1>Please rename default.htaccess to .htaccess in root folder and app folder.</h1>
				<a href='../index.php'>NEXT</a>	
					
			";
		   }else{
		   	header("Location: ../index.php");
		   }
		   exit;
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
<form name="adminconfig" id="adminconfig" method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<table width="50%">
		<tr><td>User Name:</td>
		<td><input type="text" name="adminuser" id="adminuser" value="<?=$adminuser?>" style="width:250px"/></td></tr>
		<tr><td>Password:</td>
		<td><input type="password" name="password" id="password" value="<?=$password?>" style="width:250px"/></td></tr>
		<tr><td>Email:</td>
		<td><input type="text" name="email" id="email" value="<?=$email?>" style="width:250px"/></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" name="sub" value="submit"/></td></tr>
	</table>
</form>
</div>
</body>
</html>
