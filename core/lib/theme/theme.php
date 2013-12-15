<?php


function theme_token($params) {
    foreach ($params as $key => $value) {
        if ($key == $value) {
            $GLOBALS['SYSTEM']['modules'][$key] = "/themes/" . $value;
        }
    }
}

?>
