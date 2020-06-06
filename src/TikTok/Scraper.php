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

    // Finds and sets the vendor bin path
    $this->_setVendorBinpath();

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
    $this->request = new Request($this->config);

    // Instantiate the account request methods
    $this->user = new \TikTok\Requests\UserRequests($this, $this->request);
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

  // Set an error
  public function setError ($error) {
    $this->error = $error;
  }

  /**
   * Attempts to find the vendor bin path
   * so node can be executed.
   */
  private function _setVendorBinPath () {
    if (is_dir(__DIR__ . '/../../vendor/bin/'))
      defined('VENDOR_BIN_PATH') || define('VENDOR_BIN_PATH', __DIR__ . '/../../vendor/bin/');
    elseif (is_dir(__DIR__ . '/../../../../vendor/bin/'))
      defined('VENDOR_BIN_PATH') || define('VENDOR_BIN_PATH', __DIR__ . '/../../../../vendor/bin/');
    else
      throw new TikTokException('Vendor bin path not found.');
  }

}
