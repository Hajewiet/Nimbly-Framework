<?php

// @doc - `[base-url]` outputs the base url (alias) of the Nimbly installation e.g.: /nimbly or /

function base_url_sc() {
    return rtrim($GLOBALS['SYSTEM']['uri_base'], " \\/");
}
