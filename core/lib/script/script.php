<?php

function script_token($params) {
    $result = "";
    $async = false;
    $onload = false;
    $scripts = array();
    foreach ($params as $param) {
        if ($param == "async") {
            $async = true;
        } else if ($param == "onload") {
            $onload = $param;
        } else if (strpos($param, "http") === 0) {
            $scripts[] = $param;
        } else {
            $scripts[] = $GLOBALS['SYSTEM']['uri_base'] . $param;
        }
    }

    if (!empty($scripts)) {
        global $SYSTEM;
        if ($async) {
            $tpl = find_template("script-async", 'lib/script');
        } else {
            $tpl = find_template("script", 'lib/script');
        }
        foreach ($scripts as $script_src) {
            $SYSTEM['variables']['script-src'] = $script_src;
            run($tpl);
        }
        
    }
    return $result;
}

?>
