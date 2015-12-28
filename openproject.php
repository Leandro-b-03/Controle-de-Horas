<?php

$service_url = 'http://epm.svlabs.local/api/v3/colections';
$apiKey = '2519132cdf62dcf5a66fd963946720714061973cedm';
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	'API_KEY: ' . $apiKey
	));
$curl_response = curl_exec($curl);
if ($curl_response === false) {
	$info = curl_getinfo($curl);
	curl_close($curl);
	die('error occured during curl exec. Additioanl info: ' . var_export($info));
}

curl_close($curl);
$decoded1 = json_decode($curl_response,true);
if (isset($decoded1->response->status) && $decoded1->response->status == 'ERROR') {
	die('error occured: ' . $decoded1->response->errormessage);
}
echo 'response ok!';
var_export($decoded1->response);
?>