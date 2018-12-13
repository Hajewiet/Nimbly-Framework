<?php

function setup_data_dir_sc() {
    $result = true;
    $dirs = array('ext', 'ext/data', 'ext/static', 'ext/lib', 'ext/modules',
        'ext/tpl', 'ext/uri', 'ext/data/.tmp', 'ext/data/.tmp/cache', 'ext/data/.tmp/logs');
    foreach ($dirs as $dir) {
        if (empty($result)) {
            break;
        } else if (!file_exists($dir)) {
            $result &= @mkdir($dir, 0750);
        } else {
            $result &= chmod($dir, 0750);
        }
    }
    $result &= setup_htaccess_files();
    return $result;
}

function setup_htaccess_files() {
    $dirs_deny = array('ext', 'core');
    $src_path = realpath(dirname(__FILE__));
    $tgt_path = $GLOBALS['SYSTEM']['file_base'];
    foreach ($dirs_deny as $dir) {
        copy($src_path . '/deny.htaccess', $tgt_path . $dir . '/.htaccess');
    }
    $dirs_allow = array('ext/data/.tmp/cache', 'ext/static', 'core/static');
    foreach ($dirs_allow as $dir) {
        copy($src_path . '/allow.htaccess', $tgt_path . $dir . '/.htaccess');
    }
    return true;
}
