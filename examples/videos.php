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
  $data = $scraper->user->videos('iratee', 10);

  // Check for an error here.
  if ($scraper->error) print_r($scraper->error);


  if (isset($data->detail)) echo $data->detail;

  print_r($data);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
