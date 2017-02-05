<?php

function viewport_width_sc() {
    $result = filter_input(INPUT_COOKIE, "vpw");
    if ($result === false || $result === null) {
        $result = filter_input(INPUT_GET, "vpw");
    }
    if ($result === false || $result === null) {
        $result = "unknown";
    }
    return $result;
}
