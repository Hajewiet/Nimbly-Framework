<?php

function debug_token($params) {
    run_library("session");
    var_dump($GLOBALS);
    var_dump(apache_get_modules());
}

?>
