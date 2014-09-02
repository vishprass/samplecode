<?php
/* SVN FILE: $Id$ */
function stripslashes_deep($values) {
	//	print_r($_GET);
		if (is_array($values)) {
			foreach ($values as $key => $value) {
				$values[$key] = stripslashes_deep($value);
			}
		} else {
			$values = stripslashes($values);
		}
		return $values;
}
function __autoload($name)
{   
    $path = explode(PATH_SEPARATOR, ini_get('include_path')); //get all the possible paths to the file (preloaded with the file structure of the project)
    foreach($path as $tryThis)
    {
        //try each possible iteration of the file name and use the first one that comes up
        // name.class.php first
  
        $exists = file_exists($tryThis.$name.'.php');
        if ($exists)
        {
            include_once($tryThis.$name.'.php');
    		$controller = new $name();
			return $controller;
        }
    }
   
   include_once('404.php');
    // can't find it...
   // die("Class $name could not be found!");
}

function env($key) {
		if ($key == 'HTTPS') {
			if (isset($_SERVER['HTTPS'])) {
				return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
			}
			return (strpos(env('SCRIPT_URI'), 'https://') === 0);
		}

		if ($key == 'SCRIPT_NAME') {
			if (env('CGI_MODE') && isset($_ENV['SCRIPT_URL'])) {
				$key = 'SCRIPT_URL';
			}
		}

		$val = null;
		if (isset($_SERVER[$key])) {
			$val = $_SERVER[$key];
		} elseif (isset($_ENV[$key])) {
			$val = $_ENV[$key];
		} elseif (getenv($key) !== false) {
			$val = getenv($key);
		}

		if ($key === 'REMOTE_ADDR' && $val === env('SERVER_ADDR')) {
			$addr = env('HTTP_PC_REMOTE_ADDR');
			if ($addr !== null) {
				$val = $addr;
			}
		}

		if ($val !== null) {
			return $val;
		}

		switch ($key) {
			case 'SCRIPT_FILENAME':
				if (defined('SERVER_IIS') && SERVER_IIS === true) {
					return str_replace('\\\\', '\\', env('PATH_TRANSLATED'));
				}
			break;
			case 'DOCUMENT_ROOT':
				$name = env('SCRIPT_NAME');
				$filename = env('SCRIPT_FILENAME');
				$offset = 0;
				if (!strpos($name, '.php')) {
					$offset = 4;
				}
				return substr($filename, 0, strlen($filename) - (strlen($name) + $offset));
			break;
			case 'PHP_SELF':
				return str_replace(env('DOCUMENT_ROOT'), '', env('SCRIPT_FILENAME'));
			break;
			case 'CGI_MODE':
				return (PHP_SAPI === 'cgi');
			break;
			case 'HTTP_BASE':
				$host = env('HTTP_HOST');
				if (substr_count($host, '.') !== 1) {
					return preg_replace('/^([^.])*/i', null, env('HTTP_HOST'));
				}
			return '.' . $host;
			break;
		}
		return null;
	}
	
	
/**
 * Dispatcher takes the URL information, parses it for paramters and
 * tells the involved controllers what to do.
 *
 */
class Dispatcher {

	var $base = false;

	var $here = false;

	var $admin = false;

	var $plugin = null;

	var $params = null;

/**
 * Constructor.
 */
	function __construct($url = null, $base = false) {
		if ($url !== null) {
			return $this->dispatch($url);
		}
	}

/**
 * Dispatches and invokes given URL, handing over control to the involved controllers, and then renders the results (if autoRender is set).
 *
 * If no controller of given name can be found, invoke() shows error messages in
 * the form of Missing Controllers information. It does the same with Actions (methods of Controllers are called
 * Actions).
 */
	function dispatch($url = null, $additionalParams = array()) {

		if ($this->base === false) {
			$this->base = $this->baseUrl();
		}

		if (is_array($url)) {
			$url = $this->__extractParams($url, $additionalParams);
		} else {
			if ($url) {
				$_GET['url'] = $url;
			}
			$url = $this->getUrl();
			$this->params = array_merge($this->parseParams($url), $additionalParams);
		}

		$this->here = $this->base . '/' . $url;

		
		$controller =& $this->__getController();
		
		if (!is_object($controller)) {
			Router::setRequestInfo(array($this->params, array('base' => $this->base)));
			//require_once("404.php");
			//exit;
		}

		$privateAction = (bool)(strpos($this->params['action'], '_', 0) === 0);
		$prefixes = Router::prefixes();

		if (!empty($prefixes)) {
			if (isset($this->params['prefix'])) {
				$this->params['action'] = $this->params['prefix'] . '_' . $this->params['action'];
			} elseif (strpos($this->params['action'], '_') !== false && !$privateAction) {
				list($prefix, $action) = explode('_', $this->params['action']);
				$privateAction = in_array($prefix, $prefixes);
			}
		}

		Router::setRequestInfo(array(
			$this->params, array('base' => $this->base, 'here' => $this->here)
		));

		if ($privateAction) {
			 
			require_once('method.php');
		}
		
		$controller->base = $this->base;

		$controller->here = $this->here;

		$controller->plugin = $this->plugin;
		
		$controller->params =& $this->params;

		$controller->action =& $this->params['action'];

		$controller->passedArgs = array_merge($this->params['pass'], $this->params['named']);

		if (!empty($this->params['data'])) {
			$controller->data =& $this->params['data'];
		} else {
			$controller->data = null;
		}

		if (array_key_exists('return', $this->params) && $this->params['return'] == 1) {
			$controller->autoRender = false;
		}
		if (!empty($this->params['bare'])) {
			$controller->autoLayout = false;
		}
		if (array_key_exists('layout', $this->params)) {
			if (empty($this->params['layout'])) {
				$controller->autoLayout = false;
			} else {
				$controller->layout = $this->params['layout'];
			}
		}

		if (isset($this->params['viewPath'])) {
			$controller->viewPath = $this->params['viewPath'];
		}

		return $this->_invoke($controller, $this->params);
	}

/**
 * Invokes given controller's render action if autoRender option is set. Otherwise the
 * contents of the operation are returned as a string.
 */
	function _invoke($controller, $params) {
		$controller->methods = get_class_methods($controller);
		$methods = array_flip($controller->methods);
		/*if (!isset($methods[strtolower($params['action'])])) {
			//include_once("method.php");
			//return ;
		}*/
		$output = $controller->dispatchMethod($params['action'], $params['pass']);

		if ($controller->autoRender) {
			$controller->output = $controller->render();
		} elseif (empty($controller->output)) {
			$controller->output = $output;
		}
//		$controller->afterFilter();

		if (isset($params['return'])) {
			return $controller->output;
		}
		echo($controller->output);
	}

/**
 * Sets the params when $url is passed as an array to Object::requestAction();
 *
 */
	function __extractParams($url, $additionalParams = array()) {
		$defaults = array('pass' => array(), 'named' => array(), 'form' => array());
		$this->params = array_merge($defaults, $url, $additionalParams);
		return Router::url($url);
	}

/**
 * Returns array of GET and POST parameters. GET parameters are taken from given URL.
 *
 */
	function parseParams($fromUrl) {
		$params = array();

		if (isset($_POST)) {
			$params['form'] = $_POST;
			if (ini_get('magic_quotes_gpc') === '1') {
				$params['form'] = stripslashes_deep($params['form']);
			}
			if (env('HTTP_X_HTTP_METHOD_OVERRIDE')) {
				$params['form']['_method'] = env('HTTP_X_HTTP_METHOD_OVERRIDE');
			}
			if (isset($params['form']['_method'])) {
				if (isset($_SERVER) && !empty($_SERVER)) {
					$_SERVER['REQUEST_METHOD'] = $params['form']['_method'];
				} else {
					$_ENV['REQUEST_METHOD'] = $params['form']['_method'];
				}
				unset($params['form']['_method']);
			}
		}
		$namedExpressions = Router::getNamedExpressions();
		//print_r(extract($namedExpressions));
		include CONFIGS .DS.'routes.php';
		$params = array_merge(Router::parse($fromUrl), $params);

		if (strlen($params['action']) === 0) {
			$params['action'] = 'index';
		}
		if (isset($params['form']['data'])) {
			$params['data'] = Router::stripEscape($params['form']['data']);
			unset($params['form']['data']);
		}
		if (isset($_GET)) {
			if (ini_get('magic_quotes_gpc') === '1') {
				$url = stripslashes_deep($_GET);
			} else {
				$url = $_GET;
			}
			if (isset($params['url'])) {
				$params['url'] = array_merge($params['url'], $url);
			} else {
				$params['url'] = $url;
			}
		}
		foreach ($_FILES as $name => $data) {
			if ($name != 'data') {
				$params['form'][$name] = $data;
			}
		}
		if (isset($_FILES['data'])) {
			foreach ($_FILES['data'] as $key => $data) {
				foreach ($data as $model => $fields) {
					foreach ($fields as $field => $value) {
						if (is_array($value)) {
							foreach ($value as $k => $v) {
								$params['data'][$model][$field][$k][$key] = $v;
							}
						} else {
							$params['data'][$model][$field][$key] = $value;
						}
					}
				}
			}
		}
		return $params;
	}

/**
 * Returns a base URL 
 *
 */
	function baseUrl() {
		$dir =  null;
		//$config = Configure::read('App');
		$config = array('base'=>'','baseUrl'=>'','dir'=>'');
		extract($config);

		if (!$base) {
			$base = $this->base;
		}
		if ($base !== false) {
			return $this->base = $base;
		}
		if (!$baseUrl) {
			$replace = array('<', '>', '*', '\'', '"');
			$base = str_replace($replace, '', dirname(env('PHP_SELF')));

			if ($dir === 'app' && $dir === basename($base)) {
				$base = dirname($base);
			}

			if ($base === DS || $base === '.') {
				$base = '';
			}

			return $base;
		}
		$file = null;

		if ($baseUrl) {
			$file = '/' . basename($baseUrl);
			$base = dirname($baseUrl);

			if ($base === DS || $base === '.') {
				$base = '';
			}
			
			return $base . $file;
		}
		return false;
	}

/**
 * Restructure params in case we're serving a plugin.
 *
 */
	function _restructureParams($params, $reverse = false) {
	
		if ($reverse === true) {
			extract(Router::getArgs($params['action']));
			$params = array_merge($params, array(
				'controller'=> $params['plugin'],
				'action'=> $params['controller'],
				'pass' => array_merge($pass, $params['pass']),
				'named' => array_merge($named, $params['named'])
			));
			$this->plugin = $params['plugin'];
		} else {
			//$params['plugin'] = $params['controller'];
			$params['controller'] = $params['action'];
			$params['controller'] = $params['controller'];
			if (isset($params['pass'][0])) {
				$params['action'] = $params['pass'][0];
				array_shift($params['pass']);
			} else {
				$params['action'] = null;
			}
		}
		
		return $params;
	}

/**
 * Get controller to use, either plugin controller or application controller
 *
 */
	function &__getController($params = null) {
	
		if (!is_array($params)) {
			$original = $params = $this->params;
		}
		$controller = false;
			//print_r($params);
		$ctrlClass = $this->__loadController($params);
	//echo $ctrlClass;
		if (!$ctrlClass) {
			//echo "here";
			//exit;	
			if (!isset($params['plugin'])) {
				$params = $this->_restructureParams($params);
			} else {
				if (empty($original['pass']) && $original['action'] == 'index') {
					$params['action'] = null;
				}
				$params = $this->_restructureParams($params, true);
			}
			$ctrlClass = $this->__loadController($params);
			
			if (!$ctrlClass) {
				$this->params = $original;
				return $controller;
			}
		} else {
			$params = $this->params;
		}
		$name = $ctrlClass;
		
		$controller = __autoload($ctrlClass);
		$this->params = $params;	
		
		return $controller; 
	}

/**
 * Load controller and return controller class
 *
 */
	function __loadController($params) {
		//print_r($params);
		$pluginName = $pluginPath = $controller = null;
		if (!empty($params['plugin'])) {
			$this->plugin = $params['plugin'];
			$pluginName = $params['plugin'];
			$pluginPath = $pluginName . '.';
			$this->params['controller'] = $this->plugin;
			$controller = $pluginName;
		}
		if (!empty($params['controller'])) {
			$this->params['controller'] = $params['controller'];
			$controller = $params['controller'];
			
		}
		if ($pluginPath . $controller) {
			//echo $pluginPath . $controller;
			//echo $pluginPath."<br />";
				$controller =  $controller."Controller";
					
				return $controller;
			
		}
		return false;
	}

/**
 * Returns the REQUEST_URI from the server environment, or, failing that,
 * constructs a new one, using the PHP_SELF constant and other variables.
 *
 */
	function uri() {
		foreach (array('HTTP_X_REWRITE_URL', 'REQUEST_URI', 'argv') as $var) {
			if ($uri = env($var)) {
				if ($var == 'argv') {
					$uri = $uri[0];
				}
				break;
			}
		}
		$base = preg_replace('/^\//', '', '' .$this->base_url);

		if ($base) {
			$uri = preg_replace('/^(?:\/)?(?:' . preg_quote($base, '/') . ')?(?:url=)?/', '', $uri);
		}
		if (PHP_SAPI == 'isapi') {
			$uri = preg_replace('/^(?:\/)?(?:\/)?(?:\?)?(?:url=)?/', '', $uri);
		}
		if (!empty($uri)) {
			if (key($_GET) && strpos(key($_GET), '?') !== false) {
				unset($_GET[key($_GET)]);
			}
			$uri = preg_split('/\?/', $uri, 2);

			if (isset($uri[1])) {
				parse_str($uri[1], $_GET);
			}
			$uri = $uri[0];
		} else {
			$uri = env('QUERY_STRING');
		}
		if (is_string($uri) && strpos($uri, 'index.php') !== false) {
			list(, $uri) = explode('index.php', $uri, 2);
		}
		if (empty($uri) || $uri == '/' || $uri == '//') {
			return '';
		}
		return str_replace('//', '/', '/' . $uri);
	}

/**
 * Returns and sets the $_GET[url] derived from the REQUEST_URI
 *
 */
	function getUrl($uri = null, $base = null) {
		if (empty($_GET['url'])) {
			if ($uri == null) {
				$uri = $this->uri();
			}
			if ($base == null) {
				$base = $this->base;
			}
			$url = null;
			$tmpUri = preg_replace('/^(?:\?)?(?:\/)?/', '', $uri);
			$baseDir = preg_replace('/^\//', '', dirname($base)) . '/';

			if ($tmpUri === '/' || $tmpUri == $baseDir || $tmpUri == $base) {
				$url = $_GET['url'] = '/';
			} else {
				if ($base && strpos($uri, $base) !== false) {
					$elements = explode($base, $uri);
				} elseif (preg_match('/^[\/\?\/|\/\?|\?\/]/', $uri)) {
					$elements = array(1 => preg_replace('/^[\/\?\/|\/\?|\?\/]/', '', $uri));
				} else {
					$elements = array();
				}

				if (!empty($elements[1])) {
					$_GET['url'] = $elements[1];
					$url = $elements[1];
				} else {
					$url = $_GET['url'] = '/';
				}

				if (strpos($url, '/') === 0 && $url != '/') {
					$url = $_GET['url'] = substr($url, 1);
				}
			}
		} else {
			$url = $_GET['url'];
		}
		if ($url{0} == '/') {
			$url = substr($url, 1);
		}
		return $url;
	}
}
?>