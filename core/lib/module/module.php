<?php


function module_token($params) {
    foreach ($params as $key => $value) {
        if ($key == $value) {
            $GLOBALS['SYSTEM']['modules'][$key] = '/modules/' . $value . '/';
        }
    }
    return null;
}

?>
