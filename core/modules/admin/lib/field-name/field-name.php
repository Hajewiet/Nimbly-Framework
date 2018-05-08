<?php

function field_name_sc($params) {
    return ucfirst(trim(current($params), '. '));
}
