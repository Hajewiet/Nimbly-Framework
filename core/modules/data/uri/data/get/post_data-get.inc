<?php

load_library('crud');
load_library('json');
$cat = $all_fields['cat'];
$key = $all_fields['key'];
$setting = $all_fields['setting'];

$result = array(
    'data' => data_load($cat, $key, $setting)
);

return_json($result);
