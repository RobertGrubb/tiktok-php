<?php

require '../vendor/autoload.php';
require_once __DIR__ . '/../src/TikTok.php';

/**
 * Get development config
 */
// config = require_once __DIR__ . '/env.php';

use TikTok\Scraper;

// Instantiate TikTok Scraper library
$scraper = new Scraper([
  'verbose' => true
]);


/**
 * Running the following generates a webid and session id
 * on TikTok's servers. I'm still working on figuring out
 * what this means. All I've found at the moment is if you generate
 * it once, the rate limiting / verification slows down.
 *
 * However, if you attempt to re-generate it again, you end up
 * receiving a 405 error afterwards. It seems to me they log
 * the ip when registering this. Will look further.
 */
$scraper
  ->session
  ->webid()
  ->ssid();

// Call after the webid and ssid has been generated on tiktok
$data = $scraper->user->videos('iratee', 10);

// Check for an error here.
if ($scraper->error) print_r($scraper->error);

var_dump($data);
