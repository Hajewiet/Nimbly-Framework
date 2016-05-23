<?php

function include_sc($params) {
    $file = current($params);
    include $file;
}
?>
