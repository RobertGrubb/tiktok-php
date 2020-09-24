<?php

require '../vendor/autoload.php';
require_once __DIR__ . '/../src/TikTok.php';

/**
 * Get development config
 */
$config = require_once __DIR__ . '/env.php';

use TikTok\Scraper;

// Instantiate TikTok Scraper library
$scraper = new Scraper();

$res = $scraper->captcha->get('verify_2e1f76c77655b2f80b62d92c17a3a133');

print_r($scraper->captcha->captchaData);
