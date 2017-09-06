<?php

function zebra_sc($params) {
    if (empty($params)) {
        return;
    }
    load_library("get");
    $zebra = get_variable("zebra", false);
    if ($zebra !== false && in_array($zebra, $params)) {
        $zebra = zebra_next($params, $zebra);
    } else {
        $zebra = current($params);
    }
    load_library("set");
    set_variable("zebra", $zebra);
    return $zebra;
}

function zebra_next($params, $zebra) {
    for ($c = current($params); $c !== false; $c = next($params)) {
        if ($c !== $zebra) {
            continue;
        }
        $n = next($params);
        if ($n === false) {
            return reset($params); // first
        }
        return $n;
    }
    return $zebra;
}
