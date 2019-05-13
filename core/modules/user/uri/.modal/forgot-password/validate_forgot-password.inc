<?php

load_library('get-user', 'user');
load_library("json", "api");

$user = get_user();
if (!empty($user)) {
	return json_result(['message' => 'You are logged in'], 400);
}