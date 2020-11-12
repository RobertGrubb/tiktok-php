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
  $data = $scraper->user->downloadVideoFromUrl('https://v16-web.tiktok.com/video/tos/useast2a/tos-useast2a-ve-0068c003/6ecd1dae184e4811b98d7e7ac3e39fc1/?a=1988&br=1904&bt=952&cr=0&cs=0&dr=0&ds=3&er=&expire=1605237993&l=202011122125460101902190781C013978&lr=tiktok_m&mime_type=video_mp4&policy=2&qs=0&rc=ajdmc2x3Zjl3eDMzOjczM0ApN2hpZ2ZoZTw6NzRkaDQ0O2dzYGVkYjBmNWhfLS01MTZzc2AwMS0vMy4wXy0xYF41Li46Yw%3D%3D&signature=bfafc12fa41fc566400a620058d261ef&tk=tt_webid_v2&vl=&vr=
',
    [
      'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36',
      'cookies' => [
        'tt_webid' => 'xxx',
        'tt_webid_v2' => 'xxx'
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
