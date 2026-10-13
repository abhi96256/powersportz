<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'eng-US',
    // 'bootstrap'    => ['assetsAutoCompress'],
   'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
       /* 'assetsAutoCompress' =>
        [
            'class'             => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
            'enabled'           => true,
            'jsCompress'        => false,
            'cssFileCompile'    => true,
            'jsFileCompile'     => true,
        ],*/
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'showScriptName' => false,
            'enableStrictParsing' => false,
        ],
         'i18n' => [
        'translations' => [
            'frontend' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@common/messages',
            ],
            'backend' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@common/messages',
            ],
        ],
    ],
    'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'facebook' => [
                'class' => 'yii\authclient\clients\Facebook',
                'clientId' => '634837783322685',
                'clientSecret' => '2ac2005e4d5d8670796cbbea158f2ff3',
    ],
            'google' => [
                'class' => 'yii\authclient\clients\GoogleOAuth',
                'clientId' => '10412981768-ooovbrb8mk3g9p56lb8gkipuohqdrb0t.apps.googleusercontent.com',
                'clientSecret' => 'xQW-MFZjOOTHCftDG-8coVkc',
                'returnUrl' => 'http://powersports3.e2logy.com/member/authforgoogle',
            ],
    ],
    ]
    ],
];
