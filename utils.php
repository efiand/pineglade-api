<?php

function response($data, $ok = true) {
	$data['ok'] = $ok;

	exit(json_encode($data, JSON_UNESCAPED_UNICODE));
}

function fetch($url, $headers) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);

	curl_close($ch);

	return $response;
}
