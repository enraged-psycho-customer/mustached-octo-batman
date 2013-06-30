<?php
// Base paths
define('YII_SOURCE_BASEPATH', '/framework/');
define('YII_CONFIG_BASEPATH', '/protected/config/environment/');

// Environments
define('YII_ENV_DEVELOPMENT', 'clfh.doesnotcompute.ru');

// Define environment
switch ($_SERVER['HTTP_HOST']) {
    // Development server
    case YII_ENV_DEVELOPMENT:
        define('YII_DEBUG', true);
        define('YII_TRACE_LEVEL', 3);
        define('YII_ENV', 'development');
        $yii = dirname(__FILE__) . YII_SOURCE_BASEPATH .  'yii.php';
        $config = dirname(__FILE__) . YII_CONFIG_BASEPATH . 'development.php';
        break;

    // Local server
    default:
        define('YII_DEBUG', true);
        define('YII_TRACE_LEVEL', 3);
        define('YII_ENV', 'localhost');
        $yii = dirname(__FILE__) . YII_SOURCE_BASEPATH . 'yii.php';
        $config = dirname(__FILE__) . YII_CONFIG_BASEPATH . 'localhost.php';
}

// Create yii webapp and run
require_once($yii);
Yii::createWebApplication($config)->run();