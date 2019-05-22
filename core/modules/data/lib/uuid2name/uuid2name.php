<?php

function uuid2name_sc($params) {
	static $results = [];
	$resource = get_param_value($params, 'resource', current($params));
	$uuid = get_param_value($params, 'uuid', end($params));
	$hkey = md5($resource . $uuid);
	if (isset($results[$hkey])) {
		echo $results[$hkey];
		return;
	}
	$data = data_read($resource, $uuid);
	if (empty($data)) {
		$result = '(Empty)';
	} else if (isset($data['title'])) {
		$result = $data['title'];
	} else if (isset($data['name'])) {
		$result = $data['name'];
	} else if (!empty($uuid) && !empty($resource)) {
		$result = $resource . '.' . $uuid;
	}
	$results[$hkey] = $result;
	echo $result;
}