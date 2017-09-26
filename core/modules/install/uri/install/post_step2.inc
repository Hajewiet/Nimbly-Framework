<?php

load_library("get");
load_library("set");
load_library("data");
load_library("encrypt");
load_library("salt");

if (post_get("submit", false) == "Next") {
    run_library("set", array("step" => "3", "overwrite" => true));
} else {
    run_library("set", array("step" => "1", "overwrite" => true));
}

run_library("sticky-post");

$alias = get_sc("sticky.rewritebase");
if (!empty($alias)) {
    run_library("set", array("rewritebase-slash" => $alias . '/',  "overwrite" => true));
} else {
    run_library("set", array("rewritebase-slash" => "", "overwrite" => true));
}

/*
 * Create htaccess file
 */

$htaccess_content = run_buffered(realpath(dirname(__FILE__)) . "/root.htaccess.tpl");
$htaccess_file = $GLOBALS['SYSTEM']['file_base'] . '.htaccess';
if (false === file_put_contents($htaccess_file, $htaccess_content)) {
    set_variable("htaccess_ok", "fail");
} else {
    chmod($htaccess_file, 0640);
    set_variable("htaccess_ok", "ok");
}

/*
 * Create core routes
 */

$routes = [
    ["route" => "api", "order" => 900],
    ["route" => "api/v1/(resource)", "order" => 500],
    ["route" => "api/v1/(resource)/(id)", "order" => 200],
    ["route" => "api/v1/.pages/(id)", "order" => 200],
    ["route" => "admin/(resource)", "order" => 400],
    ["route" => "admin/(resource)/(id)", "order" => 500],
    ["route" => "admin/(resource)/add", "order" => 300],
    ["route" => "admin/pages/(id)", "order" => 200],
    ["route" => "admin/routes/(id)", "order" => 200],
    ["route" => "img/(id)", "order" => 500]
];

foreach ($routes as $route) {
    data_create(".routes", md5($route['route']), $route);
}

/*
 * Create admin role
 */

data_create("roles", "admin", array(
    "name" => "Admin",
    "description" => "For technical administration of [site-name]",
    "features" => "(all)"
));

/*
 * Create users resource
 */

data_create("users", ".meta", [
   "fields" => [
        "email" => [
          "type" => "text",
          "name" => "email"
        ],
        "password" => [
          "type" => "password",
          "name" => "password"
        ],
        "roles" => [
          "type" => "text",
          "name" => "roles"
        ],
        "name" => [
          "type" => "text",
          "name" => "name"
        ]
  ],
  "pk" => "email",
  "encrypt" => "password"
]);

/*
 * Create admin user
 */

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
