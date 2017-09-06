<?php

function thumbnail_sc($params) {

    $uuid = get_param_value($params, "uuid", current($params));
    $height = get_param_value($params, "h", 240) + 0;
    return thumbnail_create($uuid, $height);
}

function thumbnail_create($uuid, $h) {

    // 1. Check cache

    load_library("data");
    $file_name = sprintf("%s_%s.jpg", $uuid, $h);
    $path = sprintf(".tmp/thumb/%s", $file_name);
    $cache_path = $GLOBALS['SYSTEM']['data_base'] . '/' . $path;

    if (@file_exists($cache_path)) {
        return $cache_path;
    }

    // 2. Create thumbnail from original

    $org_path = sprintf("%s/.files/%s", $GLOBALS['SYSTEM']['data_base'], $uuid);
    list($org_w, $org_h, $org_type) = @getimagesize($org_path);
    switch ($org_type) {
        case IMAGETYPE_GIF:
            $org_img = imagecreatefromgif($org_path);
            break;
        case IMAGETYPE_JPEG:
            $org_img = imagecreatefromjpeg($org_path);
            break;
        case IMAGETYPE_PNG:
            $org_img = imagecreatefrompng($org_path);
            break;
    }
    $result = "";

    if (empty($org_img)) {
        return $result;
    }

    //3: Calc aspect ratio and size

    $asp = $org_w / $org_h;
    $w = $asp * $h;
    $thumb_img = imagecreatetruecolor($w, $h);
    imagecopyresampled($thumb_img, $org_img, 0, 0, 0, 0, $w, $h, $org_w, $org_h);

    //4: save image to cache

    @mkdir(dirname($cache_path), 0750, true);

    if (imagejpeg($thumb_img, $cache_path, 90)) {
        $result = $cache_path;
    }

    //5: clean up and return result

    imagedestroy($org_img);
    imagedestroy($thumb_img);
    return $result;
}
