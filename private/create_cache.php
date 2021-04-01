<?php

$breakline = "\r\n";

// getting apikey
$apikeyFile = fopen(__DIR__ . '/apikey', 'r');
$apikey = fread($apikeyFile, filesize(__DIR__ . '/apikey'));
fclose($apikeyFile);

$url = 'http://data.fixer.io/api/latest?access_key=' . $apikey;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$r = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($r === false) {
	echo 'Failed to update cache for fixer.io' . $breakline;
	exit();
}
if ($http_code != 200) {
	echo 'Failed to update cache for fixer.io (HTTP '. $http_code . ')' . $breakline;
	exit();
}

$rj = json_decode($r, true);

// checking for the ['rates']
if (!array_key_exists('rates', $rj)) {
	echo 'Failed to update cache for fixer.io (rates not found in return)' . $breakline;
	exit();
}

// https://bugs.php.net/bug.php?id=72567
// https://stackoverflow.com/questions/42981409/php7-1-json-encode-float-issue
if (version_compare(phpversion(), '7.1', '>=')) {
	ini_set('serialize_precision', -1 );
}

// write rates to file
$cache = json_encode($rj['rates']);
$cachefile = fopen(__DIR__ . '/../cache.json', 'w');
fwrite($cachefile, $cache);
fclose($cachefile);
