<?php

function username_sc($params) {
    return username_get();
}

function username_get() {
    load_library("session");
    if (session_resume()) {
        return $_SESSION['username'];
    } else {
        return 'anonymous';
    }
}

