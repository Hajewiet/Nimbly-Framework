<?php

function logged_in_sc($params) {
    load_library("session");
    if (session_user()) {
        return "logged-in";
    }
    return "";
}
