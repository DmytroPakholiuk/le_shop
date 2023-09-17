<?php

return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => 'common\models\User',
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
//            'dsn' => getenv('LE_SHOP_DOCKER_DB_TEST_DSN'),
            'dsn' => 'pgsql:host=le_shop_pgsql;dbname=le_shop_test',
//            'username' => getenv('LE_SHOP_DOCKER_DB_USER'),
            'username' => 'le_shop',
//            'password' => getenv('LE_SHOP_DB_PASSWORD'),
            'password' => 'le_shop',
            'charset' => 'utf8',
        ],
    ],
];
