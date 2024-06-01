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
        'redis' => [
            'class' => \yii\redis\Connection::class,
//            'hostname' => 'le_shop_redis',
        //todo change it to refer to the redis container
//            'hostname' => 'localhost',
            'hostname' => getenv("LE_SHOP_DOCKER_REDIS_IP"),
            'port' => 6379,
            'database' => 0,
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => getenv('LE_SHOP_DOCKER_DB_DSN'),
            'username' => getenv('LE_SHOP_DOCKER_DB_USER'),
            'password' => getenv('LE_SHOP_DOCKER_DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'cache' => [
//            'class' => \yii\caching\FileCache::class,
            'class' => yii\redis\Cache::class,
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
