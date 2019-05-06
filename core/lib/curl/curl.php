<?php

function _curl_init($url, $headers=false) {
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if (!empty($headers)) {
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	}
	return $ch;
}

function _curl_exec($ch) {
	$response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $errno = curl_errno($ch);
    curl_close($ch);
    if($http_code != 200 || $errno) {
        load_library('log');
        log_system('curl_get returned invalid reponse code (' . $http_code . ') or error code: ' . $errno);
    }
    return $response;
}

function curl_get($url, $headers=false, $return_type='json') {
	$ch = _curl_init($url, $headers);
    $response = _curl_exec($ch);
    return curl_result($response, $return_type);
}

function curl_post($url, $headers, $payload, $return_type='json') {
    $ch = _curl_init($url, $headers, $payload);
    curl_setopt($ch, CURLOPT_POST, true);   
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $response = _curl_exec($ch);
    return curl_result($response, $return_type);
}

function curl_result($response, $return_type='json') {
	if ($return_type === 'json') {
    	return json_decode($response, true);
    } else if ($return_type === 'query') {
    	$data = [];
    	parse_str($response, $data);
    	return $data;
    } else {
    	return $response;
    }
}