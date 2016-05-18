<?php

function key_access_token($params) {
    run_library("session");
    $redirect_url = get_param_value($params, "redirect", "errors/403");

    if (empty($_SESSION['key'])) {
        run_library("redirect");
        redirect($redirect_url);
        return;
    }
    $posted_key = $_POST["form_key"];
    if (empty($posted_key) || $_SESSION['key'] !== $posted_key) {
        run_library("redirect");
        redirect($redirect_url);
    }
}
