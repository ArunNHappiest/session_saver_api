<?php
ob_start();
require_once 'src/GuruAppSessionHandler.php';
require_once 'src/ApiSessionHandler.php';
require_once 'src/RedisClusterSessionHandler.php';
require_once 'src/RedisSessionHandler.php';

$useHandler = 'redis'; // Can be 'api', 'redis_cluster', or 'redis'

switch ($useHandler) {
    case 'api':
        $sessionHandler = new ApiSessionHandler('https://session.api.endpoint/');
        break;
    case 'redis_cluster':
        $clusterNodes = ['clustercfg.pgsession2.pr3z0i.memorydb.ap-south-1.amazonaws.com:6379'];
        $sessionHandler = new RedisClusterSessionHandler($clusterNodes, 3600);
        break;
    case 'redis':
        $redisHost = 'localhost';
        //$redisHost = 'clustercfg.pgsession2.pr3z0i.memorydb.ap-south-1.amazonaws.com';
        $redisPort = 6379;
        $sessionHandler = new RedisSessionHandler($redisHost, $redisPort, 3600);
        break;
    default:
        throw new Exception('Invalid session handler specified.');
}

// Set the custom session handler
$guruAppSessionHandler = new GuruAppSessionHandler($sessionHandler);
session_set_save_handler($guruAppSessionHandler, true);

session_set_save_handler($handler, true);
session_start();
