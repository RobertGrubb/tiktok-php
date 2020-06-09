# TikTok Scraper in PHP

`Status: Work in progress.`

```
By default, this scraper will attempt to use NodeJS to sign the URL. If you do not have node installed, it will attempt to install it during the composer install step. If you do, it will simply find the path to it. If you'd like to change this logic, you can read more below about setting your signMethod => 'datafetch', an API I have created for signing tiktok urls.
```

## Installation

```
composer require robert-grubb/tiktok-php
```

## Instantiation

```
require './vendor/autoload.php';

use TikTok\Scraper;

// Instantiate TikTok Scraper library
$scraper = new Scraper([
  // Sign method
  'signMethod' => 'datafetch'
  'datafetchApiKey' => ''
  'userAgent' => '',
  'proxy' => [
    'protocol' => 'http',
    'address' => '127.0.0.1:8080',
    'auth' => 'username:password'
  ],
  'timeout' => 20
]);
```

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

// Or use username, 10 is the count of videos to return.
$scraper->user->videos('iratee', 10);
```

## Discover

```
$scraper->discover->get('music');
$scraper->discover->get('user');
$scraper->discover->get('hashtag');

// Offset and count:

$scraper->general->discover('music', [
  'count' => 10,
  'offset' => 10
]);

```

## Trending

```
// 25 being the number of items to return.
$scraper->trending->videos(25);
```

## Hashtag Data

```
$scraper->hashtag->data('beatbox');
```

## Hashtag Videos

```
// 30 being the count of videos to return
$scraper->hashtag->videos('beatbox', 30);
```

## Signing a URL

2 methods of signing the URL is provided.

1. You can use nodejs, this package will look to see if you have it installed, however, if you do not, it will attempt to install it.

2. You can use the datafet.ch api that I have personally built to accept requests from anyone to sign a tiktok url. (This package handles it automatically if you set `'signMethod' => 'datafetch'` in the configuration.)

```
$scraper->signUrl('TIKTOK_URL_HERE');
```

## DataFetch API Key

DataFetch API does rate limit your requests at a max of 100 requests per 15 minutes. This can be avoided by obtaining an API key, which will then give you access to unlimited requests. You can obtain access by contacting me at `matt [at] grubb [dot] com`.

# Errors

If anything error happens throughout the scraper, it will set the error at the following:

```
$scraper->error
```

Which will return the following structure:

```
[
  'error' => true,
  'message' => 'Detailed error message here.'
]
```

Also, the method you called will also return `false`.

---------------

If there was no error, two things you will notice:

1. `$scraper->error` is set to `false`
2. The method you called will not return `false`

# Legal

This repo and it's contents are in no way affiliated with, authorized, maintained, sponsored or endorsed by TikTok or any of its affiliates or subsidiaries. This is an independent and unofficial package. Use at your own risk.
