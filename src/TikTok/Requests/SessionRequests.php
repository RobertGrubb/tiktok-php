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

  /**
   * Call the homepage of TikTok to get the set-cookie
   * headers so it can be saved to the cookie jar.
   */
  public function resetCookies () {
    $endpoint = $this->instance->endpoints->get('web.home');
    $this->instance->request->call($endpoint)->saveCookies();
  }

  /**
   * Call the homepage of TikTok to get the set-cookie
   * headers so it can be saved to the cookie jar.
   */
  public function initialCall () {
    $endpoint = $this->instance->endpoints->get('web.home');
    $this->instance->request->call($endpoint)->saveCookies();
  }

  /**
   * @EXPERIMENTAL: Get SessionId
   */
  public function ssid () {
    if (!$this->instance->request->savedCookies()) return false;

    $endpoint = $this->instance->endpoints->get('web.session-id');

    $webId = $this->instance->request->cookieJar->getCookieValue('tt_webid_v2');

    // Send a request to the api responsible for setting session id
    $res = $this->instance
      ->request
      ->setPostParams([
        'app_id'         => 1988,
        'user_unique_id' => $webId,
        'web_id'         => $webId
      ])
      ->call($endpoint)
      ->response();

    return $res;
  }

  /**
   * @EXPERIMENTAL: Get webid
   */
  public function webid () {
    if ($this->instance->request->savedCookies()) return $this;

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
      ->saveCookies();

    return $this;
  }
}
