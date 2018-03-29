<?php

load_library("get");
load_library("set");

/**
 * @doc `[data-join a b]` joins data variables data.a and data.b into new array variable named data.join
 */
function data_join_sc($params) {
    if (count($params) < 2) {
        return;
    }
    $id1 = current($params);
    $id2 = end($params);
    $data1 = get_variable("data.{$id1}");
    $data2 = get_variable("data.{$id2}");
    if (!is_array($data1) || !is_array($data2)) {
        return;
    }
    array_walk($data1, 'data_join_set_resource_type', $id1);
    array_walk($data2, 'data_join_set_resource_type', $id2);
    $join = array_merge($data1, $data2);
    set_variable('data.join', $join);
}

function data_join_set_resource_type(&$item, $key, $type) {
    $item['resource_type'] = $type;
}
