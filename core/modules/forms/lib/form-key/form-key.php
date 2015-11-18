<?php

function form_key_token($params) {
    run_library("session");
    $key = $_SESSION['key'];
    if (get_single_param_value($params, "plain", true, false)) {
        return $key;
    }
    $result = '<input type="hidden" name="form_key" value="' . $key . '" />';
    if (!empty($params)) {
        if (isset($params['name'])) {
            $name = $params['name'];
        } else {
            $name = current($params);
        }
        $result .= '<input type="hidden" name="form-id" value="' . $name . '" />';
    }
    return $result;
}

?>
