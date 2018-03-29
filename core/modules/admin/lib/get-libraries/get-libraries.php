<?php

function get_libraries_sc($params) {
    load_library("set");
    load_library("sys-libraries", "api");
    set_variable("data.libraries", sys_libraries_read());
}
