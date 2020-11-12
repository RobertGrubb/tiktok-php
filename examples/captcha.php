<?php

require '../vendor/autoload.php';
require_once __DIR__ . '/../src/TikTok.php';

/**
 * Get development config
 */
$config = require_once __DIR__ . '/env.php';

use TikTok\Scraper;

// Instantiate TikTok Scraper library
$scraper = new Scraper($config);


try {

  $data = $scraper->captcha->setFp()->get()->solve();

  var_dump($data);

} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
