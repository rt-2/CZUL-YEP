<?php 
    header("Content-type: application/json; charset=utf-8");
	// Enable all errors and warnign display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
    include_once(dirname(__FILE__).'/../../includes/definitions.inc.php');
    
    include_once(dirname(__FILE__).'/../../resources/airports.lib.inc.php');


	// Input(s)
	$icao = (isset($_GET['icao']))? strtoupper($_GET['icao']): '';

	$output = GetAirportPosition($icao);
	
	echo json_encode($output);
?>