<?php

load_library("session");
load_library('data');

function access_sc($params) {

    $role = get_param_value($params, "role", false);
    if ($role !== false && access_by_role($role) === true) {
        return;
    }

    $feature = get_param_value($params, "feature", false);
    if ($feature !== false && access_by_feature($feature) === true) {
         return;
    }

    $key = get_param_value($params, "key", false);
    if ($key !== false && access_by_key($key) === true) {
         return;
    }

    /* access denied */
    access_denied(get_param_value($params, "redirect")); 
}

function access_denied($redirect_url = 'errors/403') {
    load_library("redirect");
    redirect($redirect_url);
}

function access_by_role($role) {
    $has_session = session_resume();
    if ($role === "anonymous" && $has_session === false) {
        return true;
    }
    $roles = explode(',', $role);
    foreach ($roles as $r) {
        if (!empty($_SESSION['roles'][$r])) {
            return true;
        }
    }
    return false;
}

function access_by_feature($feature) {
    $has_session = session_resume();

    if ($has_session === false || !isset($_SESSION['features'])) {
        return false;
    }

    if (isset($_SESSION['features']['(all)']) && $_SESSION['features']['(all)'] === true) {
        return true;
    }

    $features = explode(',', $feature);

    foreach ($features as $f) {
        if (!empty($_SESSION['features'][$f]) && $_SESSION['features'][$f] === true) {
            return true;
        }
    }

    return false;
}

function access_by_key($key) {
    if (empty($key)) {
        return false;
    }
    if (isset($_SERVER['PEPPER']) && $key === $_SERVER['PEPPER']) {
        return true;
    }
    if (isset($_SESSION['key']) && $key === $_SESSION['key']) {
        return true;
    }
    if (isset($_POST['api-key']) && $key === $_POST['api-key']) {
        return true;
    }
    if (isset($_SERVER['HTTP_X_API_KEY']) && $key === $_SERVER['HTTP_X_API_KEY']) {
        return true;
    }
    return false;
}


function load_user_roles($name) {
    $roles = data_read('users', md5($name), 'roles');
    if (!empty($roles)) {
        $result = array_map('trim', explode(',', $roles));
    } else {
        $result = array();
    }
    return $result;
}

function load_user_features($name) {
    $features = data_read('users', md5($name), 'features');
    if (!empty($features)) {
        $result = array_map('trim', explode(',', $features));
        return $result;
    }
    $roles = load_user_roles($name);
    $result = array();
    foreach ($roles as $role) {
        $features = data_read('roles', $role, 'features');
        if (!empty($features)) {
            $fs = array_map('trim', explode(',', $features));
            $result = array_merge($result, $fs);
            if ($features === "(all)") {
                break;
            }
        }
    }
    $result = array_unique($result);
    return $result;
}

function persist_login_error() {
    $GLOBALS['SYSTEM']['validation_errors']['_global'][] = "[text validate_invalid_email_or_password]";
    $_SESSION['username'] = 'anonymous';
    return false;
}

function persist_login($email, $password) {
    run_library('session');
    $uuid = md5($email);
    if (!data_exists('users', $uuid)) {
        return persist_login_error();
    }
    $user_data = data_read('users', $uuid);
    if (empty($user_data['salt']) || empty($user_data['password'])) {
        return persist_login_error();
    }
    load_library('encrypt');
    $pw_typed = encrypt($password, $user_data['salt']);
    $pw_stored = $user_data['password'];
    if (timesafe_strcmp($pw_stored, $pw_typed) !== true) {
        //password fail
        return persist_login_error();
    } else if (_persist_user_roles($email)) {
        //login success
        _persist_user_features($email);
        $_SESSION['username'] = $email;
        return true;
    }
    return persist_login_error();
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

function _persist_user_features($name) {
    $features = load_user_features($name);
    $_SESSION['features'] = array();
    if (empty($features)) {
        $_SESSION['features']['(none)'] = true;
    } else {
        foreach ($features as $k => $v) {
            $_SESSION['features'][$v] = true;
        }
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
