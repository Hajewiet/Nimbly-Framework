<?php

/** 
 *  @doc * `[ago (timestamp)]` outputs amount of days ago since the _timestamp_, example: 5 days ago, or 12 seconds ago
 */

function ago_sc($params) {
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