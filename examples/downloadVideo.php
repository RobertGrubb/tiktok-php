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
  // username & id of video
  $data = $scraper->user->downloadVideo('iratee', 6821468282583928069, false);

  // Check for an error here.
  if ($scraper->error) print_r($scraper->error);

  // Print the data
  print_r($data);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
