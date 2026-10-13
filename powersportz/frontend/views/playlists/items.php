<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

if(is_array($items) && count($items)){
  foreach ($items as $key => $item) {
   ?>
   <div class="col-sm-3 col-4 wr-video playlist-sec"> 
    <a href="<?= Yii::$app->getUrlManager()->getBaseUrl().'/throwback/'.$item['slug'] ?>">
      <div class="video-post v-col-5">
        <div class="lest-wraper">
          <img  src="<?= Yii::$app->getUrlManager()->getBaseUrl()?>/images/site-lazy.png" data-src="<?= S3_THUMB_CLOUDFRONT.'/'.PLAYLIST.'/'.THUMBNAILS_THUMB.'/'.$item['VideoThumb']?>" alt="" class="img-responsive lazyload lazy-hidden" onerror="this.error=false;this.src='<?= Yii::$app->getUrlManager()->getBaseUrl().'/images/placeholder.png'?>'" />
          <div class="list-veiws">
            <div class="paylists-total">
              <span class="no-of-video-list"><?= $item["NoOfVideos"] ?></span>
              <h3>Videos</h3>
            </div>
          </div>
        </div> 
      </div>
      <div class="data">
        <h3>
          <span><?= $item["Title"] ?></span>
        </h3>
      </div>
    </a>
  </div>
  <?php }
} ?> 