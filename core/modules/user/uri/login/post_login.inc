<?php

load_library("redirect");
load_library("get");
$url = get_token("login-url");
redirect($url);

?>
