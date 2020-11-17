<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * All Suggested requests
 */
class SuggestedRequests
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
  public function forUser ($user = null) {

    // Set id to user by default.
    $id = $user;

    // Validate arguments
    if (!$this->instance->valid($user)) return false;

    // If passed is a username
    if (!preg_match("/^\d+$/", $user)) {
      $userData = $this->instance->user->details($user);
      if (!$userData) return false;
      $id = $userData->userId;
    }

    $endpoint = $this->instance->endpoints->get('m.suggested', [
      'pageId' => $id,
      'userId' => $id
    ]);

    $response = $this->instance->request->call($endpoint)->response();

    $results = (is_string($response) ? json_decode($response) : $response);

    // If there is an error, set the error in the parent, return false.
    if (isset($results->error)) return $this->instance->setError($results->message);

    if (!isset($results->body)) {
      return $this->instance->setError([
        'error' => true,
        'message' => 'No body found in response'
      ]);
    }

    if (!isset($results->body[0])) {
      return $this->instance->setError([
        'error' => true,
        'message' => 'Body does not have array key 0'
      ]);
    }

    if (!isset($results->body[0]->exploreList)) {
      return $this->instance->setError([
        'error' => true,
        'message' => 'Explore list not found in response'
      ]);
    }

    $list = $results->body[0]->exploreList;
    $users = [];

    foreach ($list as $item) {
      $user = $item->cardItem;

      $users[] = [
        'name' => $user->title,
        'nickname' => str_replace('@', '', $user->subTitle),
        'id' => $user->extraInfo->userId,
        'cover' => $user->cover,
        'verified' => $user->extraInfo->verified,
        'followers' => $user->extraInfo->fans,
        'total_likes' => $user->extraInfo->likes
      ];
    }

    $results = (object) [
      'users' => $users
    ];

    return $results;
  }
}
