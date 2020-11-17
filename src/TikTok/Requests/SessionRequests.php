<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * All session requests
 * @NOTE Experimental features
 */
class SessionRequests
{

  // Parent instance
  private $instance = null;

  private $webId = '';
  private $ssid  = '';

  /**
   * Class constructor
   */
  public function __construct ($instance) {
    $this->instance  = $instance;
  }

  public function saveVerifyFp ($fp) {
    $cookies = $this->instance->request->cookieJar->contents();

    foreach ($cookies as $key => $c) {
      if (strpos($c, 's_v_web_id') !== false) {
        $cookies[$key] = 's_v_web_id=' . $fp . '; domain=www.tiktok.com; path=/; expires=' . strtotime('+1 year');
      }
    }

    $this->instance->request->cookies = $cookies;
    $this->instance->request->saveCookies();

    return true;
  }

  public function generate ($customVerifyFp = null) {
    $cookies = [];

    $webRequest = $this->webid();

    if (!$webRequest) throw new \Exception('Unable to make web id request.');
    if (!isset($webRequest->web_id)) throw new \Exception('Unable to make web id request');

    $webId = $webRequest->web_id;
    $verifyFp = (!is_null($customVerifyFp) ? $customVerifyFp :$this->instance->fp->generate());

    $cookies[] = 's_v_web_id=' . $verifyFp . '; domain=www.tiktok.com; path=/; expires=' . strtotime('+1 year');
    $cookies[] = 'tt_webid=' . $webId . '; domain=www.tiktok.com; path=/; expires=' . strtotime('+1 year');
    $cookies[] = 'tt_webid_v2=' . $webId . '; domain=www.tiktok.com; path=/; expires=' . strtotime('+1 year');

    $this->instance->request->cookies = $cookies;
    $this->instance->request->saveCookies();

    return [
      'success' => true,
      'userAgent' => $this->instance->endpoints->headers['m']['User-Agent'],
      'cookies' => $cookies
    ];
  }

  /**
   * @EXPERIMENTAL: Get webid
   */
  public function webid () {
    $endpoint = $this->instance->endpoints->get('web.web-id');

    // Send a request to the api responsible for setting web id
    $res = $this->instance
      ->request
      ->setPostParams([
        'app_id'     => 1988,
        'referer'    => '',
        'url'        => 'https://www.tiktok.com/',
        'user_agent' => $this->instance->endpoints->defaultUserAgent,
        'user_unique_id' => ''
      ])
      ->call($endpoint)
      ->response();

    return $res;
  }
}
