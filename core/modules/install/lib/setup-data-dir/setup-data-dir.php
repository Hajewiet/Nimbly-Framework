<?php

function setup_data_dir_sc() {
    $result = true;
    $dirs = array('data', 'ext', 'contrib', 'ext/static', 'ext/lib', 'ext/modules',
        'ext/tpl', 'ext/uri', 'contrib/static', 'contrib/lib',
        'contrib/uri', 'contrib/tpl', 'contrib/modules', 'data/tmp', 'data/tmp/cache',
        'data/tmp/logs', 'data/tmp/sessions');
    foreach ($dirs as $dir) {
        if (!file_exists($dir)) {
            $result &= @mkdir($dir, 0750);
        } else {
            $result &= chmod($dir, 0750);
        }
    } 
    $result &= chmod("data", 760);
    setup_htaccess_files();
    return $result;
}

function setup_htaccess_files() {
    $dirs_deny = array('data', 'ext', 'contrib', 'core');
    $src_path = realpath(dirname(__FILE__));
    $tgt_path = $GLOBALS['SYSTEM']['file_base'];
    foreach ($dirs_deny as $dir) {
        copy($src_path . '/deny.htaccess', $tgt_path . $dir . '/.htaccess');
    }
    $dirs_allow = array('data/tmp/cache', 'ext/static', 'contrib/static', 'core/static');
    foreach ($dirs_allow as $dir) {
        copy($src_path . '/allow.htaccess', $tgt_path . $dir . '/.htaccess');
    }
}