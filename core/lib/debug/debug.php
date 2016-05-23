<?php

function debug_sc($params) {
    run_library("session");
    var_dump($GLOBALS);
    var_dump(apache_get_modules());
}

?>
