<?
session_start();
if($_SESSION['user']==''){
	  header("Location: ./admin.php");
}
?>