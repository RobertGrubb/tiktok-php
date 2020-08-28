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
  // Get the initial first 30
  $data = $scraper->user->allVideos('rocksrockout');

  // Check for an error here.
  if ($scraper->error) {
    print_r($scraper->error);
    exit;
  }

  print_r($data);

} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
