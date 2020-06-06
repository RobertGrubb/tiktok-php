<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

// Resources
use TikTok\Core\Resources\Endpoints;

// Models
use TikTok\Core\Models\Account;

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

  public function details ($username) {
    $endpoint = $this->endpoints->get('web.user-details', [ 'username' => $username ]);
    $res = $this->request->call($endpoint);
    print_r($res);
  }
}
