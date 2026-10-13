<?php
header('Cache-Control: must-revalidate, proxy-revalidate, max-age=300,s-maxage=300');
header("Pragma:cache");

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use kartik\typeahead\Typeahead;

// $this->registerJsFile('../js/jquery.textrotator.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#">
  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    echo (__PS_APP_ENV__ != 'prod') ? '<meta name="robots" content="noindex, nofollow">' : '';
    ?>
    <link href="//www.google-analytics.com" rel="dns-prefetch" />
    <link href="//www.google-analytics.com" rel="preconnect" />
    <link href="//www.powersportz.tv" rel="dns-prefetch" />
    <meta name="google-site-verification" content="-JEqint-IwEJR1m8zHwicmPeHdd55FdwU24gOHenREg" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php /* Google needs >=48x48 favicon (old /favicon.ico was 32x32 → globe in SERP) */ ?>
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon-192x192.png">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <?php $this->head() ?>    
    <?php if (__PS_APP_ENV__ == 'prod') { ?>
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118076397-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
          dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-118076397-1');
      </script>
      <!-- End Google Analytics -->
    <?php } else { ?>
      <!--  Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119895291-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
          dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-119895291-1');
      </script>
      <!-- End Google Analytics -->
      <?php
    }
    $this->registerJs("$('#demo').textRotator({
    random : true,
    fadeIn : 1000,
    fadeOut : 500,
    duration : 1000,
    debug : false
});
");
    ?>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '953607643877187');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=953607643877187&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
  </head>
  <body class="home home-t-h">    
    <?php $this->beginBody() ?>
    <div class="dark light">
      <!--Start of Header-->
      <header class="transparent">
        <div class="main-header headerstyle-1">
          <div class="container-fluid">
            <div class="row"> 
              <div class="pull-right my-account" style="display:none">
                <div class="log-in">
                  <?php
                  if (Yii::$app->user->isGuest) {
                    echo '<a href="' . Url::toRoute('member/login') . '">' . Yii::t('frontend', 'Login') . '</a>';
                  } else {
                    //echo '<a href="'.Url::toRoute('member/logout').'">'.Yii::t('frontend','Logout').'('.Yii::$app->user->identity->UserName .')</a>';
                    echo '<a href="' . Url::toRoute('member/myprofile') . '">' . Yii::t('frontend', 'myprofile') . '</a>';
                  }
                  ?>
                </div></div>                          
              <!--Start of Menu-->
              <div class="col-md-10 wr-menu-section">
                <nav class="primary-menu spo-primary-navigation ">

                  <div id="navbar-collapse-1" class="navbar-collapse collapse ">
                    <?php /* ?> <div class="col-md-2" style="display: none">
                      <ul>
                      <li>
                      <a href="/"><img src="/images/logo/desktop_logo.png" style="width:160px;margin-left: 45px"/>
                      </a>  </li>
                      </ul>
                      </div><?php */ ?>
                    <?php /* <div class="col-md-12"> */ ?>
                    <div id="templatemo_menu" class="ddsmoothmenu">
                      <ul>

                        <li class="header_li_height"><a href="<?php echo Yii::$app->homeUrl ?>"><?php echo Yii::t('frontend', 'Home'); ?></a></li>
                        <li class="header_li_height" <?php
                        if (Yii::$app->controller->id == 'sports') {
                          echo 'class="active parent-active"';
                        }
                        ?>><a href="<?php echo Url::toRoute('/action') ?>"><?php echo Yii::t('frontend', 'Action'); ?></a></li>
                        <li class="header_li_height" <?php
                        if (Yii::$app->controller->id == 'playlists') {
                          echo 'class="active parent-active"';
                        }
                        ?>><a href="<?php echo Url::toRoute('/throwback') ?>"><?php echo Yii::t('frontend', 'Throwback'); ?></a></li>
                            <?php /* <li <?php if (Yii::$app->controller->id == 'livescore') {
                              echo 'class="active parent-active"';
                              } ?>><a href="<?php echo Url::toRoute('livescore')?>"><?php echo Yii::t('frontend','Live Scores');?></a></li> */ ?>
                        <li class="header_li_height" <?php
                        if (Yii::$app->controller->id == 'talking-points') {
                          echo 'class="active parent-active"';
                        }
                        ?>><a href="<?php echo Url::toRoute('/talking-turkey') ?>"><?php echo Yii::t('frontend', 'Talking Turkey'); ?></a></li>
                        <li class="header_li_height" <?php
                        if (Yii::$app->controller->id == 'schedule') {
                          echo 'class="active parent-active"';
                        }
                        ?>><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl() . '/schedule' ?>"><?php echo Yii::t('frontend', 'Schedule'); ?></a></li>
                        <li class="header_li_height">
                          <form action="<?php echo Yii::$app->getUrlManager()->getBaseUrl() ?>/search" name="Searchform" method="post" class="searchform">
                            <input type="text" name="Video"  class="form-control dropmenu-search" placeholder="<?php echo Yii::t('frontend', 'search'); ?>" required value="<?= Yii::$app->request->get('Video'); ?>" />
                            <input type="submit" name="submit" value="" class="btn-search"></form>
                        </li>
                        <li class="header_li_height" <?php
                        if (Yii::$app->controller->id == 'certificate') {
                          echo 'class="active parent-active"';
                        }?>>
                        <a href="<?php echo Url::toRoute('/academy') ?>"><?= Yii::t('frontend', 'PS Academy') ?> </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <?php /*   </div> */ ?>
                </nav>
                <div class="clear"></div>
                <!-- RESPONSIVE NAVIGATION -->
                <nav class="spo-responsive-navigation pull-left"> <span class="spo-responsive-trigger"></span>
                  <ul class="wr-res-menu">
                    <li>
                      <a href="/"><img src="/images/logo/mobile_logo.png" style="padding-top: 10px;width:160px"/>
                      </a>  </li>
                    <li><a href="<?php echo Yii::$app->homeUrl ?>"><?php echo Yii::t('frontend', 'Live TV'); ?></a></li>
                    <li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl() . '/action' ?>"><?php echo Yii::t('frontend', 'Action'); ?></a></li>
                    <li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl() . '/throwback' ?>"><?php echo Yii::t('frontend', 'Throwback'); ?></a></li>
                    <?php /*
                      <li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl().'/livescore'?>"><?php echo Yii::t('frontend','Live Scores');?></a></li> */ ?>
                    <li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl() . '/talking-turkey' ?>"><?php echo Yii::t('frontend', 'Talking Turkey with Kanthi'); ?></a></li>
                    <li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl() . '/academy' ?>"><?php echo Yii::t('frontend', 'PS Academy'); ?></a></li>
            
                    
                    <li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl() . '/schedule' ?>"><?php echo Yii::t('frontend', 'Schedule'); ?></a></li>
                    <li>
                      <form action="<?php echo Yii::$app->getUrlManager()->getBaseUrl() ?>/search" method="post" class="searchform" name="Searchform">
                        <input type="text" name="Video"  class="form-control dropmenu-search" placeholder="<?php echo Yii::t('frontend', 'search'); ?>" required  value="<?= Yii::$app->request->get('Video'); ?>"/>
                        <input type="submit" name="submit" value="" class="btn-search">
                      </form>
                    </li>
                    <li class="header_li_height" <?php
                        if (Yii::$app->controller->id == 'certificate') {
                          echo 'class="active parent-active"';
                        }?>>
                        <li><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl() . '/academy' ?>"><?php echo Yii::t('frontend', 'PS Academy'); ?></a></li>
                    </li>
                  </ul>
                </nav></div>

            </div>
          </div>
        </div>
      </header>
      <?php
      $this->registerJs("
                  $('form.searchform').submit(function(event) {
                    //event.preventDefault(); //this will prevent the default submit
                    action = '" . Yii::$app->getUrlManager()->getBaseUrl() . "/search';
                    action += ('/'+this.Video.value);
                    $(this).attr('action',action);
                    $(this).unbind('submit').submit(); // continue the submit unbind preventDefault
                })
                ");
      ?>
