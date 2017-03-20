<?php

if ( isset($_GET['q']) ) {
	echo "<pre>\n";
	// 	print_r(queryGoogle($_GET['q']));
	var_dump(queryGoogle($_GET['q']));
}

// use curl to query google contacts

function queryGoogle ($q) {

	// query should be numbers or letters only, no brackets, dashes, spaces or other.

	if ( !isset($q) ) { $names[error]='no query'; return $names;}
	$names[q] = preg_replace('/[^A-Za-z0-9]/', '', $q);


	// retreive access token
	$tokenData = include 'refresh-ga-token.php';
	if ($tokenData==null) { $names[error]='token failed'; return $names;}

	$url="https://www.google.com/m8/feeds/contacts/default/full?alt=json&q=" . $names[q];

	$header = array (
		"Gdata-version: 3.0",
		"Authorization: $tokenData[token_type] $tokenData[access_token]"
	);


	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);			// get, not post
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	// return to string instead of printing it

	$result = curl_exec($ch);
	$result = json_decode($result,true);
	$info = curl_getinfo($ch);
	curl_close($ch);

	// Check HTTP status code
	if ($info['http_code'] === 200) {

		// $t is NOT a variable, it's actually an array key name returned by google. WTF?
		$names[account] = $result['feed']['id']['$t'];
		$names[total_results] = $result['feed']['openSearch$totalResults']['$t'];
		$c="";
		for ($x = 0; $x < $names[total_results]; $x++) {

			// We add * to all our work contact names to differeniate them from personal contacts.
			// Some results are returned with a comma on the end of the name, not sure why.
			// use rtrim to clean things up.

			$n = $result['feed']['entry'][$x]['gd$name']['gd$fullName']['$t'];

			$n = rtrim($n, '*');
			$n = rtrim($n, ' ');
			$n = rtrim($n, ',');

			$names['list'] .= $c . $n;
			$c=", ";
		}
	} else {
		$names[error]='curl failed';

	}
	return $names;
}
?>