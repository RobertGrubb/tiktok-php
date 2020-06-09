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
  // username & id of video
  $data = $scraper->user->video('iratee', 6821468282583928069);

  // Check for an error here.
  if ($scraper->error) print_r($scraper->error);
  
  print_r($data);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
