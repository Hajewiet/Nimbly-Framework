<?php

/*
 * Implements viewport switch.
 * Usage: [viewport-switch tpl=nameoftemplate]
 * Result: loads nameoftemplate.large, nameoftemplate.medium or nameoftemplate.small
 */

function viewport_switch_sc($params) {
    load_library("viewport-width");
    $vp_width = viewport_width_sc();
    $tpl = get_param_value($params, "tpl", current($params));
    $tpl .= '.' . $vp_width;
    run_single_sc($tpl);
}

