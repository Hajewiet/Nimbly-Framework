<?php

load_library("data");
load_library("get");

if (post_get("submit", false) == "Next") {
    load_library("redirect");
    redirect("login");
} else {
    run_library("set", array("step" => "2", "overwrite" => true));
}