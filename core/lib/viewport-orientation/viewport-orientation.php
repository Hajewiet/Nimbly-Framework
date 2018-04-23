<?php

function viewport_orientation_sc() {
	$val = filter_input(INPUT_COOKIE, "nb_device_portrait");
	if (filter_var($val, FILTER_VALIDATE_BOOLEAN)) {
		return "portrait";
	}
    return "landscape";
}
