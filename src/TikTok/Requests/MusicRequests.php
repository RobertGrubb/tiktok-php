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
   * Will query a list of videos for the music,
   * then it will take the first result, grab the music data,
   * format the url slug, then access the /music/slug page and
   * grab the data from NEXT_DATA.
   */
  public function data ($id) {

    // Get the video list
    $videoList = $this->videos($id, 1);

    // If nothing is returned
    if (!$videoList) return false;

    // Validations for the video list
    if (!isset($videoList->items)) return false;
    if (!isset($videoList->items[0])) return false;

    // Get the music data
    $musicDataFromVideo = $videoList->items[0]->music;

    // Get the music slug
    $musicUrlSlug = $this->formatMusicUrl($musicDataFromVideo);

    // Build the endpoint and extract the nextData
    $endpoint = $this->instance->endpoints->get('web.music-data', [ 'slug' => $musicUrlSlug ]);
    $nextData = $this->instance->request->call($endpoint)->extract();

    // If there is an error, set the error in the parent, return false.
    if (isset($nextData->error)) return $this->instance->setError($nextData->message);

    // Run next_data through the model and return the musicData
    $musicData = (new \TikTok\Core\Models\Music())->fromNextData($nextData);
    return $musicData;
  }

  public function download ($id, $path = './', $customName = false) {

    // Validate arguments
    if (!$this->instance->valid($id)) return false;

    // Get the video data
    $musicData = $this->data($id);

    // If no video data is returned, return false.
    if (!$musicData) return false;

    // Get the URL
    $uri = $musicData->playUrl->Uri;

    // Download the music mp3
    return \TikTok\Core\Libraries\Downloader::music($uri, $path, $customName);
  }

  /**
   * Gets trending videos
   */
  public function videos ($id, $count = 25) {
    $endpoint = $this->instance->endpoints->get('m.music-videos', [ 'musicID' => $id, 'count' => $count ]);
    $musicVideos = $this->instance->request->call($endpoint)->response();

    // If there is an error, set the error in the parent, return false.
    if (isset($musicVideos->error)) return $this->instance->setError($musicVideos->message);

    return $musicVideos;
  }

  private function formatMusicUrl ($music) {
    $title = str_replace(' ', '-', $music->title);
    $slug = $title . '-' . $music->id;
    return $slug;
  }
}
