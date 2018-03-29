<?php

require_once("Parsedown.class.php");

/**
 * @doc `[markdown _hello_ markdown **world**]` converts markdown syntax to html: _hello_ markdown **world**
 */
function markdown_sc($params) {
    $txt = implode(' ', $params);
    return markdown_to_html($txt);
}

function markdown_to_html($md_text) {
	if (empty($md_text)) {
		return '';
	}

	static $Parsedown = null;
  	if ($Parsedown === null) {
     	$Parsedown = new Parsedown();
  	}
	return $Parsedown->text($md_text);
}