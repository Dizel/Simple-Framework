<?php
/*
 *  @description Class with the main methods. With this class, you don't need to type /foo/bar, only /foobar
 *  @author Ricardo 2009-11
 */


class Home extends Database
{
	var $smarty = '';
	
	function __construct($smt) {
		$this->smarty = $smt;	
	}
	
	function index() {
		
  		$this->smarty->assign('hello','It Works!');
		$this->smarty->display('index.tpl');
  		
	}
	
	function simple() {
		$this->smarty->assign('simple','It\'s simple, did you see?');
		$this->smarty->display('simple.tpl');

	}
	
}

?>