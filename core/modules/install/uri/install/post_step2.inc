<?php

if (post_get("submit", false) == "Next") {
    run_library("set", array("step" => "3", "overwrite" => true));
} else {
    run_library("set", array("step" => "1", "overwrite" => true));
}

run_library("sticky-post");
load_library("get");
$alias = get_sc("sticky.rewritebase");
if (!empty($alias)) {
    run_library("set", array("rewritebase-slash" => $alias . '/',  "overwrite" => true));
} else {
    run_library("set", array("rewritebase-slash" => "", "overwrite" => true));
}

/*
 * Create htaccess file
 */

load_library("set");
$htaccess_content = run_buffered(realpath(dirname(__FILE__)) . "/root.htaccess.tpl");
$htaccess_file = $GLOBALS['SYSTEM']['file_base'] . '.htaccess';
if (false === file_put_contents($htaccess_file, $htaccess_content)) {
    set_variable("htaccess_ok", "fail");
} else {
    chmod($htaccess_file, 0640);
    set_variable("htaccess_ok", "ok");
}

/*
 * Create admin user
 */

load_library("data");
load_library("encrypt");
load_library("salt");
$salt = salt_sc();
$email = post_get("email");
$pw = post_get("password");
if (false !== data_create("users", md5($email), array(
    "email" => $email,
    "roles" => "admin,user",
    "salt" => $salt,
    "password" => encrypt($pw, $salt)
))) {
    set_variable("user_ok", "ok");
} else {
    set_variable("user_ok", "fail");
}
