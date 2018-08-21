<?php

function salt_sc() {
    return rtrim(strtr(base64_encode(random_bytes(32)), '+', '.'),'=');
    //return rtrim(strtr(base64_encode(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)), '+', '.'),'=');
}