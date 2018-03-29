<?php

/**
 * @doc `[int x]` shows integer value of variable named x
 */
function int_sc($params) {
    load_library("get");
    $var = get_param_value($params, "var", current($params));
    if (empty($var)) {
        return 0;
    }
    $val = get_variable($var, 0);
    $val = trim(str_replace(',', '', $val));
    return (int) preg_replace('/[^\-\d]*(\-?\d*).*/','$1', $val);
}
