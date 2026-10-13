<?php

function GetIPDetails() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);
    // var_dump($xml->geoplugin_countryCode);
    return $xml->geoplugin_countryCode;
}

/* * *
 * This function used for second converted into hours minute and second.
 * @start : how many differents in each value
 * @totalsecond = loop end point.
 */

function SecondConvert($start, $totalsecond) {
    for ($i = $start; $i < $totalsecond; $i++) {
        $str = '';
        $str .= (!empty(floor($i / 3600))) ? floor($i / 3600) . ' Hours ' : "";
        $str .= (!empty(floor(($i / 60) % 60))) ? floor(($i / 60) % 60) . ' Min ' : "";
        $str .= (!empty(floor($i % 60))) ? ($i % 60) . ' Sec' : "";
        $arr[$i] = $str;
        $i += ($start - 1);
    }
    return $arr;
}

/**
 * This function used for convert date time as per provided timezone. 
 */
/* function dateToTimezone($current_timeZone, $dateTimeCurrentTimezone = null, $dateFormat = 'Y-m-d H:i:s'){

  $dateTimeCurrentTimezone = $dateTimeCurrentTimezone ? $dateTimeCurrentTimezone : date("Y-m-d H:i:s");

  $date = new DateTime($dateTimeCurrentTimezone, new DateTimeZone($current_timeZone));
  $date->setTimeZone(new DateTimeZone('UTC'));

  return $date->format($dateFormat);
  } */

function ConvertDateToUTC($date, $format = 'Y-m-d H:i:s') {

    $dt = new DateTime($date, new DateTimeZone('Asia/Kolkata'));
    /* echo $dt;
      return $date; */
    // change the timezone of the object without changing it's time
    $dt->setTimeZone(new DateTimeZone('UTC'));

    // format the datetime
    return $dt->format($format);
}

function ConvertDateTolocaltime($date, $format = 'Y-m-d h:i A') {
    if (empty($date) || strpos((string) $date, '0000-00-00') === 0) {
        return date($format);
    }
    try {
        $dt = new DateTime($date, new DateTimeZone('UTC'));
        $dt->setTimeZone(new DateTimeZone('Asia/Kolkata'));
        return $dt->format($format);
    } catch (Exception $e) {
        return date($format);
    }
}

function CustomAdvertisePath() {
    // return \Yii::$app->request->BaseUrl . '/upload/xml/';
    return S3_THUMB_CLOUDFRONT.'/xml/';
}

/**
 * Resolve best ImageName + ImageType for a video (homepage / detail / share).
 * Category & Video_GetDetail SPs often return empty ImageName for new uploads.
 */
function ResolveVideoDisplayThumbnail($videoId, $fallbackName = '', $fallbackType = '') {
    $videoId = (int) $videoId;
    $imgName = '';
    $imgType = '';
    if ($videoId > 0) {
        try {
            $thumbRow = Yii::$app->db->createCommand(
                "SELECT i.ImageName, i.ImageType
                 FROM video_thumbnail_images vti
                 INNER JOIN images i ON i.ImageID = vti.images_id
                 WHERE vti.video_id = :vid
                 ORDER BY CASE WHEN vti.type = '1' THEN 0 WHEN vti.type = '0' THEN 1 ELSE 2 END, vti.images_id ASC
                 LIMIT 1"
            )->bindValue(':vid', $videoId)->queryOne();
            if (!empty($thumbRow['ImageName'])) {
                $imgName = $thumbRow['ImageName'];
                $imgType = $thumbRow['ImageType'];
            }
            if ($imgName === '') {
                $genRow = Yii::$app->db->createCommand(
                    "SELECT ImageName, ImageType FROM images
                     WHERE VideoID = :vid AND (IsThumb = 1 OR ImageType = '1')
                     ORDER BY IsThumb DESC, ImageType ASC, ImageID ASC LIMIT 1"
                )->bindValue(':vid', $videoId)->queryOne();
                if (!empty($genRow['ImageName'])) {
                    $imgName = $genRow['ImageName'];
                    $imgType = $genRow['ImageType'];
                }
            }
        } catch (Exception $e) {
            // keep fallback
        }
    }
    if ($imgName === '' && $fallbackName !== '' && $fallbackName !== null) {
        $imgName = $fallbackName;
        $imgType = $fallbackType;
    }
    return array(
        'ImageName' => $imgName,
        'ImageType' => $imgType,
    );
}

/**
 * This function used for get image url from images table
 * $data : Images table data
 */
function ImagesUrl($data, $is_medium = false) {
    // $ImagesThumbPath = S3_BUCKETABSOLUTE_PATH.'/'.THUMBNAILS.'/'.THUMBNAILS_THUMB.'/';
    // Manual / library thumbs (ImageType 3 etc.) live under Thumbnails/ on new CDN
    $ImagesThumbPath = S3_THUMB_CLOUDFRONT . '/' . THUMBNAILS . '/';
    if ($is_medium) {
        // keep medium path for callers that still use it
        $ImagesThumbPath = S3_THUMB_CLOUDFRONT . '/' . THUMBNAILS . '/' . THUMBNAILS_MEDIUM . '/';
    }

    $generatedThumbPath = S3_VIDEO_BUCKETABSOLUTE_PATH;
    $imageType = null;
    $imageName = '';
    if (is_object($data)) {
        $imageType = isset($data->ImageType) ? $data->ImageType : null;
        $imageName = isset($data->ImageName) ? $data->ImageName : '';
    } else {
        $imageType = isset($data['ImageType']) ? $data['ImageType'] : null;
        $imageName = isset($data['ImageName']) ? $data['ImageName'] : '';
    }

    $imageName = ltrim((string) $imageName, '/');
    if ($imageName === '') {
        return '';
    }

    // Generated video thumbs live under Videos/ (or production/Videos/)
    $isGeneratedPath = (stripos($imageName, 'Videos/Thumb/') === 0
        || stripos($imageName, 'production/Videos/') === 0
        || stripos($imageName, 'Streaming/') === 0);
    if ((string) $imageType === '1' || $isGeneratedPath) {
        $url = $generatedThumbPath . $imageName;
    } else {
        // Library / manual thumbs (ImageType 3/4) under Thumbnails/
        $url = $ImagesThumbPath . $imageName;
    }
    // Avoid mixed-content black poster on https pages
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $url = preg_replace('#^http://#i', 'https://', $url);
    }
    return $url;
}

function Main_VideoUrl($split) {
    //$split = "https://transcodingvideo.s3.amazonaws.com/Videos/Thumb/9/mainvideo/Thumb_Videos_9_300_1452250316251_00001.png";
    $split = trim((string) $split);
    if ($split === '') {
        return '';
    }
    $count = strrpos($split, "/");
    if ($count === false) {
        return $split;
    }
    $prefix = substr($split, 0, $count);
    $last = substr($split, $count, strlen($split));
    $url = $prefix . '/mainvideo' . $last;
    /* $s3BucketDetail =  @getimagesize($prefix.'/mainvideo'.$last); 
      print_r( $s3BucketDetail);
     */
    if (@getimagesize($url)) {
        return $url;
    }
    return $split;
}

function checklowqualityvideo($videourl) {
    if (false === @file_get_contents($videourl, 0, null, 0, 1)) {
        return false;
    } else {
        return $videourl;
    }
}
