<?php

/**
 * @doc `[include file]` includes a file if it exists
 */
function include_sc($params) {
    $file = current($params);
    if (file_exists($file)) {
        include $file;
    } 
}
