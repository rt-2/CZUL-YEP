<?php 
    header("Content-type: application/json; charset=utf-8");
	// Enable all errors and warnign display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);    

	// Input(s)
	$cookie = (isset($_GET['cookie']))? urldecode($_GET['cookie']): '';
	$tmp = (isset($_GET['tmp']))? $_GET['tmp']: time();
    
    $ckfile = dirname(__FILE__).'/../../tmp/CURLCOOKIE.data.'.$tmp.'.txt';

    $file_handle = fopen($ckfile, 'w'); 
    //fwrite($file_handle,
        //'#HttpOnly_.fltplan.com	TRUE	/	FALSE	1604651770	'.
            //str_replace('$cookie

    //);
    fclose($file_handle);

?>