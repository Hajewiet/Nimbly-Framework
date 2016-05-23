<?php

function sticky_post_sc($params) {
    $all_input = post_get_all();
    load_library("set");
    load_library("session");
    foreach ($all_input as $key => $value) {
        set_session_variable("sticky." . $key, $value, false, true);
    }
}