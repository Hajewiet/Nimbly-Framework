<?php

function set_token($params) {
    global $SYSTEM;
    foreach ($params as $key => $value) {
        $append = get_param_value($params, "append", false);
        $overwrite = $append == false && get_param_value($params, "overwrite", false);
        set_variable($key, $value, $append, $overwrite);
    }
    return null;
}

function set_variable($key, $value, $append = "append", $overwrite = false) {
    global $SYSTEM;
    if (empty($SYSTEM['variables'][$key])) {
        $SYSTEM['variables'][$key] = $value;
        return;
    }
    if ($append == "append") {
        $SYSTEM['variables'][$key] .= ' ' . $value;
        return;
    }
    if (!empty($append) && $append !== false) {
        $SYSTEM['variables'][$key] .= $append . $value;
        return;
    }
    if (!empty($overwrite) && $overwrite !== false) {
        $SYSTEM['variables'][$key] = $value;
        return;
    }
}

?>
