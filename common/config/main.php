<?php
return [
    'id' => 'le_shop',
    'name' => 'Le Shop',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
    'params' => [
        'bsVersion' => '5.x'
        ]
];
