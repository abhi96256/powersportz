<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);


return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','thumbnail'],
    'modules' => [
        'academy' => [
            'class' => 'backend\modules\academy\Module',
        ],
    ],
    'components' => [
         'twitter' => [
            'class' => 'richweber\twitter\Twitter',
            'consumer_key' => twitterApiKey,
            'consumer_secret' => twitterApiSecret,
          /*  'oauth_token'=> twitterAccessToken,
            'oauth_token_secret'=> twitterAccessTokenSecret,*/
          'callback' => 'http://powersports3.e2logy.com/sharetwitter/callback.php',
        ],
       'user' => [
                    'identityClass' => 'common\models\User',
                    'enableAutoLogin' => true,
                    'identityCookie' => [
                        'name' => '_backendUser', // unique for backend
                        'path'=>'/backend/web'  // correct path for the backend app.
                    ]
        ],
         'urlManagerFrontEnd' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'image' => array(
                        'class' => 'yii\image\ImageDriver',
                        'driver' => 'GD',  //GD or Imagick
                    ),
'session' => [
    'name' => '_backendSessionId', // unique for backend
    'savePath' => __DIR__ . '/../runtime', // a temporary folder on backend
],
        'thumbnail' => [
        'class' => 'himiklab\thumbnail\EasyThumbnail',
        'cacheAlias' => 'assets/gallery_thumbnails',
    ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
     'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false, //set this property to false to send mails to real email addresses
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'email-smtp.ap-south-1.amazonaws.com',
                'username' => 'AKIA5JYOFTDIQIQYX572',
                'password' => 'BBbSoPngk/t2zpiAHlrZKYyFLBAp2QUxy6/0A9l4vciw',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
    ],
    'params' => $params,
];
