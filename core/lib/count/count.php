<?php

load_library("get");

function count_sc($params) {
    $a = current($params);
    $as = get_variable($a, false);
    if ($as === false) {
        return 0;
    } else if (is_array($as)) {
        return count($as);
    }
    return 1;
}
