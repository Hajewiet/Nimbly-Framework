<?php

function slug_sc($params) {
	$result = implode(' ', $params);
	$result = strtolower($result);
	$result = preg_replace("![^a-z0-9]+!i", "-", $result);
	return $result;
}