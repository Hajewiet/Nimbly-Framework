<?php

/*
  Filter all external data.
  As mentioned earlier, data filtering is the most important practice you can
  adopt. By validating all external data as it enters and exits your application,
  you will mitigate a majority of XSS concerns.

  Use existing functions.
  Let PHP help with your filtering logic. Functions like htmlentities(),
  strip_tags(), and utf8_decode() can be useful. Try to avoid reproducing
  something that a PHP function already does. Not only is the PHP function much
  faster, but it is also more tested and less likely to contain errors that
  yield vulnerabilities.

  Use a whitelist approach.
  Assume data is invalid until it can be proven valid. This involves verifying
  the length and also ensuring that only valid characters are allowed.
  For example, if the user is supplying a last name, you might begin by only
  allowing alphabetic characters and spaces. Err on the side of caution.
  While the names O'Reilly and Berners-Lee will be considered invalid,
  this is easily fixed by adding two more characters to the whitelist.
  It is better to deny valid data than to accept malicious data.

 */

function validate_sc($params) {

}

$GLOBALS['SYSTEM']['validation_errors'] = array();

function validate_field($type, $input_name, $global_error = null) {
    $field_value = filter_input(INPUT_POST, $input_name);
    if (is_string($field_value)) {
        $input_value = $field_value;
    } else {
        $input_value = null;
    }
    $result = validate($type, $input_value);
    if ($result !== true) {
        $GLOBALS['SYSTEM']['validation_errors'][$input_name][] = $result;
        if (isset($global_error)) {
            $GLOBALS['SYSTEM']['validation_errors']['_global'][] = $global_error;
        }
    }
    return $result;
}

function validate($type, $input) {
    $function_name = "_validate_" . trim(strtolower($type));
    if (function_exists($function_name)) {
        return $function_name($input);
    }
    return false;
}

function validate_error_count() {
    return count($GLOBALS['SYSTEM']['validation_errors']);
}

function _validate_length($input, $max_length = 64) {
    if (empty($input)) {
        return "[text validate_empty]";
    }
    if (strlen($input) > $max_length) {
        return "[text validate_too_long]";
    }
    return true;
}

function _validate_name($input) {
    $result = _validate_length($input);
    if ($result !== true) {
        return $result;
    }
    $var = filter_var($input, FILTER_VALIDATE_REGEXP, array(
        "options" => array("regexp" => "/^[a-zA-Z0-9'´_\-\s]+$/")));
    if ($var === false) {
        return "[text validate_invalid_characters]";
    }
    return true;
}

function _validate_email($input) {
    $result = _validate_length($input);
    if ($result !== true) {
        return $result;
    }
    $var = filter_var($input, FILTER_VALIDATE_REGEXP, array(
        "options" => array("regexp" => "/^[a-zA-Z0-9'´@._\-\s]+$/")));
    if ($var === false) {
        return "[text validate_invalid_characters]";
    }
    return true;
}

function _validate_password($input) {
    $result = _validate_length($input);
    if ($result !== true) {
      return $result;
    }
    if (strlen($input) < 5) {
      return "[text validate_too_short]";
    }
    return true;
}

function _validate_text($input) {
  $allowed = array(' '); 
  return _validate_alphanumeric(str_replace($allowed, '', $input));
}

function _validate_alphanumeric($input) {
    $result = ctype_alnum($input);
    if ($result !== true) {
        return "[text validate_invalid_characters]";
    }
    return $result;
}
