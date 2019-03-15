<?php

unlink($GLOBALS['SYSTEM']['file_base'] . '.htaccess');

$sess_path = "ext/data/.tmp/sessions";
file_exists($sess_path) || @mkdir($sess_path, 0750, true);

load_library("redirect");
redirect("install.php"); 