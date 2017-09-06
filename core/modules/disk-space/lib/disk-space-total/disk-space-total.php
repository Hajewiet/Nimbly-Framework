<?php

function disk_space_total_sc() {
	$bytes = disk_total_space($GLOBALS['SYSTEM']['file_base']);
	return intval($bytes/(1024*1024*1024));
}