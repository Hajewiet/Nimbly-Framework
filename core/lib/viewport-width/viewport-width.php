<?php

function viewport_width_sc() {
    $result = filter_input(INPUT_COOKIE, "nb_device_width");
    if ($result === false || $result === null) {
        $result = "unknown";
    }
    return $result;
}
