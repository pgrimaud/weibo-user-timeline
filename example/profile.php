<?php

use Weibo\Api;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new Api();
$api->setUserId(6356999361);
$feed = $api->getFeed();

print_r($feed);
