<?php

function resource_name_sc($params) {
    $r = trim(strtolower(current($params)));
    if (substr($r, -1) === 's' && $r !== 'news') {
        // change to singular
        $r = substr($r, 0, -1);
        if (strlen($r) > 2 && substr($r, -2) === 'ie') {
            $r = substr($r, 0, -2) . 'y';
        }
    }
    return ucfirst($r);
}
