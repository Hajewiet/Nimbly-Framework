<?php

function ipsum_sc($params) {
    require_once("LoremIpsum.class.php");
    $words = get_param_value($params, 'words', 200);
    $format = get_param_value($params, 'format', 'txt');
    $generator = new LoremIpsumGenerator;
    return $generator->getContent($words, $format);
}
