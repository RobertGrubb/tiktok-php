<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * Trending related methods
 */
class TrendingRequests
{

  // Parent instance holder
  private $instance = null;

  /**
   * Class constructor
   */
  public function __construct ($instance) {
    $this->instance  = $instance;
  }

  /**
   * Gets trending videos
   */
  public function videos ($count = 25) {
    $endpoint = $this->instance->endpoints->get('m.trending', [ 'count' => $count ]);
    $trending = $this->instance->request->call($endpoint)->response();

    // If there is an error, set the error in the parent, return false.
    if (isset($trending->error)) return $this->instance->setError($trending->message);

    $trending->videoDownloadData = [
      'userAgent' => $this->instance->endpoints->headers['m']['User-Agent'],
      'cookies' => [
        'tt_webid' => $this->instance->request->cookieJar->getCookieValue('tt_webid'),
        'tt_webid_v2' => $this->instance->request->cookieJar->getCookieValue('tt_webid_v2')
      ]
    ];

    return $trending;
  }
}
