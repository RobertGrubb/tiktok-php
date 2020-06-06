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
    if (!isset($NEXT_DATA['props']['pageProps']['userData'])) return $this->error('No __NEXT_DATA__[props][pageProps][userData]');

    // Set Userdata
    $userData = $NEXT_DATA['props']['pageProps']['userData'];

    foreach ($userData as $key => $val) $instance->{$key} = $val;

    return $instance;
  }

  /**
   * Returns an error instead of throwing an
   * exception.
   */
  public function error ($field) {
    return (object) [
      'error' => true,
      'message' => 'Object: ' . $field . ' not found'
    ];
  }
}
