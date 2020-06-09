<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * All general requests (trending, discover)
 */
class DiscoverRequests
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
   * Gets videos for a specific user
   */
  public function get ($type = 'user', $vars = []) {
    $endpoint = $this->instance->endpoints->get('m.discover-' . $type, $vars);
    $discover = $this->instance->request->call($endpoint)->response();
    return $discover;
  }
}
