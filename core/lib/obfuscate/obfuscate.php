<?php

function obfuscate_sc($params) {
	$txt = implode(' ', $params);
	$result = '<span class="nb-obfs">';
	for ($i = 0; $i < strlen($txt); $i++) {
		$result .= obfuscate_rnd(rand(1,6));
		$result .= $txt[$i];
		$result .= obfuscate_rnd(rand(1,6));
	}
	$result .= '</span>';
	return $result;
}

function obfuscate_rnd($length=4) {
	$tags = array('<span>', '<i>', '<strong>', '<b>', '<small>');
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$tag = $tags[mt_rand(0, count($tags) - 1)];
	$result = $tag;
	$result .= substr(str_shuffle(str_repeat($chars, ceil($length/strlen($chars)) )), 1, $length);
	$result .= '</' . substr($tag, 1);
	return $result;
}