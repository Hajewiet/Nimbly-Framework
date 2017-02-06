<?php

/*
 * Bootstrap MySQL connection
 */

require_once("mysql.data.funcs.inc");

//return early if connection exists
global $mysql_lnk;
if (!empty($mysql_lnk)) {
    return $mysql_lnk;
}

//read config and connect
$path = dirname(__FILE__);
$first_run = !file_exists($path . "/mysql.data.bootstrap.ini");
if ($first_run) {
    copy($path . "/mysql.data.bootstrap.example.ini", $path . "/mysql.data.bootstrap.ini");  
}

$mysql_cfg = parse_ini_file("mysql.data.bootstrap.ini");
if ($mysql_cfg['host'] === "[host]") {
    $mysql_cfg['host'] = $_SERVER['HTTP_HOST'];
}
$mysql_lnk = @mysqli_connect($mysql_cfg['host'], $mysql_cfg['user'], $mysql_cfg['password'], $mysql_cfg['db'], $mysql_cfg['port']);

//try again if connection failed, creating the database on the fly
if ($mysql_lnk === false) {
    $mysql_lnk = mysqli_connect($mysql_cfg['host'], $mysql_cfg['user'], $mysql_cfg['password'], null, $mysql_cfg['port']);
    if ($mysql_lnk === false) {
        return false;
    }
    mysqli_set_charset($mysql_lnk, "utf8");
    $query = sprintf("CREATE DATABASE IF NOT EXISTS %s", $mysql_cfg['db']);
    mysqli_run_query($mysql_lnk, $query);
   
}

if ($mysql_lnk === false) {
    load_library("redirect");
    redirect("errors/500");
}

mysqli_run_query($mysql_lnk, sprintf('USE `%s`', $mysql_cfg['db']));

if ($first_run) {
    require_once("mysql.data.bootstrap.firstrun.inc");
}

//return the connection. note the connection is kept open during the request
return $mysql_lnk;
