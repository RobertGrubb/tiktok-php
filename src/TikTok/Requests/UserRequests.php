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

  public function allVideos ($user = null) {

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

    // Get first set of videos.
    $data = $this->videos($user, 30);

    // If no data is returned, return false.
    if (!$data) return false;

    // Store videos in an array.
    $videos = [];

    /**
     * Do a while loop, and while hasMore is true,
     * we will continue calling the videos with maxCursor
     */
    while ($data->hasMore === true) {

      // Add video to the videos array.
      foreach ($data->items as $vid) $videos[] = $vid;

      // Call it with a new maxCursor
      $data = $this->videos($user, 10, [
        'maxCursor' => $data->maxCursor
      ]);
    }

    return $videos;
  }

  /**
   * Gets videos for a specific user
   */
  public function videos ($user = null, $count = 30, $vars = []) {
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

    $endpoint = $this->instance->endpoints->get('m.user-videos', array_merge($vars, [ 'id' => $id, 'count' => $count ]));
    $videos = $this->instance->request->call($endpoint)->response();

    // If there is an error, set the error in the parent, return false.
    if (isset($videos->error)) return $this->instance->setError($videos->message);

    return $videos;
  }

  public function video ($username = null, $id = null) {

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

  public function downloadVideo ($username = null, $id = null, $watermark = true, $path = './') {

    // Validate arguments
    if (!$this->instance->valid($username, $id)) return false;

    // Get the video data
    $videoData = $this->video($username, $id);

    // If no video data is returned, return false.
    if (!$videoData) return false;

    // Get the URL
    $url = $videoData->itemInfos->video->urls[0];

    // Get the URL
    if ($watermark === false) $url = \TikTok\Core\Libraries\Downloader::getUrlWithoutWatermark($url);

    // Download the video
    return \TikTok\Core\Libraries\Downloader::video($url, $path);
  }
}
