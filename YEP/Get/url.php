<?php 

	// Enable all errors and warnign display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Input(s)
	$url = (isset($_GET['url']))? urldecode($_GET['url']): '';
	
	// create curl resource 
	$ch = curl_init(); 
	
	// set url 
	curl_setopt($ch, CURLOPT_URL, $url); 

	//return the transfer as a string 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	// $output contains the output string 
	$output = curl_exec($ch); 
	
	// close curl resource to free up system resources 
	curl_close($ch);
	
	echo '<base href="'.preg_replace("/^(.*?\.\w*?\/).*?$/mu", "$1", $url).'">';
	echo $output;
	//var_dump( $url );
?>