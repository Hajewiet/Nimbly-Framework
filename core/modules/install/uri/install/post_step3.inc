<?php


if (post_get_value("submit", false) == "Next") {
    run_library("set", array("step" => "4", "overwrite" => true));
} else {
    run_library("set", array("step" => "2", "overwrite" => true));
}

?>
