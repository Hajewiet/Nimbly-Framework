<?php

function system_messages_token($params) {
    load_library("session");
    if (!session_exists()) {
        return "";
    }
    session_token();
    if (empty($_SESSION['SYSTEM']['messages'])) {
        return "";
    } else if (is_array($_SESSION['SYSTEM']['messages'])){
        load_library("set");
        $tpl = find_template("system-messages", 'lib/system-messages');
        foreach ($_SESSION['SYSTEM']['messages'] as $msg) {
            set_variable("system_message", $msg, false, true);
            run($tpl);
        }
        unset($_SESSION['SYSTEM']['messages']);
    }
}
