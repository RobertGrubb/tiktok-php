<?php

namespace TikTok\Core\Libraries;

class Downloader {

  /**
   * Downloads the music mp3
   */
  public static function music ($uri, $destination = './', $customName = false) {
    $fileName = ($customName ? $customName : time()) . '.mp3';
    $destination = (substr($destination, -1) === '/' ? $destination : $destination . '/');
    $filePath = $destination . $fileName;

    $url = 'https://p16-va-tiktok.ibyteimg.com/obj/' . $uri;

    $ch = curl_init($url);
    $fp = fopen($filePath, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Referer: https://www.tiktok.com/",
      "User-Agent: okhttp"
    ]);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    return (object) [
      'success' => true,
      'file' => $filePath
    ];
  }

  /**
   * Downloads the video
   */
  public static function video ($url, $destination = './') {
    $fileName = time() . '.mp4';
    $destination = (substr($destination, -1) === '/' ? $destination : $destination . '/');
    $filePath = $destination . $fileName;

    $ch = curl_init($url);
    $fp = fopen($filePath, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Referer: https://www.tiktok.com/",
      "User-Agent: okhttp"
    ]);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    return (object) [
      'success' => true,
      'file' => $filePath
    ];
  }

  public static function getUrlWithoutWatermark ($url) {
    $videoKey = self::getKey($url);
    if ($videoKey === false) return false;
    echo $videoKey;
    $url = "https://api2-16-h2.musical.ly/aweme/v1/play/?video_id=$videoKey&vr_type=0&is_play_url=1&source=PackSourceEnum_PUBLISH&media_type=4";
    return $url;
  }

  /**
   * Credits to: @TufayelLUS
   */
  public static function getKey($url) {
  	$ch = curl_init();
    $key = false;

  	$headers = [
      'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
      'Accept-Encoding: gzip, deflate, br',
      'Accept-Language: en-US,en;q=0.9',
      'Range: bytes=0-200000',
      'Referer: https://www.tiktok.com/',
      'User-Agent: okhttp'
  	];

    $options = array(
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
        CURLOPT_ENCODING       => "utf-8",
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_MAXREDIRS      => 10,
    );

    curl_setopt_array($ch, $options);
    $data = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $tmp = explode("vid:", $data);
    if (count($tmp) > 1) $key = trim(explode("%", $tmp[1])[0]);

    return $key;
  }
}
