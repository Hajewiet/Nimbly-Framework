<?php

load_library("data");
load_library("get");
if (post_get("submit", false) === "Next") {
    load_library("redirect");
    redirect("login");
} 