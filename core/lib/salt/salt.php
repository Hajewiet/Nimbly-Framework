<?php

function salt_sc($params) {
    return rtrim(strtr(base64_encode(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)), '+', '.'),'=');
    //http://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
    //https://nakedsecurity.sophos.com/2013/11/20/serious-security-how-to-store-your-users-passwords-safely/
}