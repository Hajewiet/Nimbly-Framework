<?php

function url_sc() {
    return $GLOBALS['SYSTEM']['uri_base'] . $GLOBALS['SYSTEM']['request_uri'];
}

function url_absolute($relative_url) {
    return sprintf("%s://%s%s%s%s", 
            empty($_SERVER['HTTPS'])? "http" : "https",
            $_SERVER['SERVER_NAME'],
            $_SERVER['SERVER_PORT'] !== '80'? ":" . $_SERVER['SERVER_PORT'] : "",
            $GLOBALS['SYSTEM']['uri_base'],
            $relative_url);
}
