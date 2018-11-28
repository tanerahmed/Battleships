<?php
	use App\Controllers\Browser;
	use App\Controllers\Terminal;

	require_once getcwd().'/vendor/autoload.php' ;
	session_start();

	// Console player
	if (php_sapi_name() == 'cli') {
	    $terminal_obj = new Terminal();
	    $terminal_obj->index();
	}else{
	// Web player
		$project_name = "/battleships";
		$link = str_replace($project_name. "/","",$_SERVER['REQUEST_URI']);
		$browser_obj = new Browser($link);
		$browser_obj->index();
	}





