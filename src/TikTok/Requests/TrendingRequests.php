<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * Trending related methods
 */
class TrendingRequests
{

  // setError function from parent.
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
    return $trending;
  }
}
