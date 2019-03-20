<?php

function implode_sc($params) {
	$var_name = get_param_value($params, 'var', current($params));
	$seperator = get_param_value($params, 'sep', ', ');
    load_library('get');
    $data = get_variable($var_name);
    if (!is_array($data) || count($data) < 1) {
    	return "''";
    }
    $first = current($data);
    if (in_array(gettype($first), ['array', 'object'])) {
    	return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    return "'" . join("'" . $seperator . "'", $data) . "'";
 }