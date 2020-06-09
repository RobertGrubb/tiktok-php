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
  public function data($hashtag = null) {
    $endpoint = $this->instance->endpoints->get('web.hashtag-data', [ 'hashtag' => $hashtag ]);
    $nextData = $this->instance->request->call($endpoint)->extract();
    if (isset($nextData->error)) return $nextData;
    $hashtagData = (new \TikTok\Core\Models\Hashtag())->fromNextData($nextData);
    return $hashtagData;
  }
}
