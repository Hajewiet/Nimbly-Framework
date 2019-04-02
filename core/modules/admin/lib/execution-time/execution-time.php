<?php

function execution_time_sc() {
	echo sprintf("%01.3fs", microtime(true) - $GLOBALS['SYSTEM']['request_time']);
}