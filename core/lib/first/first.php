<?php

function first_sc($params) {
    load_library('get');
    $data_id = current($params);
    $data = get_variable($data_id);

    if (!is_array($data) && is_string($data)) {
        $data = array($data);
    }

    if (count($data) < 1) {
        return;
    }

    load_library('set');
    $item = current($data);
    if (is_string($item)) {
        set_variable('first.key', $item, false, true);
    } else {
        foreach ($item as $key => $value) {
            set_variable('first.' . $key, $value, false, true);
        }
    }
}
