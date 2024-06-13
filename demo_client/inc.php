<?php
ob_start();
require 'ApiSessionHandler.php';

$apiBaseUrl = 'https://session.commonstatesaver.com/index.php';
$handler = new ApiSessionHandler($apiBaseUrl);
session_set_save_handler($handler, true);
session_start();