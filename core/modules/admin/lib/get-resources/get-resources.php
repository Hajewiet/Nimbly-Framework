<?php

function get_resources_sc($params) {
    load_library("set");
    load_library("data");
    $rs = data_resources_list();
    set_variable("data.resources", $rs);
}
