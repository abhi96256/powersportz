<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PlaylistsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Throwback | Power Sportz';
// $this->params['breadcrumbs'][] = $this->title;
//$this->registerJsFile('../js/jquery.lazy_content.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<!--New Video-->
<section class="color-bg home-page-container wow fadeInDown" >
  <div class="col-md-10 main_section playlist-page" >
    <div class="row playlists-sec-wrapper "> 
      <?php
// $playlistvar='';
//           if(!empty($playlistdetails))
//           {
//               foreach($playlistdetails as $playlistdetailssub)
//               {
//                 $playlistvar.='<div class="col-sm-3 col-4 wr-video playlist-sec"> <a href="'.Yii::$app->getUrlManager()->getBaseUrl().'/throwback/'.$playlistdetailssub['slug'].'">
//                             <div class="video-post v-col-5">
//                             <div class="lest-wraper">
//                             <img  src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/site-lazy.png" data-src="'.S3_THUMB_CLOUDFRONT.'/'.PLAYLIST.'/'.THUMBNAILS_THUMB.'/'.$playlistdetailssub['VideoThumb'].'" alt="" class="img-responsive lazyload lazy-hidden" onerror="this.error=false;this.src=\''.Yii::$app->getUrlManager()->getBaseUrl().'/images/placeholder.png\'" />
//                             <div class="list-veiws">
//                             <div class="paylists-total">
//                             <span class="no-of-video-list">'.$playlistdetailssub["NoOfVideos"].'</span>
//                             <h3>Videos</h3></div></div>
//                             </div> </div>
//                              <div class="data">
//                             <h3><span>'.$playlistdetailssub["Title"].'</span></h3>
//                             </div>
//                             </a></div>'; 
//               }
//           }
//           echo $playlistvar;
      ?>
      <div   class="load-more-wrapper" style="display: none;">
        <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() . '/images/loading.svg' ?>" class="load-more"/>  
      </div>
    </div>
  </div>
</section>
<!--End New Video-->  
<?php
$this->registerJS("
   pageIndex = 1; 
   per_page = 16; 
   target  = $('.playlists-sec-wrapper');
   load_more  =target.find('.load-more-wrapper');

   totalCount = 0; 
   callPage();
   $(window).scroll(function(){
    if ($(window).scrollTop() >= $(document).height() - $(window).height()){
      var loadedData = target.find('.col-sm-3.col-4.wr-video.playlist-sec').length;
      if(loadedData < totalCount && (loadedData > 0))
      {
        pageIndex = pageIndex + 1;
        load_more.show();
        callPage();
      }
    }
  });
  function callPage(){
    url = '" . Url::to(['playlists/page-data']) . "';
    data = {
      page:pageIndex,
      'per-page':per_page
    };
    $.ajax({
      url: url,
      data:data,
      success: function(response) {
        totalCount = response.totalCount;
        if(totalCount == 0){
          load_more.before('<p>No Record Found</p>');
          load_more.hide();
        }
        if(response.status==200){
          load_more.before(response.html);
          loadedData = target.find('.col-sm-3.col-4.wr-video.playlist-sec').length;
          if(loadedData >= totalCount && (loadedData > 0))
          {
            load_more.hide();
          }
        }
      }
    });
  } 
  ");
?>
<script type="text/javascript">
  try {
    ga('send', {
      hitType: 'pageview',
      title: 'Playlist',
      location: location.pathname,
    });
  } catch (e) {
  }
</script>