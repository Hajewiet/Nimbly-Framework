<?php

function username_sc() {
    return username_get();
}

function username_get() {
    load_library("session");
    if (session_resume() && !empty($_SESSION['username'])) {
        return $_SESSION['username'];
    } else {
        return 'anonymous';
    }
}