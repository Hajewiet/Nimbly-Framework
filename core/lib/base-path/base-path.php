<?php

// @doc - `[base-path]` outputs the file base path of the Nimbly installation e.g.: /var/www/nimbly

function base_path_sc() {
    return $GLOBALS['SYSTEM']['file_base'];
}
