<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

// Resources
use TikTok\Core\Resources\Endpoints;


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
    $request
  ) {
    $this->instance  = $instance;
    $this->request   = $request;
    $this->endpoints = new Endpoints();
  }

  /**
   * Gets details for a specific user.
   */
  public function details ($username) {
    $endpoint = $this->endpoints->get('web.user-details', [ 'username' => $username ]);
    $nextData = $this->request->call($endpoint)->extract();
    $userData = (new \TikTok\Core\Models\User())->fromNextData($nextData);
    return $userData;
  }

  /**
   * Gets videos for a specific user
   * @TODO: Fix this
   */
  public function videos ($id) {
    $endpoint = $this->endpoints->get('m.user-videos', [ 'id' => $id ]);
    $videos = $this->request->call($endpoint)->response();
    return $videos;
  }
}
