<?php

function disk_space_free_sc() {
	$bytes = disk_free_space($GLOBALS['SYSTEM']['file_base']);
	return intval($bytes/(1024*1024*1024));
}