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
    'User-Agent'      => '',
    'Accept-Language' => 'en-US,en;q=0.9',
    'Referer'         => 'https://www.tiktok.com/discover?lang=en',
    'Origin'          => 'https://www.tiktok.com'
  ];

  /**
   * URLS for captcha
   */
  public $urls = [
    'verify' => 'https://verification-va.byteoversea.com/captcha/verify?',
    'get'    => 'https://verification-va.byteoversea.com/captcha/get?'
  ];

  /**
   * URI parameters sent via the url when making
   * captcha requests.
   */
  public $params = [
    'lang'           => 'en',
    'app_name'       => 'tiktok',
    'h5_sdk_version' => '2.15.17',
    'sdk_version'    => '',
    'iid'            => 0,
    'did'            => 0,
    'device_id'      => 0,
    'ch'             => 'web_text',
    'aid'            => 1284,
    'os_type'        => 2,
    'tmp'            => '',
    'platform'       => 'pc',
    'subtype'        => 'slide',
    'challenge_code' => 1105,
    'webdriver'      => 'undefined',
    'os_name'        => 'mac'
  ];

  // Captcha data returned will be stored here.
  public $captchaData = false;

  private $fp = '';

  private $instance;

  private $response = [
    'modified_img_width' => 336,
    'id' => null,
    'mode' => 'slide',
    'reply' => [],
    'models' => [
      'x' => [],
      'y' => [],
      'z' => [],
      't' => [],
      'm' => []
    ]
  ];

  public $startTime = null;


  public function __construct ($instance) {

    $this->instance  = $instance;

    // Set the tmp parameter with a timestamp * 10000
    $this->params['tmp'] = (time() * 1000) + 120;

    $this->headers['User-Agent'] = $this->instance->endpoints->headers['m']['User-Agent'];
  }

  public function setFp() {
    if (!$this->instance->request->savedCookies())
       throw new \Exception('No cookies found.');

    $fp = $this->instance->request->cookieJar->getCookieValue('s_v_web_id');

    if (!$fp) throw new \Exception('No s_v_web_id cookie found.');

    $this->fp = $fp;

    return $this;
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

    $this->startTime = (time() * 1000);

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

    if (!isset($this->captchaData['data'])) return false;

    // Setup the params to be passed to _call
    $params = array_merge($this->params, [
      'fp' => $this->fp
    ]);

    // Set a timestamp
    $now = time();

    // Setup the vars object
    $vars = $this->response;

    $vars['id'] = $this->captchaData['data']->id;

    $startTime = $this->startTime;

    $lastTime = $startTime;

    $vars['models']['x']['time'] = $startTime;
    $vars['models']['x']['y'] = 171;
    $vars['models']['x']['x'] = 17;

    for ($i = 0; $i <= 48; $i++) {
      $lastTime = ($lastTime + rand(5, 10));

      $vars['reply'][$i] = [
        'x' => ($i * 1.35),
        'y' => 79,
        'relative_time' => $lastTime
      ];

      $vars['models']['m'][$i] = [
        'x' => ($i * 1.35),
        'y' => 183,
        'time' => $lastTime
      ];

      $vars['models']['z'][$i] = [
        'x' => ($i * 1.35),
        'y' => 183,
        'time' => $lastTime
      ];
    }

    // Convert the vars data to a json formatted string, and add it to the array.
    $vars['log_params'] = json_encode(array_merge($this->params, [
      'drag_type' => 'img',
      'challenge_id' => $vars['id'],

      'moveArray' => addslashes(json_encode($vars['models']))
    ]), JSON_PRETTY_PRINT);

    print_r($vars);

    // Call the verification endpoint.
    return $this->_call($this->urls['verify'], $params, 'post', $vars);
  }

  private function _call ($url = false, $params = [], $method = 'post', $vars = []) {
    if (!$url) return false;

    $url .= http_build_query($params);

    print_r($this->formatHeaders($this->headers));

    var_dump($url);

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
