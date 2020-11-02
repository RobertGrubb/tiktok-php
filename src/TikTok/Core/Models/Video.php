<?php

namespace TikTok\Core\Models;

class Video
{

  /**
   * Convert from next data array
   */
  public function fromNextData ($NEXT_DATA, $requestInfo = false) {
    $instance = new self();

    // Validate the response data
    if (count($NEXT_DATA) === 0)  return $this->error('__NEXT_DATA__');
    if (!isset($NEXT_DATA['props'])) return $this->error('__NEXT_DATA__[props]');
    if (!isset($NEXT_DATA['props']['pageProps'])) return $this->error('__NEXT_DATA__[props][pageProps]');
    if (!isset($NEXT_DATA['props']['pageProps']['itemInfo'])) return $this->error('__NEXT_DATA__[props][pageProps][itemInfo]');
    if (!isset($NEXT_DATA['props']['pageProps']['itemInfo']['itemStruct'])) return $this->error('__NEXT_DATA__[props][pageProps][itemInfo][itemStruct]');

    // Set videoData
    $videoData = json_decode(json_encode($NEXT_DATA['props']['pageProps']['itemInfo']['itemStruct']));

    // set all keys from userData to the instance.
    foreach ($videoData as $key => $val) $instance->{$key} = $val;


    if (is_array($requestInfo)) {
      if (isset($requestInfo['userAgent']) && isset($requestInfo['cookies'])) {
        $instance->videoDownloadData = (object) [
          'referer' => 'https://www.tiktok.com/',
          'userAgent' => $requestInfo['userAgent'],
          'cookies' => $requestInfo['cookies']
        ];
      }
    }

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
