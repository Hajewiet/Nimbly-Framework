<?php

function memory_usage_sc() {
	echo round(memory_get_usage()/1024) . 'kb';
}