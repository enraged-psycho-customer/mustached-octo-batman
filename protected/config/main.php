<?php
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'CLFH.ORG',
    'language' => 'ru',
    'theme' => 'classic',
    'defaultController' => 'items',

    // preloading 'log' component
    'preload' => array('log'),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.coco.*',
        'ext.easyimage.EasyImage',
        'ext.*',
    ),

    'modules' => array(
        // Future is now
    ),

    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<id:\d+>' => 'items/view',
                '<action:\w+>' => 'items/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'easyImage' => array(
            'class' => 'application.extensions.easyimage.EasyImage',
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'maintenanceMode' => 0,
        'currentStage' => 2,
        'currentAnnouncement' => 1,
    ),
);