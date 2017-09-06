<?php

function img_file_sc($params) {
    $file = count($params > 1)? implode(" ", $params) : current($params);
    header("Content-type: image/jpeg");
    readfile($file);
}
