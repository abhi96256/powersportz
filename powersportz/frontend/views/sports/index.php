<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
// $this->registerJsFile('js/jquery.lazy_content.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs(' 
  try{
  ga("send", {
    hitType: "pageview",
    title: "Action",
    location: location.pathname,
  });}catch(e){}
  ', View::POS_READY);
$this->title = Yii::t('frontend', 'Action | Power Sportz');
// $this->params['breadcrumbs'][] = $this->title;
$sportlistvar = '';
$topicId = '';
if (!empty($sportslist)) {
  $sportlistvar .= '<div class="col-md-3" style="padding:0;"><div id="togglebtn">Action</div><ul class="left-menu">';
  $varzero = 0;
  foreach ($sportslist as $key => $sportslistsub) {
    $classvar = '';
    if (Yii::$app->getRequest()->getQueryParam('id')) {

      if (Yii::$app->getRequest()->getQueryParam('id') == $sportslistsub['slug']) {
        $this->title = $sportslistsub['CategName'];
        $slug = $sportslistsub['slug'];
        $classvar = 'class="active parent-active"';
        $topicId = $key;
      }
    } else {
      if ($varzero == 0) {
        $slug = $sportslistsub['slug'];
        $classvar = 'class="active parent-active"';
      }
    }
    if ($varzero == 0) {
      if (!Yii::$app->getRequest()->getQueryParam('id')) {
        $sportlistvar .= '<li ' . $classvar . ' ><a href="' . Yii::$app->getUrlManager()->getBaseUrl() . '/action"><span> All </span></a></li></li>';
        $classvar = '';
      } else {
        $sportlistvar .= '<li><a href="' . Yii::$app->getUrlManager()->getBaseUrl() . '/action"><span> All </span></a></li></li>';
      }
    }
    $sportlistvar .= '<li ' . $classvar . ' ><a href="' . Yii::$app->getUrlManager()->getBaseUrl() . '/action/' . $sportslistsub['slug'] . '"><span>' . $sportslistsub['CategName'] . '</span></a></li></li>';
    $varzero++;
  }
  $sportlistvar .= '</ul></div>';
}
$sportvideolistvar = '';
?>

<?php /*
  if (!empty($searchModel)) {
  $sportvideolistvar.='<div class="col-md-9" style="padding:0;">';//.$sportlistvar;
  foreach ($searchModel as $key => $searchModelsub) {
  $slug = $searchModelsub['Categ_slug'];
  $sportvideolistvar.='<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wr-video  topic-sec  ">
  <div class="video-post v-col-5 video-image-box "><img  src="'. Yii::$app->getUrlManager()->getBaseUrl().'/images/site-lazy.png" data-src="'.ImagesUrl($searchModelsub).'" alt="" class="img-responsive lazyload lazy-hidden" onerror="this.error=false;this.src=\''.Yii::$app->getUrlManager()->getBaseUrl().'/images/placeholder.png\'"/>
  <a href="'.Yii::$app->UrlManager->baseUrl.'/action/'.$slug.'/'.$searchModelsub['slug'].'-'.$searchModelsub['ID'].'">
  <span class="vd-button"></span></a></div>
  <div class="data">
  <p> <a href="'.Yii::$app->UrlManager->baseUrl.'/action/'.$slug.'/'.$searchModelsub['slug'].'-'.$searchModelsub['ID'].'">'.$searchModelsub["Title"].'</a></p>
  <span>28:45</span> </div>

  </div>';
  }
  $sportvideolistvar.='</div>';
  }
  else
  {
  $sportvideolistvar='No Records Found';
  } */
?> 
<div class="col-md-10 single-page">
  <div class="sports-index">
    <?php echo $sportlistvar; ?>
    <div class="col-md-9 topic-sec-wrapper" style="padding:0;">
      <div   class="load-more-wrapper" style="display: none;">
        <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() . '/images/loading.svg' ?>" class="load-more"/>  
      </div>

    </div>
    <?php // echo $sportvideolistvar;   ?>

  </div></div>
<?php
$this->registerJS("
    per_page =12;
    pageIndex = 1; 
    target  = $('.topic-sec-wrapper');
    load_more  =target.find('.load-more-wrapper');
    totalCount = 0; 
    callPage();
    $(window).scroll(function(){
      if ($(window).scrollTop() >= $(document).height() - $(window).height()){
        var loadedData = target.find('.col-lg-4.col-md-4.col-sm-6.col-xs-12.wr-video.topic-sec').length;
        if(loadedData < totalCount && (loadedData > 0))
        {
          pageIndex = pageIndex + 1;
          load_more.show();
          callPage();
        }
      }
    });
    function callPage(){
      url = '" . Url::to(['sports/page-data']) . "';
      data = {
        page:pageIndex,
        TopicId:'" . $topicId . "',
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
            loadedData = target.find('.col-lg-4.col-md-4.col-sm-6.col-xs-12.wr-video.topic-sec').length;
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
