<?php

function thumbnail_sc($params) {

    $uuid = get_param_value($params, "uuid", current($params));
    $height = get_param_value($params, "h", 240) + 0;
    $ratio = get_param_value($params, "ratio", 0) + 0;
    return thumbnail_create($uuid, $height, $ratio);
}

function thumbnail_create($uuid, $h, $ratio=0) {

    // 1. Check cache

    load_library("data");
    $file_name = sprintf("%s_%s_%s.jpg", $uuid, $h, str_replace('.', '_', $ratio));
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

    $asp = $org_w / $org_h;
    $org_x = 0;
    $org_y = 0;

    //3: Calc thumbnail size given height and aspect ratio
    if (empty($ratio) || ($ratio < 0) || (abs($asp - $ratio) < 0.01))  {
        $w = $asp * $h;
    } else {
        $w = $ratio * $h;
        if ($ratio > $asp) {
            $new_h = $org_w / $ratio;
            $org_y = ($org_h - $new_h) / 2;
            $org_h = $new_h;
        } else {
            $new_w = $org_h * $ratio;
            $org_x = ($org_w - $new_w) / 2;
            $org_w = $new_w;
        }
    }
    $thumb_img = imagecreatetruecolor($w, $h);
    imagecopyresampled($thumb_img, $org_img, 0, 0, $org_x, $org_y, $w, $h, $org_w, $org_h);

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
