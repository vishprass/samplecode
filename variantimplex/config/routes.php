<?php
/*$db_array = parse_ini_file('config.ini',true);
print_r($db_array);
//establish connection to read-only slave cluster
$objMySQL_Read = mysql_connect ($db_array['DB']['HOST'], $db_array['DB']['dbuser'], $db_array['DB']['dbpass']);
mysql_select_db ($db_array['DB']['dbname'], $objMySQL_Read);

$strSQL = "SELECT col1,col2 FROM "  . DB_NAME . "." . "tbl1 WHERE 1=1";

$objRS = mysql_query ($strSQL, $objMySQL_Read); //returns data from slaves

$strSQL = "INSERT INTO " . DB_NAME . "." . "tbl1 (col1,col2) VALUES (val1,val2)";

mysql_query ($strSQL); 
	*/	
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'index', 'action' => 'index'));
//	Router::connect('/cms', array('controller' => 'cms', 'action' => 'index'));
//	Router::connect('/aboutus', array('controller' => 'index', 'action' => 'aboutus'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	
?>
