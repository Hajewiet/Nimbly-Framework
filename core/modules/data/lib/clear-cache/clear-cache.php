<?php

function clear_cache_sc() {
    load_library("cache");
    cache_clear();
    return "cache cleared";
}



