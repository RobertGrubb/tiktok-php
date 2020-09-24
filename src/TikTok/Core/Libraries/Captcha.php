<?php

namespace TikTok\Core\Libraries;

/**
 * Handles the ability to solve captcha
 * checkpoints for TikTok.
 *
 * @TODO: Finish the solve part for both 3d and slide.
 * @TODO: Enable proxy for same-origin requests.
 */
class Captcha {

  /**
   * Headers required for the request to tiktok for
   * captcha requests.
   */
  private $headers = [
    'Authority'       => 'www.tiktok.com',
    'Upgrade-Insecure-Requests' => '1',
    'User-Agent'      => '',
    'Sec-Fetch-Dest'  => 'document',
    'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
    'Sec-Fetch-Site'  => 'none',
    'Sec-Fetch-Mode'  => 'navigate',
    'Sec-Fetch-User'  => '?1',
    'Accept-Language' => 'en-US,en;q=0.9',
    'Referer'         => 'https://www.tiktok.com/'
  ];

  /**
   * URLS for captcha
   */
  public $urls = [
    'verify' => 'https://www.tiktok.com/captcha/verify?',
    'get'    => 'https://www.tiktok.com/captcha/get?'
  ];

  /**
   * URI parameters sent via the url when making
   * captcha requests.
   */
  public $params = [
    'lang'           => 'en',
    'app_name'       => 'Tik_Tok_Login',
    'h5_sdk_version' => '2.15.0',
    'sdk_version'    => '',
    'iid'            => 0,
    'did'            => 0,
    'device_id'      => 0,
    'ch'             => 'web_text',
    'aid'            => 1459,
    'os_type'        => 2,
    'tmp'            => '',
    'platform'       => 'pc',
    'subtype'        => '3d',
    'challenge_code' => 1105,
    'webdriver'      => 'undefined',
    'os_name'        => 'mac'
  ];

  // Captcha data returned will be stored here.
  public $captchaData = false;

  private $fp = '';

  public function __construct ($fp = '') {

    // Set the tmp parameter with a timestamp * 10000
    $this->params['tmp'] = (time() * 1000) + 120;

    $this->fp = $fp;
  }

  public function get () {

    // Merge the parameters with the following
    $params = $this->params;

    $params['fp'] = $this->fp;

    // Make the requests
    $data = $this->_call($this->urls['get'], $params, 'get');

    // Validate that the data did return something.
    if ($data === false) return false;

    // Set the captcha data.
    $this->captchaData = $data;

    // Return the captcha data (todo, return instance.)
    return $this;
  }

  /**
   * Should solve the captcha that was received during the get
   * method. The captcha data is stored in this class, and
   * then accessed in this method.
   *
   * @TODO: Continue working on solving of captcha.
   */
  public function solve () {

    // Setup the params to be passed to _call
    $params = array_merge($this->params, [
      'fp' => $this->fp,
      'subtype' => $this->captchaData->data->mode,
      'challenge_code' => $this->captchaData->data->challenge_code,
    ]);

    // Set a timestamp
    $now = time();

    // Setup the vars object
    $vars = [
      'id' => $this->captchaData->data->id,
      'mode' => $this->captchaData->data->mode,
      'models' => [], // Todo: Get info
      'modified_img_width' => 336,
      'reply' => [] // Todo: Get info
    ];

    // Convert the vars data to a json formatted string, and add it to the array.
    $vars['log_params'] = json_encode($vars);

    // Call the verification endpoint.
    return $this->_call($this->urls['verify'], $params, 'post', $vars);
  }

  private function _call ($url = false, $params = [], $method = 'post', $vars = []) {
    if (!$url) return false;

    $url .= http_build_query($params);

    echo $url;

    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);

    if ($method === 'post') {
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vars));
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($this->headers));

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

  /**
   * Formats the headers for CURL
   */
  private function formatHeaders ($headers = array()) {
    $res = [];
    foreach ($headers as $key => $header) $res[] = $key . ': ' . $header;
    return $res;
  }

}
