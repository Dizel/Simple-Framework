<?php
    require_once('SimpleClasses/Base.class.php');
	
	$b = new Base();
	
	//echo '<br>';
	$path = $_GET['module'];
	
	$b->goPath($path)
?>
