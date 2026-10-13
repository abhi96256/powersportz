<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

if(is_array($items) && count($items)){
  foreach ($items as $key => $item) {
     $slug = $item['Categ_slug'];
    ?>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wr-video  topic-sec  ">
    <div class="video-post v-col-5 video-image-box ">
      <img  src="<?= Yii::$app->getUrlManager()->getBaseUrl()?>/images/site-lazy.png" data-src="<?= ImagesUrl($item) ?>" alt="" class="img-responsive lazyload lazy-hidden" onerror="this.error=false;this.src='<?= Yii::$app->getUrlManager()->getBaseUrl()?>/images/placeholder.png'"> 
      <a href="<?= Yii::$app->UrlManager->baseUrl.'/talking-turkey/'.$slug.'/'.$item['slug'].'-'.$item['ID']?>">
        <span class="vd-button"></span>
      </a>
    </div>
    <div class="data">
      <p> <a href="<?= Yii::$app->UrlManager->baseUrl.'/talking-turkey/'.$slug.'/'.$item['slug'].'-'.$item['ID']?>"><?= $item["Title"]?></a>
      </p>
      
    </div>
  </div>
  <?php }
} ?> 