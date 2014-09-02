<?php
class Paginated {
	
	public $php_self;
	
	//Number of records to display per page
	public $rows_per_page = 3; 
	
	//Total number of rows returned by the query
	public $total_rows = 0; 
	
	//Number of links to display per page
	public $links_per_page = 5; 
	
	//Paremeters to append to pagination links
	public $append = ""; 
	
	public $sql = "";
	
	public $debug = false;
	
	public $db = false;
	
	public $page = 1;
	
	public $max_pages = 0;
	
	public $offset = 0;
    
	
	/**
	 * Constructor
	 *
	 * @param resource $connection Mysql connection link
	 * @param string $sql SQL query to paginate. Example : SELECT * FROM users
	 * @param integer $rows_per_page Number of records to display per page. Defaults to 10
	 * @param integer $links_per_page Number of links to display per page. Defaults to 5
	 * @param string $append Parameters to be appended to pagination links 
	 */

  public function __construct($db= null, $sql, $rows_in_page = 10, $links_per_page = 5, $append = "",$total_rows, $page=1, $pagelink='') 
  {
		if(empty($this->db)){
			$this->db = $db;
		}
		$this->pagination($db, $sql, $rows_in_page, $links_per_page, $append ,$total_rows, $page, $pagelink);
		$this->rows_per_page = $rows_in_page;
		$this->paginate();
		$this->renderFullNav();
		$this->setDebug(0);
  }

	
	public function pagination($db, $sql, $rows_per_page = 10, $links_per_page = 5, $append = "",$total_rows, $page=1, $pagelink) 
	{
		$this->db = $db;
		$this->sql = $sql;
		$this->total_rows = $total_rows;
		$this->rows_per_page = (int)$rows_per_page;
		if (intval($links_per_page ) > 0) {
			$this->links_per_page = (int)$links_per_page;
		} else {
			$this->links_per_page = 5;
		}
		$this->append = $append;
		//$this->php_self = htmlspecialchars($_SERVER['PHP_SELF']);
		$this->php_self= $pagelink!=''?$pagelink:htmlspecialchars($_SERVER['PHP_SELF']);
		$this->page = $page;
		if (isset($_GET['page'])) {
			$this->page = intval($_GET['page'] );
		}
	}
	
	/**
	 * Executes the SQL query and initializes internal variables
	 *
	 * @access public
	 * @return resource
	 */
	public function paginate() 
	{
		//Max number of pages
		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );
		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}
		
		//Check the page value just in case someone is trying to input an aribitrary value
		if ($this->page > $this->max_pages || $this->page <= 0) {
			$this->page = 1;
		}
		
		//Calculate Offset
		$this->offset = $this->rows_per_page * ($this->page - 1);
		
		//Fetch the required result set
		$rs = ($this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}" );
		
		return $rs;
	}
	
	/**
	 * Display the link to the first page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'
	 * @return string
	 */
	public function renderFirst($tag = 'First') 
	{
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == 1) {
			return "$tag ";
		} else {
			return '<a style="text-decoration: none; color: rgb(88, 32, 109);" href="' . $this->php_self . '/1/' . $this->append . '">' . $tag . '</a> ';
		}
	}
	
	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
	public function renderLast($tag = 'Last') 
	{
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == $this->max_pages) {
			return $tag;
		} else {
			if(empty($this->append)){
				return ' <a style="text-decoration: none; color: rgb(88, 32, 109);"  href="' . $this->php_self . '/' . $this->max_pages . '">' . $tag . '</a>';
			}
			
			return ' <a style="text-decoration: none; color: rgb(88, 32, 109);"  href="' . $this->php_self . '/' . $this->max_pages . '/' . $this->append . '">' . $tag . '</a>';
		}
	}
	
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
	public function renderNext($tag = '&gt;&gt;') 
	{
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page < $this->max_pages) {
		if(empty($this->append)){
				return '<a style="text-decoration: none; color: rgb(88, 32, 109);"  href="' . $this->php_self . '/' . ($this->page + 1) . '">' . $tag . '</a>';
			}
			return '<a style="text-decoration: none; color: rgb(88, 32, 109);"  href="' . $this->php_self . '/' . ($this->page + 1) . '/' . $this->append . '">' . $tag . '</a>';
		} else {
			return $tag;
		}
	}
	
	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	public function renderPrev($tag = '&lt;&lt;') 
	{
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page > 1) {
			if(empty($this->append)){
				return ' <a style="text-decoration: none; color: rgb(88, 32, 109);"  href="' . $this->php_self . '/' . ($this->page - 1) . '">' . $tag . '</a>';
			}
			return ' <a style="text-decoration: none; color: rgb(88, 32, 109);"  href="' . $this->php_self . '/' . ($this->page - 1) . '/' . $this->append . '">' . $tag . '</a>';
		} else {
			return " $tag";
		}
	}
	
	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	public function renderNav($prefix = '<span class="page_link">', $suffix = '</span>') 
	{
		if ($this->total_rows == 0)
			return FALSE;
		
		$batch = ceil($this->page / $this->links_per_page );
		$end = $batch * $this->links_per_page;
		if ($end == $this->page) {
			//$end = $end + $this->links_per_page - 1;
		//$end = $end + ceil($this->links_per_page/2);
		}
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';
		
		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page) {
				$links .= $prefix . " $i " . $suffix;
			} else {
				$str = '';
				if (!empty($this->append)){
					$str = "/$this->append";
				}
					$links .= ' ' . $prefix . '<a  style="text-decoration: none; color: rgb(88, 32, 109);"  href="' . $this->php_self . '/' . $i .$str.  '">' . $i . '</a>' . $suffix . ' ';
				
			}
		}
		
		return $links;
	}
	
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	public function renderFullNav() 
	{
		return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();
	}
	
	/**
	 * Set debug mode
	 *
	 * @access public
	 * @param bool $debug Set to TRUE to enable debug messages
	 * @return void
	 */
	public function setDebug($debug) 
	{
		$this->debug = $debug;
	}
}
?>
