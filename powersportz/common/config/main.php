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
                'clientId' => '948450055241654',
                'clientSecret' => 'a65e8151196eb85341f0a98016c6e16a',
    ],
            'google' => [
                'class' => 'yii\authclient\clients\GoogleOAuth',
                'clientId' => '10412981768-k3g1pqrt70g86ujsmselb0e9vg3hrr6a.apps.googleusercontent.com',
                'clientSecret' => 'rhWslKJ6vaZ9_shRF6uzoedR',
				'returnUrl' => 'http://staging.powersportz.tv/member/authforgoogle?authclient=google',
				'scope'=>'https://www.googleapis.com/auth/userinfo.email',
            ],
    ],
    ]
    ],
];
