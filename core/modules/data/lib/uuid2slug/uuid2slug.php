<?php

function uuid2slug_sc($params) {
	$resource = get_param_value($params, 'resource', current($params));
	$uuid = get_param_value($params, 'uuid', end($params));
	$data = data_read($resource, $uuid);
	if (isset($data['slug'])) {
		echo $data['slug'];
		return;
	}
	if (isset($data['url'])) {
		echo $data['url'];
		return;
	}
	echo '--slug--';
}