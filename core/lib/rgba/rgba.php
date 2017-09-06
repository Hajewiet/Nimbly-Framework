<?php

function rgba_sc($params) {
    $color = get_param_value($params, 'color', current($params));
    $a = get_param_value($params, 'opacity', count($params) > 1? next($params) : 1.0);
    list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
    echo sprintf("rgba(%d,%d,%d,%f)", $r, $g, $b, $a);
}
