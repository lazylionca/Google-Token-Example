<?php

// use php curl to fetch initial access token & refresh token for use with google api.
// adapted from John Slegers suggestion on:
// http://stackoverflow.com/questions/8902376/php-how-to-get-the-access-token-authenticating-with-oauth-2-0-for-google-api

// requires your project 'client ID' & 'client secret' from https://console.developers.google.com/apis/library
// for some inane reason, google puts this in a dimensional json array

// requires human interaction to authenticate user account.  run this once.
// refresh-ga-token.php can then be run automatically whenever needed.
// refresh token will be saved for future use as it does not expire.

// please ensure the 'jsonKeys' folder exists in your home folder or somewhere secure.
$folder = posix_getpwuid( posix_getuid())['dir']. '/jsonKeys/';


// file that tokens will be written to
$tokenFile = $folder . 'google_api_tokens.json';


// read client_id and client_secret from json file
$clientFile = $folder . 'google_api_client.json';
$data = json_decode(file_get_contents($clientFile),true);
$data = $data[web];

$url = "https://accounts.google.com/o/oauth2/";

if ( !isset($_GET['code']) ) {

	// Step 1: Get user to authenticate & get access code
	$params = array(
		"redirect_uri"  => 'https://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"],
		"client_id" 	=> $data[client_id],
		"response_type" => "code",
		"scope" 		=> "https://www.google.com/m8/feeds",
		"access_type" 	=> "offline",
		"approval_prompt"=> "force"				// these last two force a refresh token
	);

	$request_to = $url . 'auth' . '?' . http_build_query($params);
	header("Location: " . $request_to);			// have the broswer 'get' the google login screen

} else {

	// Step 2:  Use code to get an access token & refresh token
	$params = array (
		"redirect_uri" => 'https://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"],
		"client_id" => $data[client_id],
		"client_secret" => $data[client_secret],
		"code" => $_GET['code'],
		"grant_type" => "authorization_code"
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url . 'token');
	curl_setopt($ch, CURLOPT_POST, true);			// post, not get
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	// return to string instead of printing it

	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);

	if ($info['http_code'] === 200) {

		$tokenData=json_decode($output,true);
		$tokenData[updated] = date("m/d/y");
		$tokenData[expires] = (time()+$tokenData[expires_in]);
		$tokenData=json_encode($tokenData, JSON_PRETTY_PRINT);

// 		write to file
		file_put_contents($tokenFile, $tokenData);
		echo 'Success';
	} else {
		echo "<pre>fail";
		print_r($info);
		print_r($output);
	}
}

?>