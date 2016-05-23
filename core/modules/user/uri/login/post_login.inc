<?php

load_library("redirect");
load_library("get");
$url = get_sc("login-url");
redirect($url);


