<?php

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'index', 'action' => 'index'));
	
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	
?>
