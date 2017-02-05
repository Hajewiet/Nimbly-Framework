<?php

function access_sc($params) {
    load_library("session");
    $has_session = session_resume();
    $role = get_param_value($params, "role", "anonymous");
    if ($role === "anonymous" && $has_session === false) {
        return;
    }
    if (empty($_SESSION['roles'][$role])) {
        $redirect_url = get_param_value($params, "redirect", "errors/403");
        run_library("redirect");
        redirect($redirect_url);
    }
}

function load_user_roles($name) {
    load_library('data');
    $roles = data_load('users', $name, 'roles');
    if (!empty($roles)) {
        $result = array_map('trim', explode(',', $roles));
    } else {
        $result = array();
    }
    return $result;
}

function persist_login($name, $password) {
    run_library('session');
    load_library('pwcrypt');
    load_library('data');
    $pw_typed = pwcrypt($password, data_load('users', $name, 'salt'));
    $pw_stored = data_load('users', $name, 'password');
    if (timesafe_strcmp($pw_stored, $pw_typed) !== true) {
        //password fail
        $GLOBALS['SYSTEM']['validation_errors']['_global'][] = "[text validate_invalid_user_or_password]";
        return false;
    } else if (_persist_user_roles($name)) {
        //login success
        $_SESSION['username'] = $name;
    } else {
        //login fail
        $_SESSION['username'] = 'anonymous';
        return false;
    }
}

function _persist_user_roles($name) {
    $roles = load_user_roles($name);
    foreach ($_SESSION['roles'] as $role => $value) {
        $_SESSION['roles'][$role] = false;
    }
    foreach ($roles as $key => $role) {
        $_SESSION['roles'][$role] = true;
    }
    if (empty($roles)) {
        $_SESSION['roles']['anonymous'] = true;
        return false;
    } else {
        return true;
    }
}

function timesafe_strcmp($safe, $user) {
    $safe .= chr(0);
    $user .= chr(0);
    $safe_len = strlen($safe);
    $user_len = strlen($user);
    $result = $safe_len - $user_len;
    for ($i = 0; $i < $user_len; $i++) {
        $result |= (ord($safe[$i % $safe_len]) ^ ord($user[$i]));
    }
    return $result === 0;
}

function user_has_role($username, $role) {
    $roles = load_user_roles($username);
    return is_array($roles) && in_array($role, $roles);
}
