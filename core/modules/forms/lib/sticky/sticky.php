<?php

function sticky_token($params) {
    if (empty($params)) {
        return;
    }
    $value = current($params);
    if (isset($_POST[$value])) {
        return htmlentities($_POST[$value]);
    }
}

?>
