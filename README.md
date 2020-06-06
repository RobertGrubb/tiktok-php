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
