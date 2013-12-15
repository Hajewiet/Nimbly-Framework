<?php

function salt_token($params) {
    return rtrim(strtr(base64_encode(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)), '+', '.'),'=');
    //http://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
}

?>