<?php

validate_field('name', 'username', '[text validate_invalid_user_or_password]');
validate_field('password', 'password', '[text validate_invalid_user_or_password]');

if (validate_error_count() === 0) {
    $login_ok = persist_login(filter_input(INPUT_POST, 'username'), filter_input(INPUT_POST, 'password'));
}
