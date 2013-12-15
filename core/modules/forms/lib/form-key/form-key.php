<?php

function form_key_token($params) {
    run_library("session");
    $key = $_SESSION['key'];
    $result = '<input type="hidden" name="form-key" value="' . $key . '" />';
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
