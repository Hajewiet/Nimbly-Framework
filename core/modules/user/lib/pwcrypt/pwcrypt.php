<?php

function pwcrypt_token($params) {
    $text = get_param_value($params, "password");
    $salt = get_param_value($params, "salt");
    return crypt($text, '$2a$07$' . $salt . '$');
}

function pwcrypt($pw, $salt) {
    $params['password'] = $pw;
    $params['salt'] = $salt;
    return pwcrypt_token($params);
}

