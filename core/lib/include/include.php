<?php

function include_token($params) {
    $file = current($params);
    include $file;
}
?>
