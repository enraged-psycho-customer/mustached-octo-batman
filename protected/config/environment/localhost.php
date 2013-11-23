<?php
return CMap::mergeArray(
    require(dirname(dirname(__FILE__)) . '/main.php'),
    array(
        'modules' => array(
            'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => 'asphyx1a',
                'ipFilters' => array('127.0.0.1', '::1'),
            ),
        ),
        'components' => array(
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=clfh_org',
                'emulatePrepare' => true,
                'username' => 'clfh_org',
                'password' => '=9A*eIZGd"dWN$ze#Nf2',
                'charset' => 'utf8',
                'tablePrefix' => '',
                'enableProfiling' => true,
                'enableParamLogging' => true,
            ),
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'error, warning',
                    ),
                    array(
                        'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                        // Access is restricted by default to the localhost
                        'ipFilters' => array('::1', '127.0.0.1'),
                    ),
                ),
            ),
        ),
    )
);
