<?php

//header("Content-Type: text/plain; charset=utf-8");    
//header("Content-Type: text/html; charset=utf-8");    
//header("Content-type: text/plain; charset=utf-8");
	// Enable all errors and warnign display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
    include_once(dirname(__FILE__).'/../../includes/definitions.inc.php');
    
    include_once(dirname(__FILE__).'/../../resources/airports.lib.inc.php');
    
    $fltplan_fir_acc_user = 'CZUL';
    $fltplan_fir_acc_pass = 'czul1337';


	// Input(s)
	$icao = (isset($_GET['icao']))? strtoupper($_GET['icao']): '';
	$tmp = (isset($_GET['tmp']))? $_GET['tmp']: time();
	$cookie = (isset($_GET['cookie']))? $_GET['cookie']: '';
    //$ckfile = tempnam(sys_get_temp_dir(), "CURLCOOKIE");
    
    $ckfile = dirname(__FILE__).'/../../tmp/CURLCOOKIE.data.'.$tmp.'.txt';
    

if(!isset($_GET['step2']))
{ 
header("Content-Type: text/html; charset=utf-8");
        echo "<br><br>";
        echo "\n";
        echo "\n";

    $ch = curl_init('https://www.fltplan.com/');
    $headers = [
        'Host: ww11.fltplan.com',
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: en-US,en;q=0.9',
        'Content-Type: application/x-www-form-urlencoded;',
        'Connection: keep-alive',
        //'Cookie: __cfduid=de618785b5eab6e7711cd5d10d343ff951573026149; utag_main=v_id:016e4061476b0020861b117165840004d001800d00918$_sn:3$_ss:1$_st:1573099449644$ses_id:1573097649644%3Bexp-session$_pn:1%3Bexp-session; fbotracking=RT2; fbotrackingcrn=36717',
        'If-None-Match: 0243b497b58d21:0',
        'Origin: https://fltplan.com',
        'Referer: https://fltplan.com/',
        'Upgrade-Insecure-Requests: 1',
        'Pragma: no-cache',
        'Cache-Control: no-cache',
        'TE: Trailers',
    ];

    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    // Submit the POST request
    $result = curl_exec($ch);
    $result = zlib_decode($result);
 
    // Close cURL session handle
    curl_close($ch);


    
    echo "<br><br>";
    echo "\n\n";
    echo "<br><br>";
    echo "\n\n";
    var_dump($result);
    
    echo "<br><br>";
    echo "\n\n";
    echo "<br><br>";
    echo "\n\n";
    echo " YEAH YEAH";
    echo "<br><br>";
    echo "\n\n";
    echo "<br><br>";
    echo "\n\n";

    $ch = curl_init('https://tags.tiqcdn.com/utag/garmin/main/prod/utag.js');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array() );
    curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    // Submit the POST request
    $result = curl_exec($ch);

    // Close cURL session handle
    curl_close($ch);

    ?>
    <script>
//
//	Function(s)
//
String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

    <?=$result?>;
    
    window.cookeValueFullStr; window.cookeValueFullStr=document.cookie;
    console.log(cookeValueFullStr);
    cookeValueFullStr = 'fbotracking=CZUL; fbotrackingcrn=94206; ' + encodeURIComponent(cookeValueFullStr);
    /*
    async function saveCookieForCurl(tmp, cookie) {

        try {
          const response = await fetch('http://rt-2.net/YEP/Set/Cookie/?cookie=' + cookie + '&tmp=' + tmp , {
            method: 'GET'//,
            //body: formData
          });
          location.replace('http://rt-2.net/YEP/Get/FPlanCharts/?<?=http_build_query($_GET)?>&step2');
        } catch (error) {
          console.error('Error:', error);
        }
        return true;
    }
    saveCookieForCurl(<?=$tmp?>, cookeValueFullStr);
    */

    let redirectUrl = 'http://rt-2.net/YEP/Get/FPlanCharts/?<?=http_build_query($_GET)?>&step2=&cookie=' + cookeValueFullStr;
    console.log(redirectUrl);
    //location.replace(redirectUrl);
    </script>
    <?php
}




if(isset($_GET['step2']))
{   
header("Content-Type: text/plain; charset=utf-8");
var_dump($cookie);    
//var_dump($ckfile);
    $data = array(
        'username' => $fltplan_fir_acc_user,
        'password' => $fltplan_fir_acc_pass,
        'Browser' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0',
    );
    $post_data = json_encode($data);
        var_dump($post_data);
    // Prepare new cURL resource
    $ch = curl_init('https://www.FltPlan.com/AwRegUserCk.exe?a=1');
    $headers = [
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: en-US,en;q=0.9',
        'Cache-Control: max-age=0',
        'Content-Length: '.strlen($post_data),
        'Content-Type: application/x-www-form-urlencoded',
        //'Cookie: __cfduid=de618785b5eab6e7711cd5d10d343ff951573026149; utag_main=v_id:016e4061476b0020861b117165840004d001800d00918$_sn:3$_ss:1$_st:1573099449644$ses_id:1573097649644%3Bexp-session$_pn:1%3Bexp-session; fbotracking=RT2; fbotrackingcrn=36717',
        'Cookie: '.$cookie,
        'Origin: https://fltplan.com',
        'Referer: https://fltplan.com/',
        'sec-fetch-mode: navigate',
        'sec-fetch-site: same-site',
        'sec-fetch-user: ?1',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36',
    ];
    foreach($headers as $hstr){
        //echo '<br>';    
        //var_dump($hstr);

    }
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
    //curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    foreach($headers as $hstr){
        echo "<br>";
        echo "\n";
        //var_dump($hstr);

    }
    // Submit the POST request
    $result = curl_exec($ch);
    $result = zlib_decode($result);
    $info = curl_getinfo($ch);
    var_dump($info);

    // Close cURL session handle
    curl_close($ch);

    
    echo "<br><br>";
    echo "\n\n";
    echo "<br><br>";
    echo "\n\n"; 
    var_dump($result);
    /*
    $data = array(
        'CRN10' => '36717',
        'CARRYUNAME' => $fltplan_fir_acc_user,
        'MODE' => 'SEARCH',
        'AIRPORTSEL' => $icao,
    );
 
    // Prepare new cURL resource
    $ch = curl_init('https://www.fltplan.com/AwListAppPlates.exe?a=1');


    //var_dump( $data);
    //var_dump( http_build_query($data));
    //var_dump( strlen(http_build_query($data)));
    */
    $headers = [
        'Host: www.fltplan.com',
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: en-US,en;q=0.9',
        'Content-Type: application/x-www-form-urlencoded;',
        'Content-Length: '.strlen(http_build_query($data)),
        'Connection: keep-alive',
        //'Cookie: fbotracking=RT2; fbotrackingcrn=36717',
        'Cookie: '.$cookie,
        'Origin: https://www.fltplan.com',
        'Referer: https://www.fltplan.com/AwMainToApproachPlates.exe?a=1',
        'Upgrade-Insecure-Requests: 1',
        'Pragma: no-cache',
        'Cache-Control: no-cache',
        'TE: Trailers',
    ];
    /*
    foreach($headers as $hstr){
        echo "<br>";
        echo "\n";
        var_dump($hstr);

    }
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
    //curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    // Submit the POST request
    $result = curl_exec($ch);
    $result = zlib_decode($result);
 
    // Close cURL session handle
    curl_close($ch);
 
    echo "<br><br>";
    echo "\n\n";
    echo "<br><br>";
    echo "\n\n";
    //var_dump( urldecode($result));
    */
    }
?>