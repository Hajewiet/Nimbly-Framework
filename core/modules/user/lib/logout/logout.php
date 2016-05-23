<?php

function logout_sc($params) {
    run_library('session');
    run_library('redirect');
    foreach ($_SESSION['roles'] as $role => $value) {
        $_SESSION['roles'][$role] = false;
    }
    $_SESSION['roles']['anonymous'] = true;
    $_SESSION['username'] = 'anonymous';
    $_SESSION['SYSTEM']['messages'][] = '[msg user_logged_out]';
    $redirect_url = get_param_value($params, "redirect", "");
    redirect($redirect_url);
}
