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
  $data = $scraper->user->downloadVideoFromUrl('url_here',
    [
      'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36',
      'cookies' => [
        'tt_webid' => 'xxxxx',
        'tt_webid_v2' => 'xxxx'
      ]
    ]
  );

  // Check for an error here.
  if ($scraper->error) print_r($scraper->error);

  // Print the data
  print_r($data);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
