<?php

function uuid_sc() {
    $bytes = openssl_random_pseudo_bytes(10);
    return gmp_strval(gmp_init(bin2hex($bytes), 16), 36);
}
