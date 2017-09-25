<?php

function render_field_value_sc($params) {
    load_library('get');
    $key = get_variable('field.key');
    $type = get_variable('field.type');
    $value = get_variable('record.' . $key);
    $func = "render_field_" . str_replace('-', '_', $type);
    if (function_exists($func)) {
        return call_user_func($func, $value);
    }
    return '? ' . $type;
}

function render_field_boolean($value) {
    return empty($value)? 'no' : 'yes';
}

function render_field_text($value) {
    if (empty($value)) {
        return '(empty)';
    }
    $value = trim(strip_tags($value));
    if (strlen($value) > 30) {
        $value = substr($value, 0, 30) . '...';
    }
    return $value;
}

function render_field_image($value) {
    if (empty($value)) {
        return '(empy)';
    }
    return sprintf('<img src="%s/60">', $value);
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

function render_field_pk($value) {
    return render_field_text($value);
}

function render_field_password($value) {
    return '************';
}
