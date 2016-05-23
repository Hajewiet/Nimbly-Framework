<?php

function sanitize_sc($params) {
    
}

function sanitize_id($raw_text) {
    $result = strtolower(trim($raw_text));
    $result = preg_replace("/[\s]/", '-', $result);
    return preg_replace("/[^\w\-]/", '', $result);
}


?>
