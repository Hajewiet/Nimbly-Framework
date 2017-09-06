<?php

function rrmdir($dir) {
    if (is_dir($dir) !== true) {
        return unlink($dir);
    }
    $objects = scandir($dir);
    foreach ($objects as $object) {
        if ($object === '.' || $object === "..") {
            continue;
        }
        if (rrmdir($dir . '/' . $object) !== true) {
            return false;
        }
    }
    reset($objects);
    return rmdir($dir);
}

function rmfiles($dir) {
    if (is_dir($dir) !== true) {
        return unlink($dir);
    }
    $objects = scandir($dir);
    foreach ($objects as $object) {
        if ($object[0] === '.') {
            continue;
        }
        $path = $dir . '/' . $object;
        if (is_dir($path)) {
            continue;
        }
        if (unlink($path) !== true) {
            return false;
        }
    }
    return true;
}
