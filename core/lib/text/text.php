<?php

function text_token($params) {
    $languages = array($GLOBALS['SYSTEM']['variables']['language'], '');
    foreach ($languages as $language) {
        $text_include_file = $GLOBALS['SYSTEM']['uri_path'] . '/text.';
        if (!empty($language)) {
            $text_include_file .= $language . ".";
        } 
        $text_include_file .= "po";
        static $results = array();
        
        $key = implode(' ', $params);
        if (isset($results[$text_include_file][$key])) {
            return $results[$text_include_file][$key];
        }
        
        if (empty($language)) {
            $results[$text_include_file][$key] = $key;
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
                    $results[$text_include_file][$msgid] = $msgstr;
                    continue;
                }
            }
            fclose($fh);
        }
    }
    return $results[$text_include_file][$key];
}

?>
