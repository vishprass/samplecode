<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TLI-CMS-CONFIGURATION</title>
</head>
<body>
<div align="center" style="padding-top:10px;padding-bottom:10px;background-color:#999900"><strong>CHECK REQUIREMENT</strong></div>
<table width="100%">
	<tr>
		<td>Products</td><td>Version</td><td>Support</td>
	</tr>
	<tr>
		<td>PHP</td><td><?=phpversion();?></td><td><? if(intval(array_shift(explode(".", phpversion()))) < 5){$img="stock_cancel-16.png";}else{$img="stock_ok-16.png";}?><img src="installer/images/<?=$img;?>"></td>
	</tr>
	<tr>
		<td>PDO</td><td><?= class_exists('PDO')?"PDO INSTALLED":"PDO absent"?></td><td><? if(class_exists('PDO')){$img="stock_ok-16.png";}else{$img="stock_cancel-16.png";}?><img src="installer/images/<?=$img;?>"></td>
	</tr>
<tr><td colspan="2"><input type="button" onclick="Javascript:document.location.href='installer/installer.php'" value="Next"></td></tr>
</table>

</body>
</html>
