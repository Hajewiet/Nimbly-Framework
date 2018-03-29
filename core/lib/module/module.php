<?php

/**
 * @doc `[module (module names)]` loads one or more modules by name, e.g.: `[module user forms]`
 */
function module_sc($params) {
    foreach ($params as $key => $value) {
        if ($key === $value) {
            load_module($key);
        }
    }
    return null;
}
