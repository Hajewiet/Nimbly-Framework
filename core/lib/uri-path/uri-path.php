<?php

// @doc * `[uri-path]` returns the file path of the current uri, e.g. /var/www/ext/uri/css/app.css

function uri_path_sc() {
	return $GLOBALS['SYSTEM']['uri_path'];
}
