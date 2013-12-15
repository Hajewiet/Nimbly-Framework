<?php

function ipsum_token($params) {
    require_once("LoremIpsum.class.php");
    $words = get_param_value($params, 'words', 200);
    $format = get_single_param_value($params, 'plain', 'plain', 'html');
    $generator = new LoremIpsumGenerator;
    return $generator->getContent($words, $format);
}

?>
