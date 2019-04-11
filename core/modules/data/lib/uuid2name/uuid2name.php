<?php

function uuid2name_sc($params) {
	$resource = get_param_value($params, 'resource', current($params));
	$uuid = get_param_value($params, 'uuid', end($params));
	$data = data_read($resource, $uuid);
	if (empty($data)) {
		echo '(Empty)';
		return;
	}
	if (isset($data['title'])) {
		echo $data['title'];
		return;
	}
	if (isset($data['name'])) {
		echo $data['name'];
		return;
	}
	if (!empty($uuid) && !empty($resource)) {
		echo $resource . '.' . $uuid;
		return;
	}
	echo '(Unknown)';
}