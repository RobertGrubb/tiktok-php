<?php

namespace TikTok\Core\Resources;

class Endpoints {

  public $endpoints = [

    'web' => [
      'user-details' => 'https://www.tiktok.com/@{username}'
    ],

    'm' => [
      'user-videos'  => [
        'url'  => 'https://m.tiktok.com/api/item_list/?',
        'vars' => [
          'count'       => 30,
          'id'          => '', // required
          'type'        => 1,
          'secUid'      => '',
          'maxCursor'   => 0,
          'minCursor'   => 0,
          'sourceType'  => '8',
          'appId'       => '1233',
          'region'      => 'US',
          'language'    => 'en'
        ]
      ]
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

      $url = $this->endpoints[$type][$point]['url'];
      $endpointVars = $this->endpoints[$type][$point]['vars'];

      // Gotta do some signing here.
      return $this->buildUrl($url, array_merge($endpointVars, $vars));
    }
  }

  private function buildUrl($url, $vars) {

    // Build the URL and query string
    $url = $url . http_build_query($vars) . '&verifyFp=asdf';

    // Sign the URL
    $signature = \TikTok\Core\Libraries\Signer::execute($url, null);

    // Return the URL
    return isset($signature['url']) ? $signature['url'] : false;
  }
}
