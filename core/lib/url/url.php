<?php

function url_token() {
    return $GLOBALS['SYSTEM']['uri_base'] . $GLOBALS['SYSTEM']['uri'];
}

function url_absolute($relative_url) {
    $result = "http";
    if (!empty($_SERVER['HTTPS'])) {
        $result .= 's';
    }
    $result .= '://' . $_SERVER['SERVER_NAME'] . $GLOBALS['SYSTEM']['uri_base'] . $relative_url;  
    return $result;
}

?>
