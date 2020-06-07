# TikTok Scraper in PHP

`Status: Work in progress.`

*NOTE* I will be pushing code out for this gradually, and is currently not pushed out to a package at the moment. Will publish to a package soon.


## Configuration Explained

```
[
  // Sign method
  'signMethod' => 'node' // Or datafetch

  // User agent
  'userAgent' => '',

  // Optional proxy (auth is also optional)
  'proxy' => [
    'protocol' => 'http',
    'address' => '127.0.0.1:8080',
    'auth' => 'username:password'
  ],

  // Time before curl request times out
  'timeout' => 20
]
```

## User data

```
$scraper->user->details('username');
```

## User videos

```
$scraper->user->videos(123415125125);
```

## Discover

```
$scraper->general->discover('music');
$scraper->general->discover('user');
$scraper->general->discover('hashtag');

// Offset and count:

$scraper->general->discover('music', [
  'count' => 10,
  'offset' => 10
]);

```

## Trending

```
// 25 being the number of items to return.
$scraper->general->discover(25);
```

## Signing a URL

2 methods of signing the URL is provided.

1. You can use nodejs, this package will look to see if you have it installed, however, if you do not, it will attempt to install it.

2. You can use the datafet.ch api that I have personally built to accept requests from anyone to sign a tiktok url. (This package handles it automatically if you set `'signMethod' => 'datafetch'` in the configuration.)

```
$scraper->signUrl('TIKTOK_URL_HERE');
```

# Legal

This repo and it's contents are in no way affiliated with, authorized, maintained, sponsored or endorsed by TikTok or any of its affiliates or subsidiaries. This is an independent and unofficial package. Use at your own risk.
