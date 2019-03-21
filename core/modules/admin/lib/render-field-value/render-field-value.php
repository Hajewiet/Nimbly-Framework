<?php

load_library('get');
load_library('lookup');
load_library('base_url');

function render_field_value_sc($params) {
    $key = get_variable('field.key');
    $type = get_variable('field.type');
    if ($type === 'gallery') {
        $key .= '1';
    }
    $value = get_variable('record.' . $key);
    $func = "render_field_" . str_replace('-', '_', $type);
    if (function_exists($func)) {
        return call_user_func($func, $value);
    }
    return '? ' . $type;
}

function render_field_select($value) {
    $resource = get_variable('field.resource');
    if (!empty($resource)) {
        $v = lookup_data($resource, $value, 'name', false);
        if (empty($v)) {
            $v = lookup_data($resource, $value, 'title', false);
        }
    } else {
        $v = false;
    }
    return render_field_text($v);
}

function render_field_boolean($value) {
    return empty($value)? 'no' : 'yes';
}

function render_field_text($value, $max_length = 64, $clip = '...') {
    if (empty($value)) {
        return '(empty)';
    }
    $value = trim(strip_tags($value));
    if (strlen($value) > $max_length) {
        $value = substr($value, 0, $max_length - strlen($clip)) . $clip;
    }
    return $value;
}

function render_field_image($value) {
    if (empty($value)) {
        return '(empy)';
    }
    return sprintf('<img src="%s/img/%s/60?ratio=1">', base_url_sc(), $value);
}

function render_field_gallery($value) {
    return render_field_image($value);
}

function render_field_block_text($value) {
    return render_field_text($value);
}

function render_field_block_html($value) {
    return render_field_text($value);
}

function render_field_block_plain_text($value) {
    return render_field_text($value);
}

function render_field_date($value) {
    return render_field_text($value);
}

function render_field_name($value) {
    return render_field_text($value);
}

function render_field_textarea($value) {
    return render_field_text($value);
}

function render_field_pk($value) {
    return render_field_text($value);
}

function render_field_password($value) {
    return '************';
}