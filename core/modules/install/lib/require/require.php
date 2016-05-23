<?php

function require_sc($params) {
    $result['pass'] = "pass";
    $result['fail'] = "fail";
    $pass = true;
    foreach ($params as $key => $value) {
        if ($key == "pass") {
            $result['pass'] = $value;
        } else if ($key == "fail") {
            $result['fail'] = "";
        } else {
            $pass &= require_test($key, $value);
        }
    }
    if ($pass) {
        return $result['pass'];
    }
    load_library("set");
    set_variable("require", $result['fail']);
    return $result['fail'];
}

function require_test($key, $value) {
    switch ($key) {
        case 'server':
            return stripos($_SERVER['SERVER_SOFTWARE'], $value) !== false;
        case 'apache_module':
            return in_array($value, apache_get_modules());
        case 'apache_version':
            $version_string = apache_get_version();
            if (stripos($version_string, "apache/") === 0) {
                $start = strlen("apache/");
                $stop = strpos($version_string, ' ');
                $version_number = substr($version_string, $start, $stop - $start);
                return require_higher_version($version_number, $value);
            }
            break;
        case 'php_version':
            return require_higher_version(phpversion(), $value);
        case 'cond':
        case 'condition':
        case 'bool':
        case 'exp':
            return $value === "1";
        case 'write_access':
            $file_path = $GLOBALS['SYSTEM']['file_base'] . $value;
            $temp_file_name = tempnam($file_path, "tmp-");
            if ($temp_file_name !== false) {
                unlink($temp_file_name);
                return true;
            }
        default:
            break;
    }
    return false;
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
