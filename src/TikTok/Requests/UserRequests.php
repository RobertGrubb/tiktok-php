<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * All User related requests
 */
class UserRequests
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
   * Gets details for a specific user.
   */
  public function details ($username) {
    $endpoint = $this->endpoints->get('web.user-details', [ 'username' => $username ]);
    $nextData = $this->request->call($endpoint)->extract();
    if (isset($nextData->error)) return $nextData;
    $userData = (new \TikTok\Core\Models\User())->fromNextData($nextData);
    return $userData;
  }

  /**
   * Gets videos for a specific user
   */
  public function videos ($id, $count = 30) {
    $endpoint = $this->endpoints->get('m.user-videos', [ 'id' => $id, 'count' => $count ]);
    $videos = $this->request->call($endpoint)->response();
    return $videos;
  }
}
