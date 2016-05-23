<?php

function module_sc($params) {
    foreach ($params as $key => $value) {
        if ($key === $value) {
            load_module($key);
        }
    }
    return null;
}
