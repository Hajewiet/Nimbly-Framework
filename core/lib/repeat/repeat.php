<?php

function repeat_token($params) {
    load_library('get');
    load_library('set');
    $data_id = get_param_value($params, "data");
    $tpl_id = get_param_value($params, "tpl");
    $tpl_dir = get_param_value($params, "tpldir");
    $data = get_variable($data_id);
    $tpl = find_template($tpl_id, $tpl_dir);
    foreach ($data as $item) {
        foreach ($item as $key => $value) {
            set_variable('item.' . $key, $value, false, true);
        }
        run($tpl);
    }
}

