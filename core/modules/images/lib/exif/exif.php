<?php

function exif_get($file) {
    $result = array();

    $result['exif_pretty'] = "n/a";
    $result['exif_all'] = array();

    //get exif data (if any) (and exif is enabled)
    $raw_exif = false;
    if (function_exists("exif_read_data")) {
        $raw_exif = exif_read_data($f_to, 'ANY_TAG', true);
    }

    if ($raw_exif !== false) {

        $white_list = array(
            "IFD0" => array("Make", "Model", "Software", "DateTime"),
            "EXIF" => array("ExposureTime", "FNumber", "ISOSpeedRatings", "DateTimeOriginal", "ShutterSpeedValue", "ApertureValue", "FocalLength")
        );
        foreach ($white_list as $key => $sub_keys) {
            if (!isset($raw_exif[$key])) {
                continue;
            }
            foreach ($sub_keys as $sub_key) {
                if (!isset($raw_exif[$key][$sub_key])) {
                    continue;
                }
                $result['exif_all'][$key][$sub_key] = $raw_exif[$key][$sub_key];
            }
        }

        $result['exif_pretty'] = exif_pretty($result['exif_all']);
        $exif_date = exif_date($result['exif_all'], "Y-m-d");
        if (!empty($exif_date)) {
            $result['date'] = $exif_date;
        }
    }

    return $result;
}

function exif_pretty($exif_data) {

    //1. get camera make and model
    if (empty($exif_data["IFD0"]['Make'])) {
        return "n/a";
    } else {
        $make = $exif_data["IFD0"]['Make'];
        if ($make === "NIKON CORPORATION" || $make === "Canon") {
            //for nikon and canon, the brand name is already included in the model name
            $camera = $exif_data["IFD0"]['Model'];
        } else {
            $camera = $make . ' ' . $exif_data["IFD0"]['Model'];
        }
    }

    //2. get iso 
    if (empty($exif_data["EXIF"]['ISOSpeedRatings'])) {
        $iso = "ISO-UNKNOWN";
    } else {
        $iso = "ISO-" . $exif_data["EXIF"]['ISOSpeedRatings'];
    }

    //3. get focal length
    $focal_length = "Unknown focal length";
    if (!empty($exif_data["EXIF"]['FocalLength'])) {
        $fl =  exif_eval_div($exif_data["EXIF"]["FocalLength"]);
        if (!empty($fl)) {
            $focal_length = sprintf("%dmm", $fl);
        }
    }

    //4: get fstop
    $fstop = "Unknown F-Stop";
    if (!empty($exif_data["EXIF"]['FNumber'])) {
        $fs =  exif_eval_div($exif_data["EXIF"]["FNumber"]);
        if (!empty($fs)) {
            $fstop = sprintf("f/%.1f", $fs);
        }
    }
    
    //5: exposure time
    $exposure = "Unknown Exposure";
    if (!empty($exif_data["EXIF"]['ExposureTime'])) {
        $es =  exif_eval_div($exif_data["EXIF"]["ExposureTime"]);
        if (!empty($es)) {
            $exposure = sprintf("1/%d", 1/$es);
        }
    }

    $result = sprintf("%s, %s, %s, %s, %s", $camera, $iso, $focal_length, $fstop, $exposure);
    return $result;
}

function exif_eval_div($str) {
    $parts = explode('/', $str);
    if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1]) && $parts[1] != 0) {
        return $parts[0] / $parts[1];
    } else {
        return null;
    }
}

function exif_date($exif_data, $format) {
    if (isset($exif_data['EXIF']['DateTimeOriginal'])) {
        $ed = $exif_data['EXIF']['DateTimeOriginal'];
    } else if (isset($exif_data['IFD0']['DateTime'])) {
        $ed = $exif_data['IFD0']['DateTime'];
    } else {
        return null;
    }
    $date_in = date_create_from_format("Y:m:d H:i:s", $ed); //2016:12:07 12:12:59
    $result = date_format($date_in, $format);
    return $result;
}

