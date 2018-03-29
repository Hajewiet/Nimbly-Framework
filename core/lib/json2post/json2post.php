<?php

/**
 * @doc '[json2post]' converts posted json data to php post data
 */
function json2post_sc() {
    $data = file_get_contents("php://input");
    $obj_data = json_decode($data);
    foreach ($obj_data as $key=>$value) {
        $_POST[$key] = $value;
    }
}

