<?php

function text_token($params) {
    $languages = array($GLOBALS['SYSTEM']['variables']['language'], '');
    $paths = array(
        $GLOBALS['SYSTEM']['file_base'] . 'data/i18n/text.',
        $GLOBALS['SYSTEM']['uri_path'] . '/text.');
    foreach ($languages as $language) {
        foreach ($paths as $path) {
            $text_include_file = $path;
            if (!empty($language)) {
                $text_include_file .= $language . ".";
            }
            $text_include_file .= "po";
            static $results = array();

            $key = implode(' ', $params);
            if (isset($results[$key])) {
                return $results[$key];
            }

            if (empty($language)) {
                $results[$key] = $key;
            }

            $fh = @fopen($text_include_file, "r");
            if ($fh !== false) {
                $msgid = "";
                $msgstr = "";
                while (!feof($fh)) {
                    $line = fgets($fh);
                    if (stripos($line, "msgid") === 0) {
                        $str_start = strpos($line, '"') + 1;
                        $str_stop = strpos($line, '"', $str_start);
                        $msgid = substr($line, $str_start, $str_stop - $str_start);
                        continue;
                    }
                    if (stripos($line, "msgstr") === 0) {
                        $str_start = strpos($line, '"') + 1;
                        $str_stop = strpos($line, '"', $str_start);
                        $msgstr = substr($line, $str_start, $str_stop - $str_start);
                        $results[$msgid] = $msgstr;
                        continue;
                    }
                }
                fclose($fh);
            }
        }
    }
    return $results[$key];
}

?>
