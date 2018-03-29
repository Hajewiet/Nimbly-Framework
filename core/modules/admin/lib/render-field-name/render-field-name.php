<?php

load_library('get');

function render_field_name_sc($params) {

    $fields = array('name', 'title', 'email', 'uuid', 'key');
    foreach ($fields as $f) {
        $v = trim(strip_tags(get_variable('record.' . $f)));
        if (!empty($v)) {
            return "{$v}";
        }
    }
    return '';
}
