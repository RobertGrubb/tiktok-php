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

  /**
   * Class constructor
   */
  public function __construct ($instance) {
    $this->instance  = $instance;
  }

  /**
   * Gets details for a specific user.
   */
  public function details ($username) {
    $endpoint = $this->instance->endpoints->get('web.user-details', [ 'username' => $username ]);
    $nextData = $this->instance->request->call($endpoint)->extract();
    if (isset($nextData->error)) return $nextData;
    $userData = (new \TikTok\Core\Models\User())->fromNextData($nextData);
    return $userData;
  }

  /**
   * Gets videos for a specific user
   */
  public function videos ($id, $count = 30) {
    $endpoint = $this->instance->endpoints->get('m.user-videos', [ 'id' => $id, 'count' => $count ]);
    $videos = $this->instance->request->call($endpoint)->response();
    return $videos;
  }

  public function video($username, $id) {
    $endpoint = $this->instance->endpoints->get('web.user-video', [ 'username' => $username, 'id' => $id ]);
    $nextData = $this->instance->request->call($endpoint)->extract();
    if (isset($nextData->error)) return $nextData;
    $videoData = (new \TikTok\Core\Models\Video())->fromNextData($nextData);
    return $videoData;
  }
}
