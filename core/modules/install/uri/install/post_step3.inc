<?php

load_library("data");
load_library("get");

if (post_get("submit", false) == "Next") {
    $new_install = $GLOBALS['SYSTEM']['file_base'] . 'ext/uri/install';
    mkdir($new_install, 0750, true);
    file_put_contents($new_install . '/index.tpl', '[run uri=errors/404]');
    chmod($new_install . '/index.tpl', 0640);
    load_library("redirect");
    redirect("login");
} else {
    run_library("set", array("step" => "2", "overwrite" => true));
}