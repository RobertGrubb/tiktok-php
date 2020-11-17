<?php

namespace TikTok\Core\Libraries;

use TikTok\Core\Exceptions\TikTokException;

class Fp {

  private static function baseConvertTimestamp () {
    return base_convert(time(), 10, 36);
  }

  private static function random ($len = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $len; $i++)
      $string = $characters[rand(0, strlen($characters) - 1)];

    return $string;
  }

  public static function generate () {

    $generated = [];

    $dateString = self::baseConvertTimestamp();

    for ($i = 0; $i < 36; $i++) {
      if ($i === 8 || $i === 13 || $i === 18 || $i === 23) {
        $generated[$i] = "_";
      } elseif ($i === 14) {
        $generated[$i] = "4";
      } else {
        $generated[$i] = self::random(1);
      }
    }

    return "verify_" . $dateString . "_" . implode('', $generated);
  }
}
