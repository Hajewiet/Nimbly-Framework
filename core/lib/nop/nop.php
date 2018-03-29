<?php

/**
 * @doc [nop] does nothing (no operation). Can be used to disable a shortcode in your template: `[nop ipsum words=5000]` does nothing
 */ 
function nop_sc($params) {
    return; 
}
