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

  /**
   * Class constructor
   */
  public function __construct ($instance) {
    $this->instance  = $instance;
  }

  /**
   * @EXPERIMENTAL: Get SessionId
   */
  public function ssid ($userUniqueId, $webId) {
    if (!$this->instance->valid($userUniqueId, $webId)) return false;

    $endpoint = $this->instance->endpoints->get('web.session-id');

    // Send a request to the api responsible for setting session id
    $res = $this->instance
      ->request
      ->setPostParams([
        'app_id'         => 1988,
        'user_unique_id' => $userUniqueId,
        'web_id'         => $webId
      ])
      ->call($endpoint)
      ->response();

    print_r($res);
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
        'url'        => 'https://www.tiktok.com/',
        'user_agent' => $this->instance->endpoints->defaultUserAgent
      ])
      ->call($endpoint)
      ->response();

    print_r($res);
  }
}
