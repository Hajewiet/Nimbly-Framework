<?php

if (post_get_value("submit", false) == "Next") {
    run_library("set", array("step" => "3", "overwrite" => true));
} else {
    run_library("set", array("step" => "1", "overwrite" => true));
}

?>
