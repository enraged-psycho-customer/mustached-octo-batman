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
                'connectionString' => 'mysql:host=localhost;dbname=clfh',
                'emulatePrepare' => true,
                'username' => 'clfh',
                'password' => 'fjkl3498F#$',
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
                        'ipFilters' => array(
                            '95.31.212.67',     // Pavel Kiselev
                            '78.139.231.46',    // Edward Medvedev
                        ),
                    ),
                ),
            ),
        ),
    )
);