<?php

function include_sc($params) {
    $file = current($params);
    if (file_exists($file)) {
        include $file;
    } 
}
