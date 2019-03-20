<?php

load_library('uri-path');
load_library('log');

function cur_path_sc() {
	log_system('call to [cur-path] deprecated. replace with [get-path] or [uri-path]');
	return uri_path_sc();
}