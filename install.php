<?php

$_SERVER['REQUEST_URI'] = dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_URL)) . '/install';
require("index.php");