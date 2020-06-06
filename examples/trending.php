<?php

require '../vendor/autoload.php';
require_once __DIR__ . '/../src/TikTok.php';

/**
 * Get development config
 */
// config = require_once __DIR__ . '/env.php';

use TikTok\Scraper;

// Instantiate TikTok Scraper library
$scraper = new Scraper();


try {
  $data = $scraper->trending(25);
  print_r($data);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
