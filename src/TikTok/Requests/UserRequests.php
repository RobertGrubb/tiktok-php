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
    if (strpos($username, '@') !== false) $username = ltrim($username, '@');

    $endpoint = $this->instance->endpoints->get('web.user-details', [ 'username' => $username ]);
    $nextData = $this->instance->request->call($endpoint)->extract();

    // If there is an error, set the error in the parent, return false.
    if (isset($nextData->error)) return $this->instance->setError($nextData->message);

    $userData = (new \TikTok\Core\Models\User())->fromNextData($nextData);
    return $userData;
  }

  public function search ($keyword = null, $count = 30) {

    // Validate arguments
    if (!$this->instance->valid($keyword)) return false;

    $endpoint = $this->instance->endpoints->get('m.discover-user', [
      'discoverType' => 1,
      'keyWord' => $keyword,
      'count' => $count
    ]);

    $results = $this->instance->request->call($endpoint)->response();

    // If there is an error, set the error in the parent, return false.
    if (isset($results->error)) return $this->instance->setError($results->message);

    return $results;
  }

  /**
   * Gets videos for a specific user
   */
  public function videos ($user = null, $count = 30) {
    // Set id to user by default.
    $id = $user;

    // Validate arguments
    if (!$this->instance->valid($user)) return false;

    // If passed is a username
    if (!preg_match("/^\d+$/", $user)) {
      $userData = $this->details($user);
      if (!$userData) return false;
      $id = $userData->userId;
    }

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
    if (strpos($username, '@') !== false) $username = ltrim($username, '@');

    $endpoint = $this->instance->endpoints->get('web.user-video', [ 'username' => $username, 'id' => $id ]);
    $nextData = $this->instance->request->call($endpoint)->extract();

    // If there is an error, set the error in the parent, return false.
    if (isset($nextData->error)) return $this->instance->setError($nextData->message);

    $videoData = (new \TikTok\Core\Models\Video())->fromNextData($nextData);
    return $videoData;
  }

  public function downloadVideo ($username = null, $id = null, $path = './') {

    // Validate arguments
    if (!$this->instance->valid($username, $id)) return false;

    // Get the video data
    $videoData = $this->video($username, $id);

    // If no video data is returned, return false.
    if (!$videoData) return false;

    // Get the URL
    $url = $videoData->itemInfos->video->urls[0];

    // Download the video
    return \TikTok\Core\Libraries\Downloader::video($url, $path);
  }
}
