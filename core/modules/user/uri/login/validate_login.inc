<?php

validate_field('email', 'email', '[text validate_invalid_email_or_password]');
validate_field('password', 'password', '[text validate_invalid_email_or_password]');

if (validate_error_count() === 0) {
    $login_ok = persist_login(filter_input(INPUT_POST, 'email'), filter_input(INPUT_POST, 'password'));
}
