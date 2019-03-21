<?php

load_library('cache');
cache_clear();

load_library('system-messages');
system_message('Cache cleared');