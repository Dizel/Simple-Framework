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
require_once('SimpleLibs/Savant/Savant3.php');

class Base
{
	
	protected $template = '';
	
	public function __construct() {
		
		if(TEMPLATE_SYSTEM == 'smarty') {
			// smarty init and config
			$this->template = new Smarty();
			$this->template->debugging = SMARTY_DEBUG;
			$this->template->template_dir = MAIN_SIMPLE_PATH.'/templates/';
			$this->template->compile_dir = MAIN_SIMPLE_PATH.'/SimpleClasses/templates_c/';
			$this->template->cache_dir = MAIN_SIMPLE_PATH.'/SimpleClasses/cache/';
			$this->template->config_dir = MAIN_SIMPLE_PATH.'/SimpleClasses/configs/';
		} else {
			$this->template = new Savant3(array('template_path' => MAIN_SIMPLE_PATH.'/templates/'));
		}
		
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
			
			$page = new $path[0]($this->template);
			
			// check if we have the method
			$exists = method_exists($page,$path[1]);
			if($exists===true) {
				$page->$path[1]();
			} else {
				// no, no method for you :(
				// call only the template
				if(TEMPLATE_SYSTEM == 'smarty') {
					$this->template->display($path[0] . '/' . $path[1] . '.tpl');
				} else {
					$this->template->display($path[0] . '/' . $path[1] . '.tpl.php');
				}
			}
		} else {
			// last chance: it's in Home class
			$path = strtolower($path);
			$home = new Home($this->template);
			
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
				if(TEMPLATE_SYSTEM == 'smarty') {
					$this->template->display(HOME_PATH . '/' . $path . '.tpl');
				} else {
					$this->template->display(HOME_PATH . '/' . $path . '.tpl.php');
				}
			}
			
		}
	}
	
}

function print_me($arr, $stop = 1) {
	echo '<pre>' . print_r($arr,true) . '</pre>';
	if($stop==1) exit;
}

// php autoloading function
function __autoload($class_name) {
    require_once './' . CLASS_FILES_PATH . '/' . $class_name . '.class.php';
}

?>