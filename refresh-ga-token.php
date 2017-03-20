<?php

// refresh google user access token

// please ensure the 'jsonKeys' folder exists in your home folder or somewhere secure.
$folder = posix_getpwuid( posix_getuid())['dir']. '/jsonKeys/';

// file where tokens are stored
$tokenFile = $folder . 'google_api_tokens.json';

// read and check status of current token, return if good
$tokenData =  json_decode(file_get_contents($tokenFile),true);
if ($tokenData[expires]>time()) { return $tokenData; }

// token has expired, refresh it

// read client_id and client_secret from json file
$clientFile = $folder . 'google_api_client.json';
$clientData = json_decode(file_get_contents($clientFile),true);
$clientData = $clientData[web];

$url = 'https://accounts.google.com/o/oauth2/token';
$params = array (
	"client_id" 	=> $clientData[client_id],
	"client_secret" => $clientData[client_secret],
	"grant_type" 	=> "refresh_token",
	"refresh_token" => $tokenData[refresh_token]
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);			// post, not get
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	// return to string instead of printing to console

$output = curl_exec($ch);
$output=json_decode($output,true);
$info = curl_getinfo($ch);
curl_close($ch);

if ($info['http_code'] === 200) {

	$tokenData[access_token] = $output[access_token];
	$tokenData[token_type]   = $output[token_type];
	$tokenData[updated] = date("m/d/y");
	$tokenData[expires] = (time()+$tokenData[expires_in]);

	file_put_contents($tokenFile, json_encode($tokenData,JSON_PRETTY_PRINT));
	return $tokenData;

} else {

	echo '<pre>fail';
	print_r($info);
	print_r($output);
	return 'fail';
}
?>