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
    $years = $days / 365;
    if ($years > 1) {
        return $years < 2 ? '1 year ago' : round($years) . ' years ago';
    }
    $months = $days / 30;
    if ($months > 1) {
        return $months < 2? '1 month ago' : round($months) . ' months ago';
    }
    $weeks = $days / 7;
    if ($weeks > 1) {
        return $weeks < 2? '1 week ago' : round($weeks) . ' weeks ago';
    }
    if ($days > 1) {
        return $days < 2? '1 day ago' : round($days) . ' days ago';
    }
    $hours = $elapsed / (60*60);
    if ($hours > 1) {
        return $hours < 2? '1 hour ago' : round($hours) . ' hours ago';
    }
    $minutes = $elapsed / 60;
    if ($minutes > 1) {
        return $minutes < 2? '1 minute ago' : round($minutes) . ' minutes ago';
    }
    return $elapsed < 2? '1 second ago' : round($elapsed) . ' seconds ago';       
}