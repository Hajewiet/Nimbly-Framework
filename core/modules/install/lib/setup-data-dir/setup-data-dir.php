<?php

function setup_data_dir_token($params) {
    $result = true;
    $data_path = $GLOBALS['SYSTEM']['file_base'];
    $dirs = array('data', 'ext', 'ext/static', 'ext/lib', 'ext/modules',
        'ext/tpl', 'ext/uri', '_contrib', 'contrib/static', 'contrib/lib',
        'contrib/uri', 'contrib/tpl', 'contrib/modules', 'data/tmp', 'data/tmp/cache',
        'data/tmp/logs', 'data/tmp/sessions');
    foreach ($dirs as $dir) {
        if (!file_exists($dir)) {
            $result &= @mkdir($dir);
        }
    }

    
    $content = run_get_string("htaccess-allow-all");

    //file_put_contents(,,,);

    return $result;
}

?>