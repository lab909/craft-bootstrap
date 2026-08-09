<?php
/**
 * Craft web bootstrap file
 */

// Load shared bootstrap
require dirname(__DIR__) . '/bootstrap.php';

$offlineModeActivated = isset($_ENV['OFFLINE_MODE_ACTIVATED']) && $_ENV['OFFLINE_MODE_ACTIVATED'] === 'true';
$allowedIpAddresses = isset($_ENV['OFFLINE_MODE_ALLOWED_IP_ADDRESSES']) ? explode(",", $_ENV['OFFLINE_MODE_ALLOWED_IP_ADDRESSES']) : [];
$offlineModeCustomMessage = !empty($_ENV['OFFLINE_MODE_CUSTOM_MESSAGE']) ? $_ENV['OFFLINE_MODE_CUSTOM_MESSAGE'] : "The website is down for planned maintenance. We'll be back in few minutes.";

if($offlineModeActivated and !empty($allowedIpAddresses)){
    $currentUserIpAddress = $_SERVER['REMOTE_ADDR'];
    if(false === in_array($currentUserIpAddress, $allowedIpAddresses)){
        die($offlineModeCustomMessage);
    }
}

// Load and run Craft
/** @var craft\web\Application $app */
$app = require CRAFT_VENDOR_PATH . '/craftcms/cms/bootstrap/web.php';
$app->run();