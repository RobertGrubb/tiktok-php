<?php

namespace TikTok;

// Libraries
use TikTok\Core\Libraries\Request;
use TikTok\Core\Libraries\Utilities;

// Endpoints
use TikTok\Core\Resources\Endpoints;

class Scraper
{

  /**
   * Default configuration
   */
  private $config  = null;

  /**
   * Request instance holder
   */
  public $request = null;

  /**
   * Endpoints instance holder
   * @var TikTok\Core\Resources\Endpoints
   */
  public $endpoints = null;

  /**
   * Error information
   */
  public $error = false;

  /**
   * Class constructor
   */
  public function __construct($config = null) {

    // Finds the bin path
    Utilities::findBin();

    /**
     * Set the initial configuration variables.
     */
    $this->_setInitial($config);

    // Sets up the request classes
    $this->_initialize();
  }

  /**
   * Initializes required classes for the scraper
   */
  private function _initialize() {

    /**
     * Instantiate the request instance.
     */
    $this->endpoints = new Endpoints($this->config);

    /**
     * Instantiate the request instance.
     */
    $this->request = new Request($this->config, $this->endpoints);

    /**
     * Instantiate the user requests class
     */
    $this->user = new \TikTok\Requests\UserRequests($this);

    /**
     * Instantiate the discover requests class
     */
    $this->discover = new \TikTok\Requests\DiscoverRequests($this);

    /**
     * Instantiate the trending requests class
     */
    $this->trending = new \TikTok\Requests\TrendingRequests($this);

    /**
     * Instantiate the hashtag requests class
     */
    $this->hashtag = new \TikTok\Requests\HashtagRequests($this);
  }


  /**
   * Gives ability to simply sign a url.
   */
  public function signUrl ($url) {
    $userAgent = isset($this->config->userAgent) ? $this->config->userAgent : $this->endpoints->defaultUserAgent;
    $signature = [];

    if ($this->config->signMethod === 'datafetch') {

      // Sign the url with DataFetch
      $signature = \TikTok\Core\Libraries\DataFetch::sign(
        $url,
        $userAgent,
        $this->config->datafetchApiKey
      );
    } else {

      // Sign the url with node
      $signature = \TikTok\Core\Libraries\Signer::execute(
        $url,
        $userAgent
      );
    }

    return $signature;
  }

  /**
   * Get a configuration variable from the
   * class configuration.
   */
  private function _get ($var) {
    if (isset($this->config->{$var})) return $var;
    return false;
  }

  /**
   * Sets the default class configuration
   */
  private function _setInitial ($config) {
    $this->config = (object) [];

    $this->config->signMethod = 'node';
    $this->config->datafetchApiKey = null;

    if (!is_null($config)) {
      if (!is_array($config)) return false;

      foreach ($config as $key => $val) {
        $this->set($key, $val);
      }
    }

    return $this;
  }

  /**
   * Set the class configuration variable.
   */
  public function set ($var, $val) {
    $this->config->{$var} = $val;

    // Re initialize
    $this->_initialize();
  }

  // Set an error
  public function setError ($error) {
    $this->error = $error;
  }

}
