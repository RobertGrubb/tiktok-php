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


// Needs a cookie session to work effectively.
try {
  $data = $scraper->signUrl('https://m.tiktok.com/api/item_list/?count=30&id=6736134763096409093&type=1&secUid=&maxCursor=0&minCursor=0&sourceType=8&appId=1233&region=US&language=en&verifyFp=');
  print_r($data);

  /**
   * Should return:
   * ['url'] && ['signature']
   */
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
