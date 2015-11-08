<?php

function ago_token($params) {
    if (empty ($params)) {
        return;
    }
    $dt = current($params);
    $now = time();
    $elapsed = $now - $dt;
    $days = $elapsed / (24*60*60);
    if ($days > 1) {
        return round($days) . " days ago";
    }
    $hours = $elapsed / (60*60);
    if ($hours > 1) {
        return round($hours) . " hours ago";
    }
    $minutes = $elapsed / 60;
    if ($minutes > 1) {
        return round($minutes) . " minutes ago";
    }
    if ($elapsed < 1) {
        return "1 second ago";
    }
    return round($elapsed) . " seconds ago";        
}