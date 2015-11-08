<?php


if (post_get_value("submit", false) == "Previous") {
    run_library("set", array("step" => "3", "overwrite" => true));
} else {
    load_library("redirect");
    redirect("");
}

?>
