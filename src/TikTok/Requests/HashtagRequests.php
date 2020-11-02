<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * All hashtag requests
 */
class HashtagRequests
{

  // setError function from parent.
  private $instance = null;

  /**
   * Class constructor
   */
  public function __construct ($instance) {
    $this->instance  = $instance;
  }

  /**
   * Retrieves data for a specific hashtag.
   * @param string $hashtag
   */
  public function data ($hashtag = null) {

    // Validate arguments
    if (!$this->instance->valid($hashtag)) return false;

    $endpoint = $this->instance->endpoints->get('web.hashtag-data', [ 'hashtag' => $hashtag ]);
    $nextData = $this->instance->request->call($endpoint)->extract();

    // If there is an error, set the error in the parent, return false.
    if (isset($nextData->error)) return $this->instance->setError($nextData->message);

    $hashtagData = (new \TikTok\Core\Models\Hashtag())->fromNextData($nextData);
    return $hashtagData;
  }

  /**
   * Retrieve videos for a hashtag.
   * @param  string  $hashtag
   * @param  integer $count
   */
  public function videos ($hashtag = null, $count = 30) {

    // Validate arguments
    if (!$this->instance->valid($hashtag)) return false;

    // Get hashtag data for the challengeId
    $hashtagData = $this->data($hashtag);

    // If hashtagData returned false, quit here.
    if (!$hashtagData) return false;

    // Get the videos by challengeId
    $endpoint = $this->instance->endpoints->get('m.trending', [
      'id' => $hashtagData->id,
      'count' => $count
    ]);

    // Retrieve the videos.
    $videos = $this->instance->request->call($endpoint)->response();

    // If there is an error, set the error in the parent, return false.
    if (isset($videos->error)) return $this->instance->setError($videos->message);

    $videos->videoDownloadData = [
      'userAgent' => $this->instance->endpoints->headers['m']['User-Agent'],
      'cookies' => [
        'tt_webid' => $this->instance->request->cookieJar->getCookieValue('tt_webid'),
        'tt_webid_v2' => $this->instance->request->cookieJar->getCookieValue('tt_webid_v2')
      ]
    ];

    // Return the videos response
    return $videos;
  }

}
