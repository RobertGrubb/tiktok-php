<?php

namespace TikTok\Core\Models;

class User
{

  /**
   * Convert from next data array
   */
  public function fromNextData ($NEXT_DATA) {
    $instance = new self();

    // Validate the response data
    if (count($NEXT_DATA) === 0) return $this->error('__NEXT_DATA__');
    if (!isset($NEXT_DATA['props'])) return $this->error('__NEXT_DATA__[props]');
    if (!isset($NEXT_DATA['props']['pageProps'])) return $this->error('No __NEXT_DATA__[props][pageProps]');

    // If this property is missing, the user does not exist.
    if (!isset($NEXT_DATA['props']['pageProps']['userInfo'])) return $this->error('User does not exist', true);

    // Set Userdata
    $userData = json_decode(json_encode($NEXT_DATA['props']['pageProps']['userInfo']));

    // set all keys from userData to the instance.
    foreach ($userData as $key => $val) $instance->{$key} = $val;

    // Backwards compatible
    $instance->userId = $userData->user->id;
    $instance->covers = [ $userData->user->avatarThumb ];
    $instance->coversMedium = [ $userData->user->avatarMedium ];
    $instance->nickName = $userData->user->nickname;
    $instance->following = $userData->stats->followingCount;
    $instance->fans = $userData->stats->followerCount;
    $instance->heart = $userData->stats->heartCount;
    $instance->video = $userData->stats->videoCount;
    $instance->verified = $userData->user->verified;
    $instance->digg = $userData->stats->diggCount;
    $instance->signature = $userData->user->signature;
    $instance->secUid = $userData->user->secUid;
    $instance->uniqueId = $userData->user->uniqueId;
    $instance->bioLink = false;

    if (isset($userData->user->bioLink)) {
      if (isset($userData->user->bioLink->link)) {
        $instance->bioLink = $userData->user->bioLink->link;
      }
    }

    return $instance;
  }

  /**
   * Returns an error instead of throwing an
   * exception.
   */
  public function error ($field, $customMessage = false) {
    return (object) [
      'error' => true,
      'message' => ($customMessage ? $field : 'Object: ' . $field . ' not found')
    ];
  }
}
