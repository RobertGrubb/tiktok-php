<?php

namespace TikTok\Core\Models;

class Music
{

  /**
   * Convert from next data array
   */
  public function fromNextData ($NEXT_DATA) {
    $instance = new self();

    // Validate the response data
    if (count($NEXT_DATA) === 0)  return $this->error('__NEXT_DATA__');
    if (!isset($NEXT_DATA['props'])) return $this->error('__NEXT_DATA__[props]');
    if (!isset($NEXT_DATA['props']['pageProps'])) return $this->error('__NEXT_DATA__[props][pageProps]');
    if (!isset($NEXT_DATA['props']['pageProps']['musicData'])) return $this->error('__NEXT_DATA__[props][pageProps][musicData]');

    // Set videoData
    $musicData = json_decode(json_encode($NEXT_DATA['props']['pageProps']['musicData']));

    // set all keys from userData to the instance.
    foreach ($musicData as $key => $val) $instance->{$key} = $val;

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
