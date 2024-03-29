<?php
return [
    'id' => 'le_shop',
    'name' => 'Le Shop',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'uk-UK',
    'sourceLanguage' => 'en-US',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
//        'mongodb' => [
//            'class' => '\yii\mongodb\Connection',
//            'dsn' => getenv('LE_SHOP_MONGODB_DSN'),
//        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/goods' => 'goods.php',
                        'app/category' => 'category.php',
                        'app/order' => 'order.php',
                        'app/attribute' => 'attribute.php',
                        'app/rbac' => 'rbac.php',
                        'app/user' => 'user.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => getenv('LE_SHOP_DOCKER_DB_DSN'),
            'username' => getenv('LE_SHOP_DOCKER_DB_USER'),
            'password' => getenv('LE_SHOP_DOCKER_DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class
        ],

        'rabbit' => [
            'class' => \common\components\AMQPManager::class,
            'host' => 'localhost',
            'port' => 5672,
            'user' => 'guest',
            'pass' => 'guest',
            'vhost' => '/'
        ]
    ],
    'params' => [
        'bsVersion' => '5.x'
        ]
];
