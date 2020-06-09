<?php

namespace TikTok\Core\Libraries;

/**
 * Handles communcation to TikTok.
 */
class Request {

  /**
   * Scraper configuration
   * @var object
   */
  public $config;

  /**
   * Data response variable
   * @var object
   */
  public $data = false;

  /**
   * Endpoint instance holder
   * @var TikTok\Core\Resources\Endpoints
   */
  private $endpoints = false;

  /**
   * Class construction
   */
  public function __construct ($config, $endpoints) {

    // Set the config
    $this->config = $config;

    // Set the endpoints instance
    $this->endpoints = $endpoints;
  }

  public function call ($endpoint, $customHeaders = []) {

    // Grab headers that will be used based on endpoint
    $headers = $this->getHeaders($endpoint);

	  // Initiate CURL
	  $ch = curl_init();

    // Set the timeout
    $timeout = isset($this->config->timeout) ? $this->config->timeout : 30;

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $endpoint);

    // Timeout
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

    // Proxy setup:
    if (isset($this->config->proxy)) {

      // Make sure address is set.
      if (isset($this->config->proxy['address'])) {

        // Check for protocol setting
        if (isset($this->config->proxy['protocol'])) {

          // Auth should be: username:password
          curl_setopt(
            $ch,
            CURLOPT_PROXYTYPE,
            (
              $this->config->proxy['protocol'] === 'https' ?
              CURLPROXY_HTTPS :
              CURLPROXY_HTTP
            )
          );
        } else {
          curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        }

        // Address should be 0.0.0.0:0000
        curl_setopt($ch, CURLOPT_PROXY, $this->config->proxy['address']);

        // Check if auth is provided
        if (isset($this->config->proxy['auth'])) {

          // Auth should be: username:password
          curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->config->proxy['auth']);
        }
      }
    }

    // Set other headers
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    // Merge any custom headers with the fetched headers from Endpoints
    curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, $customHeaders));

    // Get the response
    $response = curl_exec($ch);

    // Curl info
    $info = curl_getinfo($ch);

    print_r([
      'info' => $info,
      'headers' => $headers,
      'endpoint' => $endpoint
    ]);

    // Close CURL
    curl_close ($ch);

    /**
     * If the http code is not 200, return an errror with a
     * message.
     */
    if ($info['http_code'] !== 200) {
      $this->data = (object) [
        'error' => true,
        'message' => 'Status code ' . $info['http_code'] . ' was returned'
      ];

      return $this;
    }

    /**
     * If the response is empty, return an error.
     */
    if (empty($response)) {
      $this->data = (object) [
        'error' => true,
        'message' => 'Empty response'
      ];
    }

    /**
     * If this is a m.tiktok.com endpoint, attempt to
     * decode the json response.
     */
    if ($this->endpointType($endpoint) === 'm') {
      try {
        $response = json_decode($response);
      } catch (Exception $e) {

        $this->data = (object) [
          'error' => true,
          'message' => 'Unable to decode JSON data'
        ];

        return $this;
      }
    }

    // Set the class data variable, and return the instance for chaining.
    $this->data = $response;
    return $this;
	}

  /**
   * Simply returns the data variable.
   */
  public function response () {
    return $this->data;
  }

  /**
   * For web endpoints only:
   *
   * Extract the NEXT_DATA variable from the DOM.
   */
  public function extract () {

    // If is an object, it's most likely an error.
    if (is_object($this->data)) return $this->data;

    // Attempt to pick NEXT_DATA from DOM
    if (preg_match_all('#\<script id=\"__NEXT_DATA__\" type=\"application/json\" crossorigin=\"anonymous\">(.*?)\<\/script\>#', $this->data, $out)) {
      return json_decode($out[1][0], true, 512, JSON_BIGINT_AS_STRING);
    }

    return (object) [
      'error' => true,
      'message' => 'Unable to retrieve NEXT_DATA from DOM'
    ];
  }

  private function endpointType ($endpoint) {
    if (strpos($endpoint, 'www.') !== false) return 'web';
    return 'm';
  }

  /**
   * Gets headers for the specific endpoint platform.
   */
  private function getHeaders($endpoint) {

    return $this->formatHeaders(
      $this->endpoints->headers[$this->endpointType($endpoint)]
    );
  }

  /**
   * Formats the headers for CURL
   */
  private function formatHeaders($headers = array()) {
    $res = [];
    foreach ($headers as $key => $header) $res[] = $key . ': ' . $header;
    return $res;
  }
}
