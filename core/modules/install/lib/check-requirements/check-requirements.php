<?php

function check_requirements_sc($params) {
    load_library("get");
    load_library("set");
    set_variable("require_all", 'fail');

    if (get_variable("session_ok") === "fail") {
        set_variable("require_msg", "require_session");
        return;
    }

    if (require_higher_version(phpversion(), "7.0.0") === false) {
        set_variable("require_msg", "require_php7");
        return;
    }

    $ext = get_loaded_extensions();

    if (!in_array("session", $ext)) {
        set_variable("require_msg", "require_ext_session");
        return;
    }

    if (stripos($_SERVER['SERVER_SOFTWARE'], "apach") === false) {
        set_variable("require_msg", "require_apache");
        return;
    }

    $apache_version_ok = false;
    $version_string = apache_get_version();

    if (stripos($version_string, "apache/") === 0) {
        $start = strlen("apache/");
        $stop = strpos($version_string, ' ');
        $version_number = substr($version_string, $start, $stop - $start);
        $apache_version_ok = require_higher_version($version_number, "2.0.0");
    }

    if ($apache_version_ok === false) {
        set_variable("require_msg", "require_apache");
        return;
    }

    $mods = apache_get_modules();
    if (in_array("mod_rewrite", $mods) === false) {
        set_variable("require_msg", "require_apache_rewrite");
        return;
    }

    load_library("setup-data-dir");
    if (!setup_data_dir_sc()) {
        set_variable("require_msg", "require_data_dir");
        return;
    }

    $file_path = $GLOBALS['SYSTEM']['file_base'] . "data/.tmp";
    $temp_file_name = tempnam($file_path, "tmp-");

    if ($temp_file_name !== false) {
        unlink($temp_file_name);
    } else {
        set_variable("require_msg", "require_data_write");
        return;
    }

    set_variable("require_all", 'pass');
}

/**
 * Helper function to check if a version number is higher or equal
 * @param array $v1 the version to verify (e.g. 5.1.2)
 * @param array $v2 the minimum acceptable version number (e.g. 5.1.1)
 * @return boolean true is v1 >= v2, false otherwise
 */
function require_higher_version($v1, $v2) {
    if (empty($v1)) {
        return false;
    }

    if (empty($v2)) {
        return true;
    }

    $vl1 = explode('.', $v1);
    $vl2 = explode('.', $v2);
    $major1 = @$vl1[0];
    $major2 = @$vl2[0];
    $minor1 = @$vl1[1];
    $minor2 = @$vl2[1];
    $release1 = @$vl1[2];
    $release2 = @$vl2[2];

    return $major1 >= $major2 && $minor1 >= $minor2 && $release1 >= $release2;
}
