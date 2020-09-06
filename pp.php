<?php
$url = 'https://www.plus2net.com/php_tutorial/php_ip.php';
$ip  = '127.0.0.1:9150'; // trying to spoof ip..

$header[0]  = "Accept: text/xml,application/xml,application/xhtml+xml,"; 
$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";

$header[] = "Cache-Control: max-age=0"; 
$header[] = "Connection: keep-alive"; 
$header[] = "Keep-Alive: 300"; 
$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7"; 
$header[] = "Accept-Language: en-us,en;q=0.5"; 
$header[] = "Pragma: "; // browsers = blank
$header[] = "X_FORWARDED_FOR: " . $ip;
$header[] = "REMOTE_ADDR: " . $ip;
$header[] = "Host: www.eimenisatis.com";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url); 
curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)'); 
curl_setopt($curl, CURLOPT_HTTPHEADER, $header); 
curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com'); 
curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate'); 
curl_setopt($curl, CURLOPT_AUTOREFERER, true); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($curl, CURLOPT_TIMEOUT, 10); 
curl_setopt($curl, CURLOPT_VERBOSE, 1); 
curl_setopt($curl, CURLOPT_PROXY, '94.244.44.67:59374');
  
/* alt testing..

$curl = curl_init();
curl_setopt_array(
	$curl, array(
		CURLOPT_URL => $url,
		// CURLOPT_TIMEOUT => 15,
		// CURLOPT_HEADER => true,
		// CURLOPT_NOBODY => true,
		// CURLOPT_VERBOSE => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_REFERER => $url,
		CURLOPT_HTTPHEADER, array('REMOTE_ADDR: '.$ip, 'X_FORWARDED_FOR: '.$ip, 'Host: subdomain.hostname.com'),
		CURLOPT_USERAGENT, 'Mozilla Batman 3.0',
		CURLOPT_INTERFACE, $ip,
	)
);

*/

$response = curl_exec($curl);

if ($response === false) {
	
	die('Error '. curl_errno($curl) .': '. curl_error($curl));
	
} else {
	
	echo '<div>';
	print_r($response);	
	echo '</div>';
	echo '<br><br>';
	echo '<div>' . urldecode($url) . '</div>';
	
}

curl_close($curl);
exit;















// $url = "http://www.eimenisatis.com";
// $ch = curl_init($url);

// 		// curl_setopt($ch, CURLOPT_COOKIE, "aa ee");
// 		curl_setopt($ch, CURLOPT_POST, 1);
// 		// curl_setopt($ch, CURLOPT_POSTFIELDS, "field1=value1&field2=value2");
// 		curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/search?source=hp&ei=a8lvXPjYE4z3kwXtwLaQCg&q=eimenisatis&btnK=Google+Search&oq=eimenisatis&gs_l=psy-ab.3..0i13l10.1421.3537..3747...0.0..0.405.2392.0j8j1j1j1......0....1..gws-wiz.....0..0j0i10j0i30j0i10i30j0i13i10j0i13i30j0i13i10i30.OdpQSR7YzCc');
//         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
// 		curl_setopt($ch, CURLOPT_VERBOSE, 1);		
// 		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
// 		curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
// 		curl_setopt($ch, CURLOPT_PROXY, "77.104.74.114:8080");
// 		curl_setopt($ch, CURLOPT_HTTPHEADER,
// 			array(
// 			"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
// 			"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3",
// 			"Accept-Language: en-US,en;q=0.8",
// 			"Cache-Control: max-age=0",
// 			"Connection: keep-alive",
// 			"Content-Type: application/x-www-form-urlencoded",
// 			"User-Agent:".$_SERVER['HTTP_USER_AGENT']
// 			));
			
// 		$response = curl_exec($ch);
// 		print_r($response);
?>