<?php

unlink($GLOBALS['SYSTEM']['file_base'] . '.htaccess');
load_library("redirect");
redirect("install.php"); 