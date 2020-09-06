<?php
//https://getproxylist.com/#pricing
//https://gimmeproxy.com/#api

function get_data($url,$useTor) {
$ch = curl_init();
 
curl_setopt($ch, CURLOPT_USERAGENT,'NSA_Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.67 Safari/537.36');
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
 
if ($useTor==1) {
    curl_setopt($ch, CURLOPT_PROXY, '110.232.74.55:8080');
    //curl_setopt($ch, CURLOPT_PROXYTYPE, 1);
}
 
$data = curl_exec($ch);
curl_close($ch);
return $data;
}



$useTor = 1; // 1 - use TOR | 0 - do not use TOR
$url2 = "https://www.myglobalip.com/";
$url = "https://eimenisatis.com/";

echo get_data($url,$useTor);


?>