<?php

function username_token($params) {
    if (isset($_SESSION['username'])) {
        return $_SESSION['username'];
    } else {
        return 'anonymous';
    }
}

