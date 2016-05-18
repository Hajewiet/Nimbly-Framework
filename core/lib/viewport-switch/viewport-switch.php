<?php

/*
 * Implements viewport switch.
 * Usage: [viewport-switch tpl=nameoftemplate]
 * Result: loads nameoftemplate.large, nameoftemplate.medium or nameoftemplate.small
 */

function viewport_switch_token($params) {
    load_library("viewport_width");
    $vp_width = viewport_width_token();
    $tpl = get_param_value($params, "tpl");
    $tpl .= '.' . $vp_width;
    run_single_token($tpl);
}

