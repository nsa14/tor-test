<?php
    function tor_new_identity($tor_ip='127.0.0.1', $control_port='9150', $auth_code=''){
    $fp = fsockopen($tor_ip, $control_port, $errno, $errstr, 30);
    if (!$fp) return false; //can't connect to the control port

    fputs($fp, "AUTHENTICATE $auth_code\r\n");
    $response = fread($fp, 1024);
    echo 'debug: $response='.$response."\n<br>";
    list($code, $text) = explode(' ', $response, 2);
    if ($code != '250') return false; //authentication failed

    //send the request to for new identity
    fputs($fp, "signal NEWNYM\r\n");
    $response = fread($fp, 1024);
    list($code, $text) = explode(' ', $response, 2);
    if ($code != '250') return false; //signal failed

    fclose($fp);
    return true;
}


if (tor_new_identity('127.0.0.1', '9150', '')) {
    echo "Identity switched!";
}else{
    echo "Identity NOT switched!";
}

$url='http://www.watismijnip.nl/';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:9150");
curl_setopt($ch, CURLOPT_PROXYTYPE, 7);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
$output = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

print_r($output);
print_r($curl_error);


if (tor_new_identity('127.0.0.1', '9150', '')) {
    echo "Identity switched!";
}else{
    echo "Identity NOT switched!";
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:9150");
curl_setopt($ch, CURLOPT_PROXYTYPE, 7);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
$output = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

print_r($output);
print_r($curl_error);
?>