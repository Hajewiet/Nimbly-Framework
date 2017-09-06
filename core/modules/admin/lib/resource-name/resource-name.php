<?php

function resource_name_sc($params) {
    $r = current($params);
    $r = substr($r, 0, -1);
    return ucfirst($r);
}
