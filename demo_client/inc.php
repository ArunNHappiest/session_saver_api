<?php
ob_start();
// require 'ApiSessionHandler.php';

// $apiBaseUrl = 'https://session.commonstatesaver.com/index.php';
// $handler = new ApiSessionHandler($apiBaseUrl);
require 'RedisSessionHandler.php';

$redisHost = 'clustercfg.pgsession2.pr3z0i.memorydb.ap-south-1.amazonaws.com';
$redisPort = 6379;
$ttl = 3600;
$handler = new RedisSessionHandler($redisHost, $redisPort, $ttl);

session_set_save_handler($handler, true);
session_start();