<?php
/*
 *  @description Class with the main methods. With this class, you don't need to type /foo/bar, only /foobar
 *  @author Ricardo 2009-11
 */


class Home extends Database
{
	var $template = '';
	
	function __construct($tpl) {
		$this->template = $tpl;
	}
	
	function smarty() {
		
  		$this->template->assign('hello','It Works with Smarty!');
		$this->template->display('index.tpl');
  		
	}
	
	function savant() {
  		$this->template->hello = 'It Works with Savant!';
		$this->template->display('index.tpl.php');

	}
	
}

?>