# TikTok Scraper in PHP

`Status: Work in progress.`

*NOTE* I will be pushing code out for this gradually, and is currently not pushed out to a package at the moment. Will publish to a package soon.


## Configuration Explained

```
[
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

```
$scraper->signUrl('TIKTOK_URL_HERE');
```
