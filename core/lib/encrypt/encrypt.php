<?php

/**
 * @doc `[encrypt text="string to encrypt" salt="a salt key"]` outputs encrypted text using a salt key
 */
function encrypt_sc($params) {
    $text = get_param_value($params, "text", current($params));
    $salt = get_param_value($params, "salt");
    return encrypt($text, $salt);

}

function encrypt($text, $salt) {
    if (empty($salt)) {
        throw new Exception('Empty salt');
    }
    return crypt($text, '$2a$07$' . $salt . '$');
}
