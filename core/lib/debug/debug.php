<?php

function debug_sc($params) {
    if (empty($params) || get_param_value($params, "variables") !== null) {
        echo '<div class="scroll-h">';
        debug_pretty_caption('Nimbly variables');
        debug_pretty_print($GLOBALS['SYSTEM']['variables']);
        echo '</div><hr />';
    }
    if (empty($params) || get_param_value($params, "session") !== null) {
        echo '<div class="scroll-h">';
        debug_pretty_caption('Session');
        debug_pretty_print($GLOBALS['_SESSION']);
        echo '</div><hr />';
    }
    if (empty($params) || get_param_value($params, "globals") !== null) {
        echo '<div class="scroll-h">';
        debug_pretty_caption('Global Variables');
        debug_pretty_print($GLOBALS);
        echo '</div><hr />';
    }
    if (empty($params) || get_param_value($params, "apache") !== null) {
        echo '<div class="scroll-h">';
        debug_pretty_caption('Apache Modules');
        debug_pretty_print(array('Installed' => join(", ", apache_get_modules())));
        echo '</div><hr />';
    }
    if (get_param_value($params, "php") !== null) {
        echo '<div class="scroll-h">';
        phpinfo();
        echo '</div>';
    }
}

function debug_pretty_caption($caption) {
    echo sprintf('<label>%s</label>', strtoupper($caption));
}

function debug_pretty_print($a, $level = 0) {
    if (is_array($a)) {
        foreach ($a as $k => $v) {
            if ($k === "GLOBALS") {
                continue;
            }
            debug_pretty_print_line($level, $k, $v);
            if (is_array($v)) {
                debug_pretty_print($v, $level + 1);
            }
        }
    } else {
        debug_pretty_print_line($level, $a);
    }
}

function debug_pretty_print_line($level, $k, $v = null) {
    if (empty($v)) {
        $pretty_v = "(empty)";
    } else if (is_array($v)) {
        $pretty_v = "(array) => ";
    } else {
        $pretty_v = $v;
    }
    echo sprintf("<div style='margin-left:%drem;'><span>%s: </span><span style='color:#888'>%s</span></div>", $level*4, $k, $pretty_v);
}
