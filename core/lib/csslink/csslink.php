<?php

function csslink_token($params) {
    $result = "";
    foreach ($params as $param) {
        $result .= '<link type="text/css" rel="stylesheet" href="';
        $result .= $GLOBALS['SYSTEM']['uri_base'] . $param;
        $result .= '" media="all" />';
    }
    return $result;
}

?>
