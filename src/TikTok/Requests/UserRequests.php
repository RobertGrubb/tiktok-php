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
  public function details ($username = null) {

    // Validate arguments
    if (!$this->instance->valid($username)) return false;

    // Check for the @ symbol, format accordingly.
    if (strpos($username, '@') === false) $username = '@' . $username;

    $endpoint = $this->instance->endpoints->get('web.user-details', [ 'username' => $username ]);
    $nextData = $this->instance->request->call($endpoint)->extract();

    // If there is an error, set the error in the parent, return false.
    if (isset($nextData->error)) return $this->instance->setError($nextData->message);

    $userData = (new \TikTok\Core\Models\User())->fromNextData($nextData);
    return $userData;
  }

  /**
   * Gets videos for a specific user
   */
  public function videos ($id = null, $count = 30) {

    // Validate arguments
    if (!$this->instance->valid($id)) return false;

    $endpoint = $this->instance->endpoints->get('m.user-videos', [ 'id' => $id, 'count' => $count ]);
    $videos = $this->instance->request->call($endpoint)->response();

    // If there is an error, set the error in the parent, return false.
    if (isset($videos->error)) return $this->instance->setError($videos->message);

    return $videos;
  }

  public function video($username = null, $id = null) {

    // Validate arguments
    if (!$this->instance->valid($username, $id)) return false;

    // Check for the @ symbol, format accordingly.
    if (strpos($username, '@') === false) $username = '@' . $username;

    $endpoint = $this->instance->endpoints->get('web.user-video', [ 'username' => $username, 'id' => $id ]);
    $nextData = $this->instance->request->call($endpoint)->extract();

    // If there is an error, set the error in the parent, return false.
    if (isset($nextData->error)) return $this->instance->setError($nextData->message);

    $videoData = (new \TikTok\Core\Models\Video())->fromNextData($nextData);
    return $videoData;
  }
}
