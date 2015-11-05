<?php

function access_token($params) {
    run_library("session");
    $role = get_param_value($params, "role", "anonymous");
    if (empty($_SESSION['roles'][$role])) {
        $redirect_url = get_param_value($params, "redirect", "errors/403");
        run_uri($redirect_url);
    } 
}

?>
