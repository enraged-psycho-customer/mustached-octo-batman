<?php
return CMap::mergeArray(
    require(dirname(dirname(__FILE__)) . '/main.php'),
    array(
        'components' => array(
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=clfh_org',
                'emulatePrepare' => true,
                'username' => 'clfh_org',
                'password' => '=9A*eIZGd"dWN$ze#Nf2',
                'charset' => 'utf8',
                'tablePrefix' => '',
                'schemaCachingDuration' => 28800,
            ),
        ),
    )
);