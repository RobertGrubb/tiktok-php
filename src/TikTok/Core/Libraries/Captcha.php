<?php

namespace TikTok\Core\Libraries;

/**
 * Handles the ability to solve captcha
 * checkpoints for TikTok.
 *
 * @TODO: Finish the solve part for both 3d and slide.
 */
class Captcha {

  private $baseUrl = 'https://www.tiktok.com/captcha/verify?';

  private $params = [
    'lang' => 'en',
    'app_name' => 'Tik_Tok_Login',
    'h5_sdk_version' => '2.15.0',
    'sdk_version' => '',
    'iid' => 0,
    'did' => 0,
    'device_id' => 0,
    'ch' => 'web_text',
    'aid' => 1459,
    'os_type' => 2,
    'tmp' => (time() * 1000),
    'platform' => 'pc',
    'webdriver' => 'undefined',
    'fp' => false,
    'subtype' => false,
    'challenge_code' => false,
    'os_name' => 'mac'
  ];

  public function set ($data = []) {
    if (!isset($data['fp']) || !isset($data['subtype']) || !isset($data['challenge_code']))
      throw new \Exception('Required data for challenge not provided.');

    $this->params['fp'] = $data['fp'];
    $this->params['subtype'] = $data['subtype'];
    $this->params['challenge_code'] = $data['challenge_code'];

    return $this;
  }

  public function solve () {

    return $this->_call([
      'id' => '',
      'log_params' => json_encode($this->params),
      'mode' => $this->params['subtype'],
      'models' => '', // Todo: Get this info
      'modified_img_width' => '', // Todo: Get this info
      'reply' => '' // Todo: Get this info
    ])
  }

  private function _call ($vars = []) {
    $url = $this->baseUrl;

    $url .= http_build_query($this->params);

    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vars));

    curl_setopt( $ch, CURLOPT_HTTPHEADER, [
      "Referer: https://www.tiktok.com/",
      "User-Agent: okhttp"
    ]);

    // receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Get the response
    $response = curl_exec($ch);

    // Close CURL
    curl_close ($ch);

    // Decode the response
    $response = json_decode($response);

    return (array) $response;
  }

}
