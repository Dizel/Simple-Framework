<?php
    
    /* CHOOSE THE TEMPLATE SYSTEM YOU WANT */
    define(TEMPLATE_SYSTEM, 'savant');
    //define(TEMPLATE_SYSTEM, 'smarty');
    
    /* BASIC CONFIGS YOU SHOULD CHANGE */
    define(DB_HOST,'localhost');
	define(DB_NAME,'mysql');
	define(DB_USER,'root');
	define(DB_PASS,'');
    
    /* SET IT TO TRUE IF YOU WANT TO DEBUG */
    define(SMARTY_DEBUG, true);
    
    /* CHANGE IT IF YOU DON'T LIKE THE NAME */
    define(CLASS_FILES_PATH,'classes');
	
	
	/* MAYBE YOU WON'T NEED TO CHANGE HERE */
	define(MAIN_SIMPLE_PATH,str_replace('SimpleClasses','',dirname(__FILE__)));
	define(HOME_PATH,'home');
	
?>