<?php

$GLOBALS['ALL_AIRPORTS'] = array_map('str_getcsv', file(dirname(__FILE__).'/airports.lib.data.csv'));

//var_dump($GLOBALS['ALL_AIRPORTS']);
function GetAirportPosition($icao)
{
    $ret_arr = array(
"lat"=> null,
"long"=> null,
);
        //echo '<br>';
//var_dump($ret_arr);
    foreach($GLOBALS['ALL_AIRPORTS'] as $this_airport)
    {
        //echo '<br>';
        //var_dump($this_airport);
        //echo '<br>';
        //var_dump($ret_arr);
        if($this_airport[APIDATA_AIRPORTS_ICAO] === $icao)
        {
            $ret_arr["lat"] = $this_airport[APIDATA_AIRPORTS_LAT];
            $ret_arr['long'] = $this_airport[APIDATA_AIRPORTS_LONG];
        }
        //echo '<br><br>';
    }
    return $ret_arr;
}
