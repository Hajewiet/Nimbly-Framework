<?php

function guess_alias_sc() {
    $result = trim($GLOBALS['SYSTEM']['uri_base'], '/');
    return $result;
}

