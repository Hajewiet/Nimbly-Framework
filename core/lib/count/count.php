<?php

load_library("get");

// @doc * `[count var]` outputs amount of items in nimbly variable named _var_

function count_sc($params) {
    $a = current($params);
    $as = get_variable($a, false);
    if ($as === false) {
        return 0;
    } else if (is_array($as)) {
    	$filter = get_param_value($params, "filter");
        if (!empty($filter)) {
        	load_library("data");
            $as = data_filter($as, $filter);
        }
        return count($as);
    }
    return 1;
}
