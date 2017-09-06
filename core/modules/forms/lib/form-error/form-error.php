<?php

function form_error_sc($params) {
    
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
    $result = '<div class="form-alert">';
    foreach ($errors as $error) {
        $result .= '<span class="error-message">' . $error . '</span>';
    }
    $result .= '</div>';
    return $result;
}
 
?>
