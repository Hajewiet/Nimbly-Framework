<?php

function base_url_token() {
    return rtrim($GLOBALS['SYSTEM']['uri_base'], " \\/");
}
