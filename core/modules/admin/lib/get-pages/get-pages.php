<?php

function get_pages_sc($params) {
    load_library("set");
    load_library("pages", "api");
    set_variable("data.pages", pages_read());
}
