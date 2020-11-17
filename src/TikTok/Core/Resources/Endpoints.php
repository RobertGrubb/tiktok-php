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
      'suggested' => [
        'url' => 'https://m.tiktok.com/node/share/discover?',
        'vars' => [
          'aid' => '1988',
          'app_name' => 'tiktok_web',
          'device_platform' => 'web',
          'referer' => 'https://www.tiktok.com',
          'cookie_enabled' => 'true',
          'priority_region' => '',
          'verifyFp' => '',
          'appId' => '1233',
          'region' => 'US',
          'appType' => 'm',
          'isAndroid' => 'false',
          'isMobile' => 'false',
          'isIOS' => 'false',
          'OS' => 'mac',
          'did' => '',
          'noUser' => '0',
          'userCount' => '30',
          'scene' => '15'
        ]
      ],

      'user-details' => [
        'url' => 'https://www.tiktok.com/node/share/user/@{username}?',
        'vars' => [
          'aid' => '1988',
          'app_name' => 'tiktok_web',
          'device_platform' => 'web',
          'referer' => 'https://www.tiktok.com',
          'cookie_enabled' => 'true',
          'screen_width' => '1440',
          'screen_height' => '900',
          'ac' => '4g',
          'page_referer' => 'https://www.tiktok.com/foryou?lang=en',
          'priority_region' => '',
          'appId' => '1233',
          'region' => 'US',
          'appType' => 'm',
          'isAndroid' => 'false',
          'isMobile' => 'false',
          'isIOS' => 'false',
          'OS' => 'mac',
          'did' => '',
          'isUniqueId' => 'true',
          'sec_uid' => '',
          'lang' => 'en',
          'uniqueId' => '',
          'validUniqueId' => ''
        ]
      ],

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
        'url' => 'https://m.tiktok.com/api/challenge/item_list/?',
        'vars' => [
          'aid'             => 1988,
          'count'           => 30,
          'cursor'          => 0,
          'challengeID'     => ''
        ],
        'disableSignature' => true
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

  public $validUserAgents = [
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.2 Safari/605.1.15',
    'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; en-en) AppleWebKit/533.19.4 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.59.10 (KHTML, like Gecko) Version/5.1.9 Safari/534.59.10',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/601.7.8 (KHTML, like Gecko)',
    'Mac OS X/10.6.8 (10K549); ExchangeWebServices/1.3 (61); Mail/4.6 (1085)',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/600.8.9 (KHTML, like Gecko)',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/601.7.8 (KHTML, like Gecko) Version/9.1.3 Safari/537.86.7',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.78.2 (KHTML, like Gecko) Version/6.1.6 Safari/537.78.2',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:16.0) Gecko/20100101 Firefox/16.0',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_3) AppleWebKit/601.4.4 (KHTML, like Gecko) Version/9.0.3 Safari/601.4.4',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/600.5.17 (KHTML, like Gecko) Version/8.0.5 Safari/600.5.17',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/601.6.17 (KHTML, like Gecko) Version/9.1.1 Safari/601.6.17',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/600.8.9 (KHTML, like Gecko) Version/8.0.8 Safari/600.8.9',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_5_8) AppleWebKit/534.50.2 (KHTML, like Gecko) Version/5.0.6 Safari/533.22.3',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:48.0) Gecko/20100101 Firefox/48.0',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/601.5.17 (KHTML, like Gecko) Version/9.1 Safari/601.5.17',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/600.8.9 (KHTML, like Gecko) Version/6.2.8 Safari/537.85.17',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_1) AppleWebKit/601.2.7 (KHTML, like Gecko) Version/9.0.1 Safari/601.2.7',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/600.3.18 (KHTML, like Gecko) Version/8.0.3 Safari/600.3.18',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/600.6.3 (KHTML, like Gecko) Version/8.0.6 Safari/600.6.3',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.7.12 (KHTML, like Gecko) Version/8.0.7 Safari/600.7.12',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/601.4.4 (KHTML, like Gecko) Version/9.0.3 Safari/601.4.4',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/601.3.9 (KHTML, like Gecko) Version/9.0.2 Safari/601.3.9',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Safari/602.1.50',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.78.2 (KHTML, like Gecko) Version/7.0.6 Safari/537.78.2',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36',
    'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/417.9 (KHTML, like Gecko) Safari/417.8'
  ];

  private $instance;

  /**
   * Class construction
   */
  public function __construct ($config = null, $instance) {
    $this->config = $config;
    $this->instance = $instance;

    // Set user agent
    if (isset($this->config->userAgent)) {
      $this->headers['web']['User-Agent'] = $this->config->userAgent;
      $this->headers['m']['User-Agent']   = $this->config->userAgent;
    } else {

      // Set a random user agent if one was not set.
      $randomValidUserAgent = $this->validUserAgents[array_rand($this->validUserAgents)];

      $this->headers['web']['User-Agent'] = $randomValidUserAgent;
      $this->headers['m']['User-Agent']   = $randomValidUserAgent;
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

      foreach ($vars as $key => $val) {
        $url = str_replace('{' . $key . '}', $val, $url);
      }

      $endpointVars = $this->endpoints[$type][$point]['vars'];

      // Gotta do some signing here.
      return $this->buildUrl($url, array_merge($endpointVars, $vars), $customUserAgent, (isset($this->endpoints[$type][$point]['disableSignature']) ? $this->endpoints[$type][$point]['disableSignature'] : false));
    }
  }

  /**
   * Builds url for the 'm' type endpoints.
   * Anything that reaches https://m.tiktok.com needs to be
   * signed.
   */
  private function buildUrl ($url, $vars, $customUserAgent = false, $ignoreSigning = false) {

    if ($ignoreSigning === true) {
      return $url . http_build_query($vars);
    }

    if ($this->instance->request->savedCookies()) {
      $fp = $this->instance->request->cookieJar->getCookieValue('s_v_web_id');

      if ($fp) {
        $url = $url . http_build_query($vars) . '&verifyFp=' . $fp;
      } else {
        $url = $url . http_build_query($vars) . '&verifyFp=';
      }
    } else {
      $url = $url . http_build_query($vars) . '&verifyFp=';
    }

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
