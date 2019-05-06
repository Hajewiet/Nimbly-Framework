<?php

function plain_text($html) {
	return preg_replace( "/\n\s+/", "\n", rtrim(html_entity_decode(strip_tags($html)))); 
}