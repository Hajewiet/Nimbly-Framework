<?php

function form_error_token($params) {
    
    if (empty($params)) {
        //return global errors
        $field = "_global";
    } else {
        $field = current($params);
    }
    
    if (empty($GLOBALS['SYSTEM']['validation_errors'][$field])) {
        return;
    }
    
    $errors = $GLOBALS['SYSTEM']['validation_errors'][$field];

    //eew... get this from a (backend) template
    $result = '<span class="errors">';
    foreach ($errors as $error) {
        $result .= '<span class="error">' . $error . '</span>';
    }
    $result .= '</span>';
    return $result;
}
 
?>
