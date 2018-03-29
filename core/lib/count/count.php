<?php

load_library("get");

// @doc * `[count var]` outputs amount of items in nimbly variable named _var_

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
