<?php 

	// Enable all errors and warnign display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
        // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, "https://www.aviationweather.gov/metar/data?ids=cyul&format=raw&date=0&hours=5&taf=on"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch);
		
		echo '<textarea>'.$output.'</textarea>';
		echo '<textarea>'.str_replace('/metar/data','https://www.aviationweather.gov/metar/data',$output).'</textarea>';

        // close curl resource to free up system resources 
        curl_close($ch);      
		
		//echo $output;
?>