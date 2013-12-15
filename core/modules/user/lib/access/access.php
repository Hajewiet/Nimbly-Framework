<?php

function access_token($params) {
    run_library("session");
    $role = get_param_value($params, "role", "anonymous");
    if (empty($_SESSION['roles'][$role])) {
        run_uri("errors/403");
    } 
}

?>
