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

load_library("crud");
load_library("pwcrypt", "user");
load_library("salt");
$salt = salt_sc();
$username = post_get("username");
$pw = post_get("password");
data_create("users", $username, array(
    "name" => $username,
    "roles" => "admin,user",
    "salt" => $salt,
    "password" => pwcrypt($pw, $salt)
));
if (data_exists("users", $username)) {
    set_variable("user_ok", "ok");
} else {
    set_variable("user_ok", "fail");
}
