<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function js_embed_token($params) {
    load_library("set");
    foreach ($params as $key => $value) {
        if ($key == "tpl") {
            $tpl = find_template($value, "modules/widgets/lib/js-widget");
        }
        if ($key == "url") {
            $url = $value;
        }
        if ($key == "items") {
            $items = $value;
        }
    }
    if (!empty($tpl)) {
        //embed blank version of the template, for adding new rows in javascript
        $tpl_contents = file_get_contents($tpl);
    }
    if (empty($url) && !empty($tpl_contents)) { 
        //populate in javascript, just embed the template in html
        //optimize $tpl_contents (todo: lib for html optimizing)
        $embed_tpl[$value] = preg_replace('!\s+!', ' ', $tpl_contents);
        run_template("\n<span data-tpl='" . json_encode($embed_tpl) . "'></span>\n");
    } else {
        //populate in php, embed populated date in html
        $input["key"] = "";
        $postdata = http_build_query($input);
        $opts = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata,
                    'timeout' => 5 //seconds
                )
        );
        $context = stream_context_create($opts);
        $data_result = @file_get_contents($url, false, $context);
        if (!empty($data_result)) {
            $data = json_decode($data_result, true);
            if (!empty($items)) {
                embed_render($tpl_contents, $data[$items]);
            } else {
                embed_render($tpl_contents, $data);
            }
           
        }
        
    }
}

function embed_render($tpl, $data) {
    if (is_array($data)) {
        foreach ($data as $key=>$record) {
            embed_get_tokens($record, "row-");
            run_template($tpl);
            embed_unset_tokens("row-");
        }
    }
}

function embed_get_tokens($value, $prefix) {
    foreach ($value as $row_key => $row_value) {
        if (is_array($row_value) || is_object($row_value)) {
            repeat_get_tokens($row_value, $prefix . $row_key . '-');
        } else {
            $GLOBALS['SYSTEM']['variables'][$prefix . $row_key] = $row_value;
        }
    }
}

function embed_unset_tokens($prefix) {
    foreach ($GLOBALS['SYSTEM']['variables'] as $key => $value ) {
        if (strpos($key, $prefix) === 0) {
            unset($GLOBALS['SYSTEM']['variables'][$key]); 
        }
    }
}


