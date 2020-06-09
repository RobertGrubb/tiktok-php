<?php

namespace TikTok\Core\Libraries;

class Downloader {

  /**
   * Finds the composer vendor bin path
   * so node can be called.
   */
  public static function video($url, $destination = './') {
    $fileName = time() . '.mp4';
    $destination = (substr($destination, -1) === '/' ? $destination : $destination . '/');
    $filePath = $destination . $fileName;

    $ch = curl_init($url);
    $fp = fopen($filePath, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    return (object) [
      'success' => true,
      'file' => $filePath
    ];
  }
}
