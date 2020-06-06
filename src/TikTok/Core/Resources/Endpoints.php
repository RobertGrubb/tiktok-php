<?php

namespace TikTok\Core\Resources;

class Endpoints {

  public $endpoints = [

    'web' => [
      'user-details' => 'https://www.tiktok.com/@{username}'
    ],

    'm' => [
      'user-videos'  => ''
    ]
  ];

  public function get($endpoint, $vars = []) {
    $endpointParts = explode('.', $endpoint);
    $type = $endpointParts[0];
    $point = $endpointParts[1];

    if (!isset($this->endpoints[$type][$point])) return false;

    if ($type === 'web') {
      $url = $this->endpoints[$type][$point];

      foreach ($vars as $key => $val) {
        $url = str_replace('{' . $key . '}', $val, $url);
      }

      return $url;
    } else {

      // Gotta do some signing here.
      return false;
    }
  }
}
