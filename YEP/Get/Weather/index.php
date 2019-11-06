<?php 

	// Enable all errors and warnign display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	function get_string_between($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

	// Input(s)
	$hours = (isset($_GET['hours']))? $_GET['hours']: 5;
	$taf = (isset($_GET['taf']))? $_GET['taf']: 'on';
	
	// create curl resource 
	$ch = curl_init(); 
	$arpt_icao = strtoupper($_GET['icao']);
	
	// set url 
	curl_setopt($ch, CURLOPT_URL, 'https://www.aviationweather.gov/metar/data?ids='.$arpt_icao.'&format=raw&date=0&hours='.$hours.'&taf='.$taf); 

	//return the transfer as a string 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	// $output contains the output string 
	$output = curl_exec($ch); 
	$output = get_string_between($output, '<!-- Data starts here -->', '<!-- Data ends here -->');
	
	// close curl resource to free up system resources 
	curl_close($ch);      
	
	if(!isset($_GET['noTitle'])) echo "<h2>Weather at $arpt_icao</h2>";
	
	echo $output;
?>