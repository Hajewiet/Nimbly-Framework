<?php

/**
 * @doc `[md5 a]` caculates md5 hash for a
 */
function md5_sc($params) {
    $val = implode(' ', $params);
    return md5($val);
}

function is_md5($val) {
    return strlen($val) == 32 && ctype_xdigit($val);
}

function md5_uuid($uuid) {
    return is_md5($uuid)? $uuid : md5($uuid);
}
