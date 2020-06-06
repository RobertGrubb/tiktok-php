<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * All User related requests
 */
class GeneralRequests
{

  /**
   * Request instance holders
   */
  private $request = null;

  // All endpoints for dom and api requests
  private $endpoints    = null;

  // setError function from parent.
  private $instance = null;

  /**
   * Class constructor
   */
  public function __construct (
    $instance,
    $request,
    $endpoints
  ) {
    $this->instance  = $instance;
    $this->request   = $request;
    $this->endpoints = $endpoints;
  }

  /**
   * Gets videos for a specific user
   */
  public function trending ($count = 25) {
    $endpoint = $this->endpoints->get('m.trending', [ 'count' => $count ]);
    $trending = $this->request->call($endpoint)->response();
    return $trending;
  }

  /**
   * Gets videos for a specific user
   */
  public function discover ($type = 'user', $vars = []) {
    $endpoint = $this->endpoints->get('m.discover-' . $type, $vars);
    $discover = $this->request->call($endpoint)->response();
    return $discover;
  }
}
