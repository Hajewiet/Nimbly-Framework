<?php

require_once("LoremIpsum.class.php");

/**
 * @doc `[ipsum words=100]` generates lorum ipsum text (for prototyping)
 */
function ipsum_sc($params) {

	static $IpsumGenerator = null;
  	if ($IpsumGenerator === null) {
     	$IpsumGenerator = new LoremIpsumGenerator();
  	}

    $words = get_param_value($params, 'words', 200);
    $format = get_param_value($params, 'format', 'txt');
    return $IpsumGenerator->getContent($words, $format);
}
