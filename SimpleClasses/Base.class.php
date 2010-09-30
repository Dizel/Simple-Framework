<?php
/*
 * @description Base class to config smarty and routes
 * @author Ricardo - 2010-09
 * @version 0.1
 */

session_start();
require_once('Database.class.php');
require_once('SimpleConfigs.php');
require_once('SimpleLibs/Smarty/Smarty.class.php');

class Base
{
	
	protected $smarty = '';
	
	public function __construct() {
		
		// smarty init and config
		$this->smarty = new Smarty();
		$this->smarty->debugging = SMARTY_DEBUG;
		$this->smarty->template_dir = MAIN_SIMPLE_PATH.'/templates/';
		$this->smarty->compile_dir = MAIN_SIMPLE_PATH.'/SimpleClasses/templates_c/';
		$this->smarty->cache_dir = MAIN_SIMPLE_PATH.'/SimpleClasses/cache/';
		$this->smarty->config_dir = MAIN_SIMPLE_PATH.'/SimpleClasses/configs/';
	}
	
	
	public function goPath($path) {
		
		// clear some / in url's end
		if(substr($path,-1)=='/') {
			$path = substr($path,0,-1);	
		}
		
		// replace - by _
		$path = str_replace('-', '_', $path);
		
		 if(strpos($path,'/')!==false) {
			// two paths means it's inside some class
			$path = explode('/', strtolower($path));
			
			$page = new $path[0]($this->smarty);
			
			// check if we have the method
			$exists = method_exists($page,$path[1]);
			if($exists===true) {
				$page->$path[1]();
			} else {
				// no, no method for you :(
				// call only the template
				$this->smarty->display($path[0] . '/' . $path[1] . '.tpl');
			}
		} else {
			// last chance: it's in Home class
			$path = strtolower($path);
			$home = new Home($this->smarty);
			
			if($path == '') {
				// no specific method, send to index
				$path = 'index';
			}
			
			// check if we have the method
			$exists = method_exists($home,$path);
			if($exists===true) {
				$home->$path();
			} else {
				// no, no method for you :(
				// call only the template
				$this->smarty->display(HOME_PATH . '/' . $path . '.tpl');
			}
			
		}
	}
	
}

function print_me($arr, $stop = 1) {
	echo '<pre>' . print_r($arr,true) . '</pre>';
	if($stop==1) exit;
}

// função de autoload do php para pegar direto as clases sem precisar dar require once para cada uma
function __autoload($class_name) {
    require_once './' . CLASS_FILES_PATH . '/' . $class_name . '.class.php';
}

?>