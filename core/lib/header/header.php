<?php

function header_token($params) {
    $css = get_single_param_value($params, "css", true, false);
    if ($css) {
        header("Content-type: text/css");
        return;
    }
    $js = get_single_param_value($params, "js", true, false);
    if ($js) {
        header("Content-type: application/javascript");
        return;
    }
    $woff = get_single_param_value($params, "woff", true, false);
    if ($woff) {
        header("Content-type: application/x-font-woff");
        return;
    }
    $error_403 = get_single_param_value($params, "403", true, false);
    if ($error_403) {
        header('HTTP/1.0 403 Forbidden');
        return;
    }
    $error_404 = get_single_param_value($params, "404", true, false);
    if ($error_404) {
        header('HTTP/1.0 404 Not Found');
        return;
    }
}

?>