<?php

namespace TikTok\Core\Libraries;

use TikTok\Core\Exceptions\TikTokException;

class Utilities {

  /**
   * Finds the composer vendor bin path
   * so node can be called.
   */
  public static function findBin () {

    // The dev location
    if (is_dir(__DIR__ . '/../../../../vendor/bin/'))
      defined('VENDOR_BIN_PATH') || define('VENDOR_BIN_PATH', __DIR__ . '/../../../../vendor/bin/');

    // The package location
    elseif (is_dir(__DIR__ . '/../../../../../../bin/'))
      defined('VENDOR_BIN_PATH') || define('VENDOR_BIN_PATH', __DIR__ . '/../../../../../../bin/');

    // Not really sure where it went
    else
      throw new TikTokException('Vendor bin path not found.');
  }

  public static function varName () {
    $bt   = debug_backtrace();
    $file = file($bt[0]['file']);
    $src  = $file[$bt[0]['line']-1];
    $pat = '#(.*)'.__FUNCTION__.' *?\( *?(.*) *?\)(.*)#i';
    $var  = preg_replace($pat, '$2', $src);
    return trim($var);
  }
}
