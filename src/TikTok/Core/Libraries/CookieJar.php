<?php

namespace TikTok\Core\Libraries;

/**
 * Responsible for Cookie handling.
 */
class CookieJar {

  /**
   * Instance configuration object
   */
  private $config = false;

  /**
   * Class constructor
   */
  public function __construct ($config = null) {

    // Set config by default
    $this->config = (object) [];

    // If config is passed, set the class config object.
    if (!is_null($config)) $this->config = $config;

    // Are cookies disabled?
    if (isset($this->config->disableCookies))
      if ($this->config->disableCookies === true) return;

    // Make sure the cookie file is set.
    if (!isset($this->config->cookieFile))
      throw new \Exception('No cookie file provided in config. Please set `cookieFile` (See documentation).');

    // Make sure cookie file is readable.
    if (isset($this->config->cookieFile))
      if (!$this->isReadable()) throw new \Exception('Unable to read cookie file.');
  }

  /**
   * Responsible for getting the contents of the cookie
   * file.
   * @return ArrayObject
   */
  public function contents () {
    if ($this->isReadable()) {
      try {
        $contents = file_get_contents($this->config->cookieFile);

        if (empty($contents)) return false;

        $data = json_decode($contents);
        return $data;
      } catch (\Exception $e) {
        throw new \Exception($e->getMessage());
      }
    }

    return false;
  }

  public function getCookieValue ($cookie) {
    $contents = $this->contents();

    if (!$contents) return false;

    if (!is_array($contents)) return false;

    $response = false;

    foreach ($contents as $c) {
      if (strpos($cookie, $c) !== -1) {
        $parts = explode(';', $c);
        $val = explode('=', $parts[0])[1];
        $response = $val;
      }
    }

    return $response;
  }

  /**
   * Responsible for writing to the cookie file.
   * @param  array $data
   * @return boolean
   */
  public function write ($data) {
    if ($this->isWritable()) {
      try {
        $formattedData = json_encode($data);
        file_put_contents($this->config->cookieFile, $formattedData);
        return true;
      } catch (\Exception $e) {
        return false;
      }
    }

    return false;
  }

  private function delete () {
    if ($this->isWritable()) file_put_contents($this->config->cookieFile, '');
    return false;
  }

  /**
   * Check if the cookie file exists
   * @return boolean
   */
  private function exists () {
    if (!isset($this->config->cookieFile)) return false;
    if (file_exists($this->config->cookieFile)) return true;
    return false;
  }

  /**
   * Check if the cookie file is readable
   * @return boolean
   */
  private function isReadable () {
    if (!$this->exists()) return false;
    if (is_readable($this->config->cookieFile)) return true;
    return false;
  }

  /**
   * Check if the cookie file is writable.
   * @return boolean
   */
  private function isWritable () {
    if (!$this->exists()) return false;
    if (is_writable($this->config->cookieFile)) return true;
    return false;
  }

}
