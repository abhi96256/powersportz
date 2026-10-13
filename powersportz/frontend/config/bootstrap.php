<?php

switch ($_SERVER['SERVER_NAME']) {
  case 'www.powersportz.local':
  case 'dev.powersportz.tv':
  case 'localhost':
    error_reporting(0);
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    define('__PS_APP_ENV__', 'dev');
    break;
  case 'staging.powersportz.tv':
  case 'stgcms.powersportz.tv':
    error_reporting(1);
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    define('__PS_APP_ENV__', 'uat');
    break;
  default:
    error_reporting(0);
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    define('__PS_APP_ENV__', 'prod');
    break;
}
