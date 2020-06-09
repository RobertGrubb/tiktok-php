<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * All general requests (trending, discover)
 */
class DiscoverRequests
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
   * Gets videos for a specific user
   */
  public function get ($type = 'user', $vars = []) {
    $endpoint = $this->instance->endpoints->get('m.discover-' . $type, $vars);
    $discover = $this->instance->request->call($endpoint)->response();

    // If there is an error, set the error in the parent, return false.
    if (isset($discover->error)) return $this->instance->setError($discover->message);

    return $discover;
  }
}
