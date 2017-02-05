<?php

function repeat_sc($params) {
    load_library('get');
    load_library('set');

    $data_id = get_param_value($params, "data", current($params));
    $tpl_id = get_param_value($params, "tpl", $data_id);
    $tpl_dir = get_param_value($params, "tpldir");
    $data = get_variable($data_id);
    $tpl = find_template($tpl_id, $tpl_dir);
    $exclude = get_param_value($params, "exclude");

    if (!is_array($data) && is_string($data)) {
        if (get_param_value($params, "csv", false) !== false) {
            $data = array_map('trim', explode(',', $data));
        } else {
            $data = array($data);
        }
    }

    if (empty($data) || !is_array($data)) {
        $empty = get_param_value($params, "empty", "empty");
        $empty_tpl = find_template($empty, $tpl_dir);
        if (!empty($empty_tpl)) {
            run($empty_tpl);
        }
        return;
    }

    if (strcmp(strtolower($tpl_id), "csv") === 0) {
        $result = '"' . implode('","', $data) . '"';
        return $result;
    } else if (empty($tpl)) {
        $result = print_r(current($data), true);
        return $result;
    }

    $exclude_ls = array();
    if (!empty($exclude)) {
        $exclude_ls = explode(",", $exclude);
    }
   
    foreach ($data as $k => $item) {
        $excluded = @in_array($item, $exclude_ls) || @in_array(key($item), $exclude_ls);
        if ($excluded) {
            continue;
        } else if (is_string($item)) {
            set_variable('item.key', $item, false, true);
        } else {
            set_variable('item.key', $k, false, true);
            foreach ($item as $key => $value) {
                set_variable('item.' . $key, $value, false, true);
            }
        }
        run($tpl);
    }
}
