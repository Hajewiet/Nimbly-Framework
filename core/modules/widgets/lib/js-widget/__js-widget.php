<?php

function js_widget_token($params) {
    foreach ($params as $key => $value) {
        if ($key == "tpl") {
            $tpl = find_template($value, "modules/widgets/lib/js-widget");
        }
        if ($key == "data") {
            $data = $value;
        }
        if ($key == "json") {
            $data['url'] = $value;
            $data['type'] = "json";
            $data['key'] = "test";
            $data['async'] = false;
        }
    }

    if (isset($data)) {
        $GLOBALS['SYSTEM']['variables']['js-data'] = json_encode($data);
    }
    
    run_template("\n<div class=\"js-data nojs\" data-src='[js-data]'>\n");
    
    if (isset($tpl) && !empty($tpl)) {
        if (isset($data['url']) && isset($data['type'])) {
            //retrieve data (unless async/lazy is set)
            $src_url = $data['url'];
            $input["key"] = $data['key'];
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
            $data_result = @file_get_contents($src_url, false, $context);
            $GLOBALS['SYSTEM']['variables']['js-data-raw'] = $data_result;
        } else {
            $GLOBALS['SYSTEM']['variables']['js-data-raw'] = "";
        }
        run($tpl);
    } else {
        echo "Template \"" . $tpl . "\" not found.";
    }
    run_template("\n</div>\n");
}
?>