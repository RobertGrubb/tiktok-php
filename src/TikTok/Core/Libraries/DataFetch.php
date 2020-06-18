<?php

namespace TikTok\Core\Libraries;

class DataFetch {

  /**
   * Used to communicate with the Heartbeat API
   */
  public static function sign($url, $userAgent, $key = null) {
      // Initiate CURL
      $ch = curl_init();

      $link = 'https://tiktok.datafet.ch/sign';

      if (!is_null($key)) $link .= '?key=' . $key;

      echo $link . PHP_EOL . PHP_EOL;

      $vars = [
        'url' => $url,
        'userAgent' => $userAgent
      ];

      // Set the URL
      curl_setopt($ch, CURLOPT_URL, $link);

      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vars));
      curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

      // receive server response ...
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Get the response
      $response = curl_exec($ch);

      // Close CURL
      curl_close ($ch);

      // Decode the response
      $response = json_decode($response);

      return (array) $response;
  }
}
