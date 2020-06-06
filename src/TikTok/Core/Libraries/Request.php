<?php

namespace TikTok\Core\Libraries;

use TikTok\Core\Exceptions\TikTokException;


class Request {

  public $config;

  public function __construct ($config) {
    $this->config = $config;
  }

  public function call ($endpoint, $customHeaders = []) {

	  // Initiate CURL
	  $ch = curl_init();

    $timeout = isset($this->config->timeout) ? $this->config->timeout : 30;

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

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
    curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->apiHeaders, $customHeaders));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Get the response
    $response = curl_exec($ch);

    // Curl info
    $info = curl_getinfo($ch);

    // Close CURL
    curl_close ($ch);

    if ($info['http_code'] !== 200) {
      try {
        $response = json_decode($response);
        $response->code = $info['http_code'];
        return $response;
      } catch (Exception $e) {
        throw new TikTokException("Code " . $info['http_code'] . " returned");
      }
    }

    try {
      $response = json_decode($response);
    } catch (Exception $e) {
      return false;
    }

    return $response;
	}

}
