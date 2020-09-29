<?php

namespace TikTok\Core\Resources;

class Endpoints {

  // Set the default user agent if one is not given.
  public $defaultUserAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36';

  /**
   * Store specific headers that need to be sent
   * with the request to endpoints.
   */
  public $headers = [
    'web' => [
      'Authority'       => 'www.tiktok.com',
      'Upgrade-Insecure-Requests' => '1',
      'User-Agent'      => '',
      'Sec-Fetch-Dest'  => 'document',
      'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
      'Sec-Fetch-Site'  => 'none',
      'Sec-Fetch-Mode'  => 'navigate',
      'Sec-Fetch-User'  => '?1',
      'Accept-Language' => 'en-US,en;q=0.9',
      'Referer'         => 'https://www.tiktok.com/'
    ],
    'm'  => [
      'Accept'          => 'application/json, text/plain, */*',
      'User-Agent'      => 'okhttp',
      'Origin'          => 'https://www.tiktok.com',
      'Referer'         => 'https://www.tiktok.com/',
      'Accept-Language' => 'en-US,en;q=0.9',
    ]
  ];

  /**
   * Break endpoints up into two different arrays.
   * The web endpoints are handled differently than the
   * m.tiktok.com endpoints ( need to be signed ).
   */
  public $endpoints = [

    'web' => [
      // @EXPERIMENTAL Session stuff
      'session-id'   => 'https://sgali-mcs.byteoversea.com/v1/user/ssid',
      'web-id'       => 'https://sgali-mcs.byteoversea.com/v1/user/webid',

      // Users
      'user-details' => 'https://www.tiktok.com/@{username}',
      'user-video'   => 'https://www.tiktok.com/@{username}/video/{id}',

      // Hashtags
      'hashtag-data' => 'https://www.tiktok.com/tag/{hashtag}?pageType=6',

      // Music
      'music-data'   => 'https://www.tiktok.com/music/{slug}',

      // Web
      'home'   => 'https://www.tiktok.com/'
    ],

    'm' => [
      'user-videos'  => [
        'url'  => 'https://m.tiktok.com/api/item_list/?',
        'vars' => [
          'aid'             => 1988,
          'app_name'        => 'tiktok_web',
          'device_platform' => 'web',
          'referer'         => '',
          'cookie_enabled'  => true,
          'did'             => '',
          'count'           => 30,
          'id'              => '', // required to be passed
          'type'            => 1,
          'secUid'          => '',
          'maxCursor'       => 0,
          'minCursor'       => 0,
          'sourceType'      => '8',
          'appId'           => '1233',
          'region'          => 'US',
          'language'        => 'en'
        ]
      ],

      'trending'    => [
        'url'  => 'https://m.tiktok.com/api/item_list/?',
        'vars' => [
          'aid'             => 1988,
          'app_name'        => 'tiktok_web',
          'device_platform' => 'web',
          'referer'         => '',
          'cookie_enabled'  => true,
          'did'             => '',
          'secUid'          => '',
          'id'              => 1,
          'type'            => 5,
          'count'           => 25,
          'minCursor'       => 0,
          'maxCursor'       => 0,
          'language'        => 'en',
          'sourceType'      => '12',
          'verifyFp'        => '',
          'region'          => 'US',
          'appId'           => '1233'
        ]
      ],

      'discover-user' => [
        'url' => 'https://m.tiktok.com/api/discover/user/?',
        'vars' => [
          'aid'             => 1988,
          'app_name'        => 'tiktok_web',
          'device_platform' => 'web',
          'referer'         => '',
          'cookie_enabled'  => true,
          'did'             => '',
          'discoverType'    => 0,
          'needItemList'    => 'false',
          'keyWord'         => '',
          'offset'          => 0,
          'count'           => 28,
          'useRecommend'    => 'false',
          'language'        => 'en'
        ]
      ],

      'discover-music' => [
        'url' => 'https://m.tiktok.com/api/discover/music/?',
        'vars' => [
          'aid'             => 1988,
          'app_name'        => 'tiktok_web',
          'device_platform' => 'web',
          'referer'         => '',
          'cookie_enabled'  => true,
          'did'             => '',
          'discoverType'    => 0,
          'needItemList'    => 'false',
          'keyWord'         => '',
          'offset'          => 0,
          'count'           => 28,
          'useRecommend'    => 'false',
          'language'        => 'en'
        ]
      ],

      'discover-hashtag' => [
        'url' => 'https://m.tiktok.com/api/discover/challenge/?',
        'vars' => [
          'aid'             => 1988,
          'app_name'        => 'tiktok_web',
          'device_platform' => 'web',
          'referer'         => '',
          'cookie_enabled'  => true,
          'did'             => '',
          'discoverType'    => 0,
          'needItemList'    => 'false',
          'keyWord'         => '',
          'offset'          => 0,
          'count'           => 28,
          'useRecommend'    => 'false',
          'language'        => 'en'
        ]
      ],

      'hashtag-videos'   => [
        'url' => '',
        'vars' => [
          'secUid'    => '',
          'id'        => '',
          'type'      => 3,
          'count'     => 30,
          'minCursor' => 0,
          'maxCursor' => 0,
          'shareUid'  => '',
          'language'  => 'en',
          'verifyFp'  => ''
        ]
      ],

      'music-videos' => [
        'url'  => 'https://m.tiktok.com/api/item_list/?',
        'vars' => [
          'aid'             => 1988,
          'app_name'        => 'tiktok_web',
          'device_platform' => 'web',
          'referer'         => '',
          'cookie_enabled'  => true,
          'did'             => '',
          'secUid'          => '',
          'id'              => '',
          'type'            => 1,
          'count'           => 25,
          'minCursor'       => 0,
          'maxCursor'       => 0,
          'language'        => 'en',
          'sourceType'      => '11',
          'verifyFp'        => '',
          'region'          => 'US',
          'appId'           => '1233'
        ]
      ],
    ]
  ];

  /**
   * Class construction
   */
  public function __construct ($config = null) {
    $this->config = $config;

    // Set user agent
    if (isset($this->config->userAgent)) {
      $this->headers['web']['User-Agent'] = $this->config->userAgent;
      $this->headers['m']['User-Agent']   = $this->config->userAgent;
    } else {
      $this->headers['web']['User-Agent'] = $this->defaultUserAgent;
      $this->headers['m']['User-Agent']   = $this->defaultUserAgent;
    }
  }

  /**
   * Gets a specific endpoint, then handles the url
   * building. For web, it's simply merging variables.
   *
   * For 'm' endpoints, it must be signed.
   */
  public function get ($endpoint, $vars = [], $customUserAgent = false) {
    $endpointParts = explode('.', $endpoint);
    $type = $endpointParts[0];
    $point = $endpointParts[1];

    // If not found
    if (!isset($this->endpoints[$type][$point])) return false;

    // Web endpoints
    if ($type === 'web') {
      $url = $this->endpoints[$type][$point];

      foreach ($vars as $key => $val) {
        $url = str_replace('{' . $key . '}', $val, $url);
      }

      return $url;

    // 'm' endpoints
    } else {

      $url = $this->endpoints[$type][$point]['url'];
      $endpointVars = $this->endpoints[$type][$point]['vars'];

      // Gotta do some signing here.
      return $this->buildUrl($url, array_merge($endpointVars, $vars), $customUserAgent);
    }
  }

  /**
   * Builds url for the 'm' type endpoints.
   * Anything that reaches https://m.tiktok.com needs to be
   * signed.
   */
  private function buildUrl ($url, $vars, $customUserAgent = false) {

    // Build the URL and query string
    $url = $url . http_build_query($vars) . '&verifyFp=';

    $signature = [];

    if ($this->config->signMethod === 'datafetch') {

      // Sign the url with DataFetch
      $signature = \TikTok\Core\Libraries\DataFetch::sign(
        $url,
        ($customUserAgent ? $customUserAgent : $this->headers['m']['User-Agent']),
        $this->config->datafetchApiKey
      );
    } else {

      // Sign the url with node
      $signature = \TikTok\Core\Libraries\Signer::execute(
        $url,
        ($customUserAgent ? $customUserAgent : $this->headers['m']['User-Agent'])
      );
    }

    // Return the URL
    return isset($signature['url']) ? $signature['url'] : false;
  }
}
