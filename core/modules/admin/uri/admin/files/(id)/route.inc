<?php

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (false || count($parts) !== 3 || $parts[0] !== 'admin' || $parts[1] !== 'files') {
    return;
}
load_library("files", "api");

router_accept();
