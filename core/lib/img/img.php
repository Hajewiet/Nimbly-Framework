<?php

/**
 * @doc `[img width=600 caption="main image"]` generates an image placeholder (for prototyping)
 */
function img_sc(&$params) {
    $src = get_param_value($params, "src", null);
    if (empty($src)) {
        $src = img_generate_placeholder($params);
    }
    unset($params['src']);
    $result = '<img src="' . $GLOBALS['SYSTEM']['uri_base'] . $src . '" ';
    foreach ($params as $key => $value) {
        $result .= $key . '="' . $value . '" ';
    }
    $result .= " />";
    return $result;
}

/**
 * Generates an image placeholder
 * @param type $params sc parameters
 * - param['width']. Defaults to 500 px
 * - param['height']. Defaults to width/golden ratio
 * - param['caption']. Title text to show in the image, defaults to "image"
 * @return string img uri
 */
function img_generate_placeholder(&$params) {

    /*
     * 1. Initialize and get parameters
     */
    $result = "img/placeholder.png";
    $width = get_param_value($params, "width", 500);
    $height = ceil(get_param_value($params, "height", $width / 1.61803398875));
    $params['width'] = $width;
    $params['height'] = $height;
    $text = get_param_value($params, "caption", "image");

    /*
     * 2. Create footprint and return uri if img already exists in the cache.
     */
    $img_footprint = trim(base64_encode($width . $text . $height), '=/');
    $img_uri = 'img/placeholder_' . $img_footprint . '.png';

    load_library("cache");
    $img_path = $GLOBALS['SYSTEM']['cache_base'] . $img_uri;
    if (@file_exists($img_path)) {
        //exists in cache, just return the uri
        $result = $img_uri;
        return $result;
    }

    /*
     * 3. Fallback on static placeholder image if GD library is not available
     */
    if (false === extension_loaded("gd")
            || false === $img = @imagecreatetruecolor($width, $height)) {
        return $result;
    }

    /*
     * 4. Dynamically create image with PHP's GD library
     */
    $bg_color = imagecolorallocate($img, 200, 200, 200); //medium gray
    $line_color = imagecolorallocate($img, 175, 175, 175); //a bit darker
    $txt_color = imagecolorallocate($img, 150, 150, 150); //a bit darker

    //add background
    imagefilledrectangle($img, 0, 0, $width, $height, $bg_color);

    //add diagonal crossed lines
    if (function_exists("imageantialias")) {
        imageantialias($img, true);
    }
    imagesetthickness($img, 2);
    imageline($img, 0, 0, $width, $height, $line_color);
    imageline($img, $width, 0, 0, $height, $line_color);

    //add text
    $font_type = min(5, ceil($width / 100));
    $font_width = imagefontwidth($font_type);
    $font_height = imagefontheight($font_type);
    $text_width = $font_width * strlen($text);
    $text_x = ceil(($width - $text_width) / 2);
    $text_y = ceil(($height - $font_height) / 2);
    imagefilledrectangle($img, 0, $text_y - 2, $width, $text_y + $font_height + 2, $bg_color);
    imagestring($img, $font_type, $text_x, $text_y, $text, $txt_color);
    imagecolordeallocate($img, $line_color);
    imagecolordeallocate($img, $bg_color);
    imagetruecolortopalette($img, false, 3);

    //save image and clean up
    @mkdir(dirname($img_path), 0750, true);
    if (@imagepng($img, $img_path, 9)) {
        $result = $img_uri;
    }

    imagedestroy($img);

    return $result;
}
