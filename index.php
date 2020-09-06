<!-- <META http-equiv="refresh" content="5;">  -->
<?php


// CircuitBuildTimeout 1
// LearnCircuitBuildTimeout 120
// #NewCircuitPeriod 1
// MaxCircuitDirtiness 1

## ExitNodes {gb},{fr},{de},{us}
## StrictNodes 1
## 
## 
// header("Refresh:5; url=".$_SERVER['PHP_SELF'].'?999');


function tor_new_identity($tor_ip='127.0.0.1', $control_port='9150', $auth_code='""'){
    $fp = fsockopen($tor_ip, $control_port, $errno, $errstr, 30);
    if (!$fp) return false; //can't connect to the control port
     
    fputs($fp, "AUTHENTICATE $auth_code\r\n");
    $response = fread($fp, 1024);
    print_r($response);
    //list($code, $text) = explode(' ', $response, 2);
    //if ($code != '250') return false; //authentication failed
     
    //send the request to for new identity
    fputs($fp, "signal NEWNYM\r\n");
    // fputs($fp, 'AUTHENTICATE ""\r\nsignal NEWNYM\r\nQUIT');
    $response = fread($fp, 1024);
    //list($code, $text) = explode(' ', $response, 2);
    //if ($code != '250') return false; //signal failed
     
    fclose($fp);
    return true;
}

// if (tor_new_identity('127.0.0.1', '9150')) {
//     echo "Identity switched!";
//     //$a =  get_data("https://eimenisatis.com/",1);
// }else{
//     echo "Identity NOT switched!";
//     //$a =  get_data("https://eimenisatis.com/",0);
// }





function get_data($url,$useTor) {
$ch = curl_init();


$ua = array('Mozilla', 'Opera', 'Microsoft Internet Explorer', 'ia_archiver');
$op = array('Windows', 'Windows XP', 'Linux', 'Windows NT', 'Windows 2000', 'OSX');
$agent = $ua[rand(0, 3)] . '/' . rand(1, 8) . '.' . rand(0, 9) . ' (' . $op[rand(0, 5)] . ' ' . rand(1, 7) . '.' . rand(0, 9) . '; en-US;)';
    
// Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.67 Safari/537.36

curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);//TRUE
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_HEADER, FALSE);//FALSE
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com'); 
curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true); 
 
if ($useTor==1) {
    curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:9150');
    curl_setopt($ch, CURLOPT_PROXYTYPE, 7);
}
 
$data = curl_exec($ch);
//$info = curl_getinfo($ch);
curl_close($ch);

//print_r($info);   
//return $data;
}



$useTor = 1; // 1 - use TOR | 0 - do not use TOR
$url2 = "https://www.myglobalip.com/";
$url = "http://eimenisatis.com/";
$url3 = "https://api.ipify.org/";

$urltelegram = "https://t.me/project_nn/4";

$remoteaddr = "https://www.plus2net.com/php_tutorial/php_ip.php";

  get_data($remoteaddr,$useTor);
//echo get_data($url3,$useTor);


// tor_new_identity();
// 
// 
// exec("sudo service tor restart", $ioOut);
// print_r($ioOut); //output from shell after executing the command
// // sleep(25);


















// ==================================================================

// $fp = fsockopen('127.0.0.1', 9150, $errno, $errstr, 30);
// $auth_code = 'YOUR_PASSWORD';
// if ($fp) {
//     echo "Connected to TOR port<br />";
// }
// else {
//     echo "Cant connect to TOR port<br />";
// }

// fputs($fp, "AUTHENTICATE \"".$auth_code."\"\r\n");
// $response = fread($fp, 1024);
// list($code, $text) = explode(' ', $response, 2);
// if ($code = '250') {
//     echo "Authenticated 250 OK<br />";
// }
// else {
//     echo "Authentication failed<br />";
// }

// fputs($fp, "SIGNAL NEWNYM\r\n");
// $response = fread($fp, 1024);
// list($code, $text) = explode(' ', $response, 2);
// if ($code = '250') {
//     echo "New Identity OK<br />";
// }
// else {
//     echo "SIGNAL NEWNYM failed<br />";
//     die();       
// }
// fclose($fp);


//==================================================================================================================================================================================================================
// $ip = '127.0.0.1';
// $port = '9150';
// $auth = 'PASSWORD';
// $command = 'signal NEWNYM';
 
// $fp = fsockopen($ip,$port,$error_number,$err_string,10);
// if(!$fp) { echo "ERROR: $error_number : $err_string";
//     return false;
// } else {
//     fwrite($fp,"AUTHENTICATE \"".$auth."\"\n");
//     $received = fread($fp,512);
//     fwrite($fp,$command."\n");
//     $received = fread($fp,512);
// }
 
// fclose($fp);
 
// // $ch = curl_init();
// // curl_setopt($ch, CURLOPT_URL, "https://t.me/project_nn/3");
// // curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:9150");
// // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
// // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// // curl_setopt($ch, CURLOPT_VERBOSE, 0);
// // $response = curl_exec($ch);

// echo $received;
//==================================================================================================================================================================================================================
?>