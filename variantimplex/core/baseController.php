<?php

class baseController{
	
	public $base_url ;
	
	public $base_path ;
	
	public $app_dir ;
	
	public $plugins;
	
	protected $auth ;
	
	protected $session ;
	
	protected $config;
	
	
	function dispatchMethod($method, $params = array()) {
		//echo $method;
		switch (count($params)) {
			case 0:
				return $this->{$method}();
			case 1:
				return $this->{$method}($params[0]);
			case 2:
				return $this->{$method}($params[0], $params[1]);
			case 3:
				return $this->{$method}($params[0], $params[1], $params[2]);
			case 4:
				return $this->{$method}($params[0], $params[1], $params[2], $params[3]);
			case 5:
				return $this->{$method}($params[0], $params[1], $params[2], $params[3], $params[4]);
			default:
				return call_user_func_array(array(&$this, $method), $params);
			break;
		}
	}
	
	
}

?>