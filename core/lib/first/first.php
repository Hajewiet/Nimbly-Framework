<?php

/**
 * @doc * `[first dataset]` returns first item from dataset, stored in variable named `first`
 * @doc * `[first dataset var=varname]` returns first item from dataset, stored in variable named `varname`
 */
function first_sc($params) {
    load_library('get');
    load_library('set');
    $data_id = current($params);
    $var_id = get_param_value($params, "var", "first") . '.';

    $data = get_variable($data_id);

    if (!is_array($data) && is_string($data)) {
        $data = array($data);
    }

    clear_variable($var_id);

    if (count($data) < 1) {
        return;
    }

    $item = current($data);
    if (is_string($item)) {
        set_variable($var_id, $item);
    } else {
        foreach ($item as $key => $value) {
            set_variable($var_id . $key, $value);
        }
    }
}
