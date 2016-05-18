<?php

function viewport_width_token() {
    $result = filter_input(INPUT_COOKIE, "viewport_width");
    if ($result === false || $result === null) {
        $result = filter_input(INPUT_GET, "viewport_width");
    }
    if ($result === false || $result === null) {
        $result = "unknown";
    }
    return $result;
}
