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

// Needs a cookie session to work effectively.
try {
  $data = $scraper->account->details('iratee');

  // Scraper will set an error, and you can check it like so:
  if (!$data && $scraper->error !== false) print_r($scraper->error);

  print_r($data);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
