  <?php
$params = array_merge(
  require(__DIR__ . '/../../common/config/params.php'),
  require(__DIR__ . '/../../common/config/params-local.php'),
  require(__DIR__ . '/params.php'),
  require(__DIR__ . '/params-local.php')
);

use \yii\web\Request;
use yii\helpers\Url;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
  'id' => 'app-frontend',
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log'],
  'controllerNamespace' => 'frontend\controllers',
  'components' => [
    'request' => [
      'baseUrl' => $baseUrl,
    ],
    'user' => [
      'identityClass' => 'common\models\User',
      'enableAutoLogin' => true,
      'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
                'path'=>'/frontend/web'  // correct path for the frontend app.
              ]
            ],
            'session' => [
            'name' => '_frontendSessionId', // unique for frontend
            'savePath' => __DIR__ . '/../runtime', // a temporary folder on frontend
          ],
          'assetManager' => [
            'bundles' => [
              'yii\web\JqueryAsset' => [
                            //'js'=>[]
              ],
              'yii\bootstrap\BootstrapPluginAsset' => [
                            //'js'=>[]
              ],
              'yii\bootstrap\BootstrapAsset' => [
                            //'css' => [],
              ],

            ],
          ],
          'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules'=>[
             '/'=>'site/index',

             'rules/index/<id>'=>'rules/index',
             'rules/index'=>'rules/index',
             // 'video/<id:\d+>/<CategoryID:\d+>'=>'video/index',
             // 'video/<id:\d+>'=>'video/index',
             /************************ Custom URL Generate **************/
             'schedule/<sdate:[A-Za-z0-9 -_.]+>/' => 'schedule/index/',
             'schedule/' => 'schedule/index/',
             'action/'=>'sports/index',
             'talking-turkey/'=>'talking-points/index',
             'throwback/'=>'playlists/index', 
             'action/<CategoryID:[A-Za-z0-9 -_.]+>/<id:[A-Za-z0-9 -_.]+-\d+>/' => 'video/index/',
             'action/<id:[A-Za-z0-9 -_.]+>'=>'sports/index',
             'talking-turkey/<CategoryID:[A-Za-z0-9 -_.]+>/<id:[A-Za-z0-9 -_.]+-\d+>' => 'video/index/',
             'talking-turkey/<id:[A-Za-z0-9 -_.]+>'=>'talking-points/index',
             'throwback/<id:[A-Za-z0-9 -_.]+>/<video:[A-Za-z0-9 -_.]+-\d+>' => 'playlistdetails/index/',
             'throwback/<id:[A-Za-z0-9 -_.]+>' => 'playlistdetails/index/',
             'contact-us/' => 'site/contact',
             'terms-and-conditions/' => 'terms/index',
             'academy/institutional-licence' => 'academy/institutional-licence',
             'academy/institutional-licence/' => 'academy/institutional-licence',
             'academy' => 'academy/index',
             'academy/' => 'academy/index',
             'search/<Video:[A-Za-z0-9 -_.]+>' => 'search/index/',
             '<CategoryID:[A-Za-z0-9 -_.]+>/<id:[A-Za-z0-9 -_.]+-\d+$>' => 'video/index/',
             '<id:[A-Za-z0-9 -_.]+-\d+$>' => 'video/index/',
             /************************ END Custom URL Generate **************/
               //'<controller:\w+>/<action>/<id>/<video>' => '<controller>/<action>',
             '<controller:\w+>/<action>/<id>' => '<controller>/<action>',
             '<controller:\w+>/<action>'=>'<controller>/<action>',
             '<controller:\w+>/'=>'<controller>/index',
           ]
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
                'useFileTransport' => false,//set this property to false to send mails to real email addresses
                'transport' => [
                  'class' => 'Swift_SmtpTransport',
                  'host' => 'smtp.gmail.com',
                  'username' => 'eetplvendor@gmail.com',
                  'password' => 'E2logy@1234',
                  'port' => '587',
                  'encryption' => 'tls',
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
                //'class' => 'yii\authclient\clients\GoogleOAuth',
                    'clientId' => '10412981768-k3g1pqrt70g86ujsmselb0e9vg3hrr6a.apps.googleusercontent.com',
                    'clientSecret' => 'rhWslKJ6vaZ9_shRF6uzoedR',
                    'returnUrl' => $params['domainName'].'/member/authforgoogle?authclient=google',
                    'scope'=>'https://www.googleapis.com/auth/userinfo.email',
                  ],
                ],
              ]

            ],
            'params' => $params,
          ];
