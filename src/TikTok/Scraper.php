<?php

namespace TikTok;

use TikTok\Core\Libraries\Request;

use TikTok\Core\Exceptions\TikTokException;

class Scraper
{

  /**
   * Default configuration
   */
  private $config  = null;

  /**
   * Request instance holder
   */
  private $request = null;

  /**
   * Error information
   */
  public $error = false;

  /**
   * Class constructor
   */
  public function __construct($config = null) {

    /**
     * Set the initial configuration variables.
     */
    $this->_setInitial($config);

    /**
     * Initialize the requests
     */
    $this->_initialize();
  }

  /**
   * Initializes required classes for the scraper
   */
  private function _initialize() {

    /**
     * Instantiate the request instance.
     */
    $this->request = new Request($this->config);

    // Instantiate the account request methods
    $this->account = new \TikTok\Requests\AccountRequests($this, $this->request);
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

  public function setError ($error) {
    $this->error = $error;
  }

}
