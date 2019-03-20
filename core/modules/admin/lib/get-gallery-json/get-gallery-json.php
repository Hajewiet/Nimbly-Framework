<?php

function get_gallery_json_sc($params) {
	$uuid = get_param_value($params, 'uuid');
	$name = get_param_value($params, 'name');
	$max = get_param_value($params, 'max');
	load_library('get');
	load_library('data');
	$result = array(
		'name' => $name, 
		'uuid' => $uuid,
		'max' => $max,
		'images' => array(),
		'image_names' => array());
	$j = 0;
	for ($i = 0; $i < $max; $i++) {
		$img = get_variable('record' . '.' . $name . $i);
		if (empty($img)) {
			continue;
		}
		$result['images'][$j] = $img;
		$result['image_names'][$j] = data_read('.files_meta', $img, 'name');
		$j++;
	}
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
}