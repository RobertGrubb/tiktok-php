<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * Music related methods
 */
class MusicRequests
{

  // Parent instance holder
  private $instance = null;

  /**
   * Class constructor
   */
  public function __construct ($instance) {
    $this->instance  = $instance;
  }

  /**
   * @TODO: Finish this method.
   *
   * Right now it seems the URL is not being signed correctly.
   * Need to look into why this is.
   */
  public function data ($id) {

    // Set a custom user agent
    $customUserAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1';

    // Get the endpoint with the custom user agent.
    $endpoint = $this->instance->endpoints->get('m.music-data', [ 'musicId' => $id ], $customUserAgent);

    // Get the music data, set the user agent to the custom one.
    $musicData = $this->instance->request->call($endpoint, [
      'User-Agent' => $customUserAgent
    ])->response();

    // If there is an error, set the error in the parent, return false.
    if (isset($musicData->error)) return $this->instance->setError($musicData->message);

    return $musicData;
  }

  /**
   * Gets trending videos
   */
  public function videos ($id, $count = 25) {
    $endpoint = $this->instance->endpoints->get('m.music-videos', [ 'id' => $id, 'count' => $count ]);
    $musicVideos = $this->instance->request->call($endpoint)->response();

    // If there is an error, set the error in the parent, return false.
    if (isset($musicVideos->error)) return $this->instance->setError($musicVideos->message);

    return $musicVideos;
  }
}
