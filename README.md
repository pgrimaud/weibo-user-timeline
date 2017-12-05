# Weibo user timeline PHP

Bored about chinese documentation? Easily fetch user's weibo timeline without oAuth.

[![Build Status](https://travis-ci.org/pgrimaud/weibo-user-timeline.svg?branch=master)](https://travis-ci.org/pgrimaud/weibo-user-timeline)
[![Packagist](https://img.shields.io/badge/packagist-install-brightgreen.svg)](https://packagist.org/packages/pgrimaud/weibo-user-timeline)
[![Code Climate](https://codeclimate.com/github/pgrimaud/weibo-user-timeline/badges/gpa.svg)](https://codeclimate.com/github/pgrimaud/weibo-user-timeline)
[![Test Coverage](https://codeclimate.com/github/pgrimaud/weibo-user-timeline/badges/coverage.svg)](https://codeclimate.com/github/pgrimaud/weibo-user-timeline/coverage)
[![Issue Count](https://codeclimate.com/github/pgrimaud/weibo-user-timeline/badges/issue_count.svg)](https://codeclimate.com/github/pgrimaud/weibo-user-timeline)

## Installation

```
composer req pgrimaud/weibo-user-timeline
```

## Usage

```php

$api = new Api();
$api->setUserId(6356999361);
$feed = $api->getFeed();

print_r($feed);

```

```
Weibo\Hydrator\Feed Object
(
    [title] => pgrimaud 的微博rss
    [description] => YOLO
    [items] => Array
        (
            [0] => Weibo\Hydrator\Item Object
                (
                    [id] => c56dad8c9faef724e7447b0d40f829a0
                    [title] => Cute cat in snow and Iron Man : http://t.cn/RtsEHkr :) ​
                    [date] => DateTime Object
                        (
                            [date] => 2017-09-29 21:57:41.000000
                            [timezone_type] => 1
                            [timezone] => +08:00
                        )

                    [link] => http://weibo.wbdacdn.com/user/6356999361/status4157436061195251.html
                    [images] => Array
                        (
                            [0] => http://wx1.sinaimg.cn/large/006WdjVLgy1fk0s1i9h1cj31hc0zk7e9.jpg
                            [1] => http://wx2.sinaimg.cn/large/006WdjVLgy1fk0s1kuvdzj30fo0mgwgv.jpg
                        )

                )

            [1] => Weibo\Hydrator\Item Object
                (
                    [id] => 84cffeefc55881d80973ef49de597f96
                    [title] => Another Weibo ultimate test #剧版醉玲珑# #大鹏逐影之路# #我心中的警察英雄# #电影空天猎# #史上最全甜萌小说# ​
                    [date] => DateTime Object
                        (
                            [date] => 2017-09-29 20:47:27.000000
                            [timezone_type] => 1
                            [timezone] => +08:00
                        )

                    [link] => http://weibo.wbdacdn.com/user/6356999361/status4157418387172577.html
                    [images] => Array
                        (
                        )

                )

            [2] => Weibo\Hydrator\Item Object
                (
                    [id] => b666e96c68179094fb80398f8db7814d
                    [title] => #My first Weibo# :) ​
                    [date] => DateTime Object
                        (
                            [date] => 2017-09-05 22:56:00.000000
                            [timezone_type] => 1
                            [timezone] => +08:00
                        )

                    [link] => http://weibo.wbdacdn.com/user/6356999361/status4148753428858264.html
                    [images] => Array
                        (
                        )

                )

        )

)
```

## FAQ

### How to find user's Weibo ID ?

Go to user's profile page > click on "Photos" or "Album"

UserId is : http://photo.weibo.com/{userId}/talbum/detail/photo_id/xxxxxxxx
