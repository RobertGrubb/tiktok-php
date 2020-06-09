<?php

namespace TikTok\Core\Models;

class Video
{

  /**
   * Convert from next data array
   */
  public function fromNextData ($NEXT_DATA) {
    $instance = new self();

    // Validate the response data
    if (count($NEXT_DATA) === 0)  throw new Exception('No __NEXT_DATA__ found.');
    if (!isset($NEXT_DATA['props'])) throw new Exception('No __NEXT_DATA__[props] found.');
    if (!isset($NEXT_DATA['props']['pageProps'])) throw new Exception('No __NEXT_DATA__[props][pageProps] found.');
    if (!isset($NEXT_DATA['props']['pageProps']['videoData'])) throw new Exception('No __NEXT_DATA__[props][pageProps][videoData] found.');

    // Set videoData
    $videoData = json_decode(json_encode($NEXT_DATA['props']['pageProps']['videoData']));

    // set all keys from userData to the instance.
    foreach ($videoData as $key => $val) $instance->{$key} = $val;

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
