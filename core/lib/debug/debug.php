<?php

function debug_sc($params) {
    var_dump($GLOBALS);
    var_dump(apache_get_modules());
}
