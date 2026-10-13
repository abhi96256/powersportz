<?php

use yii\helpers\Url;

$this->registerJsFile(Yii::$app->homeUrl . 'js/endless_scroll_min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
$this->title = Yii::t('frontend', 'PowerSportz TV | Live streaming, Talking Turkey and Schedule of Sports') . ' ';
$notinarray = array();
$notincategory = array();
$adurl1 = '';
$adurl2 = '';
$adurl3 = '';
if ($HomePageModel->MainVideoType == '1') {
  array_push($notinarray, $HomePageModel->VideoID);
}
if (!empty($Categorygeographics)) {
  foreach ($Categorygeographics as $Categorygeographicsarray) {
    if (!empty($Categorygeographicsarray)) {
      array_push($notincategory, $Categorygeographicsarray['CategID']);
    }
  }
}
$HomePageModel->scroll_time = $HomePageModel->scroll_time * 10;
?>
<link href="https://vjs.zencdn.net/8.6.0/video-js.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/videojs-ima@2.2.0/dist/videojs.ima.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/8.6.0/video.min.js"></script>
<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-ads@7.3.2/dist/videojs.contrib.ads.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-ima@2.2.0/dist/videojs.ima.min.js"></script>
<div class="site-index no_main_video">
  <?php
  $useTopSlider = !empty($TopSectionItems) && is_array($TopSectionItems);
  echo '<div class="home-page-container wow fadeInDown">
  <div class="row video_sticky">
  <div class="' . ($useTopSlider ? 'col-md-12 my-slider has-top-slider' : 'col-md-6 my-slider') . '">';
  if ($useTopSlider) {
    echo $this->render('_home_top_slider', ['TopSectionItems' => $TopSectionItems]);
  } elseif ((empty($Videogeographics) && $HomePageModel->MainVideoType == '1') || (empty($Homepagegeographic) && $HomePageModel->MainVideoType == '2')) {
    if (!empty(trim($HomePageModel->TagMessage))) {
      echo '<div class="ad-content"><p>' . $HomePageModel->TagMessage . '</p></div>';
    }
    echo '<video id="containerForShortVideo" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="100%" playsinline></video>';
  } else {
    echo '<div class="error-video-imgideo-msg clearfix" style="width:100%">
    <div class="error-video-img"><img src="../images/video-error-img.png" alt="error-img"></div>
    <div class="error-video-text">
    <p>' . Yii::t('frontend', 'VideoNotAvailable') . '</p>
    </div>
    </div>
    ';
  }

  if (!empty($VideoDetails)) {
    $reqquesturi = $_SERVER['REQUEST_URI'];
    $reqquesturi = str_replace('/devpowersport/', '/', $reqquesturi);
    $reqquesturi = ltrim($reqquesturi, '/');
    $newtitle = str_replace(' ', '+', $VideoDetails[0]['Title']);

    Yii::$app->view->registerMetaTag([
      'name' => 'fb:app_id',
        //'content' => trim($VideoDetails[0]['description'])
      'content' => '948450055241654'
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'og:title',
        //'content' => 'Test Title'
      'content' => trim($VideoDetails[0]['Title']),
      'property' => "og:title",
      'itemprop' => "title name"
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'og:title',
        //'content' => 'Test Title'
      'content' => trim($VideoDetails[0]['Title']),
      'property' => "og:title",
      'itemprop' => "title name"
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'og:description',
      'content' => trim($VideoDetails[0]['description']),
      'property' => "og:description",
      'itemprop' => "description"
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'og:site_name',
      'content' => 'Power Sportz'
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'og:image',
      'content' => ImagesUrl($VideoDetails[0], TRUE),
      'itemprop' => 'image',
        //'property' => 'og:image',
      'og:image:width' => 640,
      'og:image:height' => 360
    ]);
    Yii::$app->view->registerMetaTag([
        //'name' => 'og:image',
      'content' => ImagesUrl($VideoDetails[0], TRUE),
        // 'itemprop' => 'image',
      'property' => 'og:image',
      'og:image:width' => 640,
      'og:image:height' => 360
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'og:url',
      'content' => Yii::$app->params['domainName'] . $reqquesturi,
      'property' => 'og:url',
      'itemprop' => 'url',
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'og:type',
      'content' => 'website'
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'description',
      'content' => $VideoDetails[0]['description']
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'keyword',
      'content' => $VideoDetails[0]['MetaKeywords']
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'name',
      'content' => $VideoDetails[0]['Title']
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'image',
      'content' => ImagesUrl($VideoDetails[0], TRUE)
    ]);

    Yii::$app->view->registerMetaTag([
      'name' => 'twitter:card',
//          'content' => 'player'
      'content' => 'summary_large_image'
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'twitter:site',
      'content' => 'Power Sportz'
    ]);

    Yii::$app->view->registerMetaTag([
      'name' => 'twitter:title',
      'content' => $VideoDetails[0]['Title']
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'twitter:url',
      'content' => Yii::$app->params['domainName'] . $reqquesturi,
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'twitter:description',
      'content' => $VideoDetails[0]['description']
    ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'twitter:image',
      'content' => ImagesUrl($VideoDetails[0], TRUE)
    ]);

    if (!$useTopSlider && empty($Videogeographics)) {
      $adurmidtime = $VideoDetails[0]['StartMidAdvertisementTime'];
      if(is_array($homepageadv) && count($homepageadv)){
        if(array_key_exists('0',$homepageadv)){
          $adurl1 = CustomAdvertisePath() . $homepageadv['0']['XML'] . '.xml';
          $adurl2 = CustomAdvertisePath() . $homepageadv['0']['XML'] . '.xml';
          $adurl3 = CustomAdvertisePath() . $homepageadv['0']['XML'] . '.xml';
          unset($homepageadv['0']);
        }  

        foreach ($homepageadv as $key => $value) {
         $var = 'adurl'.$key;
         $$var = CustomAdvertisePath() . $value['XML'] . '.xml';
         $adurl.$key = CustomAdvertisePath() . $value['XML'] . '.xml';
       }
     }
     if (!empty($Customadvertise)) {


       foreach ($Customadvertise as $Customadvertisesub) {
         if($Customadvertisesub['isAll'] != 1 && $Customadvertisesub['IsHomePage'] != 1){
           if(array_key_exists($Customadvertisesub['Type_Id'],$homepageadv)){
            $Customadvertisesub = $homepageadv[$Customadvertisesub['Type_Id']];
          }
        }
        $Customadvertisesub['Type'] = $Customadvertisesub['Type_Id'];
        $customadarraylist[$Customadvertisesub['Type']] = $Customadvertisesub['XML'];
        $customadarraylist['Time'] = $Customadvertisesub['MidTime'];
      }
      if (array_key_exists("1", $customadarraylist)) {
        $adurl1 = CustomAdvertisePath() . $customadarraylist['1'] . '.xml';
          //echo $adurl1;
      } else {
        $adurl1 = S3_THUMB_CLOUDFRONT . "/xml/" . $VideoDetails[0]['PreXML'] . ".xml";
      }
      if (array_key_exists("2", $customadarraylist)) {
        $adurl2 = CustomAdvertisePath() . $customadarraylist['2'] . '.xml';
        $adurmidtime = $customadarraylist['Time'];
      } else {
        $adurl2 = S3_THUMB_CLOUDFRONT . "/xml/" . $VideoDetails[0]['MidXML'] . ".xml";

        $adurmidtime = $VideoDetails[0]['StartMidAdvertisementTime'];
      }
      if (array_key_exists("3", $customadarraylist)) {
        $adurl3 = CustomAdvertisePath() . $customadarraylist['3'] . '.xml';
      } else {
        $adurl3 = S3_THUMB_CLOUDFRONT . "/xml/" . $VideoDetails[0]['PostXML'] . ".xml";
      }
      if (array_key_exists("0", $customadarraylist)) {
        $adurl1 = CustomAdvertisePath() . $customadarraylist['0'] . '.xml';
        $adurl2 = CustomAdvertisePath() . $customadarraylist['0'] . '.xml';
        $adurl3 = CustomAdvertisePath() . $customadarraylist['0'] . '.xml';
        $adurmidtime = $customadarraylist['Time'];
      }
    } else {
      $customadarraylist = array();
      $adurl1 = S3_THUMB_CLOUDFRONT . "/xml/" . $VideoDetails[0]['PreXML'] . ".xml";
      $adurl2 = S3_THUMB_CLOUDFRONT . "/xml/" . $VideoDetails[0]['MidXML'] . ".xml";
      $adurl3 = S3_THUMB_CLOUDFRONT . "/xml/" . $VideoDetails[0]['PostXML'] . ".xml";
    }

    $highResolutionURL = str_replace('mp4_', 'hls1080m_', $VideoDetails[0]['VideoStreamURL']);
    $highmediumResolutionURL = str_replace('mp4_', 'hls720m_', $VideoDetails[0]['VideoStreamURL']);
    $mediumResolutionURL = str_replace('mp4_', 'hls480m_', $VideoDetails[0]['VideoStreamURL']);
    $lowmediumResolutionURL = str_replace('mp4_', 'hls360m_', $VideoDetails[0]['VideoStreamURL']);
    $lowResolutionURL = str_replace('mp4_', 'hls240m_', $VideoDetails[0]['VideoStreamURL']);
      /*
        sources: [
        {
        file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $highResolutionURL . '",
        label: "1080p",
        type: "mp4"
        },
        {
        file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $highmediumResolutionURL . '",
        label: "720p",
        type: "mp4"
        },
        {
        file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $mediumResolutionURL . '",
        label: "480p",
        type: "mp4"
        },
        {
        file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $lowmediumResolutionURL . '",
        label: "360p",
        default: "true",
        type: "mp4"
        },
        {
        file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $lowResolutionURL . '",
        label: "240p",
        type: "mp4"
        }
        ],
       */
        $this->registerJs('
          var vmapXML = \'<vmap:VMAP xmlns:vmap="http://www.iab.net/videosuite/vmap" version="1.0">\' +
            \'<vmap:AdBreak timeOffset="start" breakType="linear" breakId="pre">\' +
              \'<vmap:AdSource id="pre-ad" allowMultipleAds="false" followRedirects="true">\' +
                \'<vmap:AdTagURI templateType="vast3"><![CDATA[' . $adurl1 . ']]></vmap:AdTagURI>\' +
              \'</vmap:AdSource>\' +
            \'</vmap:AdBreak>\' +
            \'<vmap:AdBreak timeOffset="' . $adurmidtime . '" breakType="linear" breakId="mid">\' +
              \'<vmap:AdSource id="mid-ad" allowMultipleAds="false" followRedirects="true">\' +
                \'<vmap:AdTagURI templateType="vast3"><![CDATA[' . $adurl2 . ']]></vmap:AdTagURI>\' +
              \'</vmap:AdSource>\' +
            \'</vmap:AdBreak>\' +
            \'<vmap:AdBreak timeOffset="end" breakType="linear" breakId="post">\' +
              \'<vmap:AdSource id="post-ad" allowMultipleAds="false" followRedirects="true">\' +
                \'<vmap:AdTagURI templateType="vast3"><![CDATA[' . $adurl3 . ']]></vmap:AdTagURI>\' +
              \'</vmap:AdSource>\' +
            \'</vmap:AdBreak>\' +
          \'</vmap:VMAP>\';

          var playerInstance = videojs("containerForShortVideo", {
            controls: true,
            autoplay: false,
            preload: "auto",
            fluid: true,
            poster: "' . Main_VideoUrl(ImagesUrl($VideoDetails[0])) . '",
            sources: [{
              src: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $VideoDetails[0]['VideoStreamURL'] . '.m3u8",
              type: "application/x-mpegURL"
            }]
          });

          var imaOptions = {
            id: "containerForShortVideo",
            adsResponse: vmapXML
          };
          playerInstance.ima(imaOptions);
          ');
      }
    } elseif (!$useTopSlider) {
      if (empty($Homepagegeographic)) {
        $adurmidtime = '';
        if(is_array($homepageadv) && count($homepageadv)){
          if(array_key_exists('0',$homepageadv)){
            $adurl1 = CustomAdvertisePath() . $homepageadv['0']['XML'] . '.xml';
            $adurl2 = CustomAdvertisePath() . $homepageadv['0']['XML'] . '.xml';
            $adurl3 = CustomAdvertisePath() . $homepageadv['0']['XML'] . '.xml';
            unset($homepageadv['0']);
          }  
          foreach ($homepageadv as $key => $value) {
           $var = 'adurl'.$key;
           $$var = CustomAdvertisePath() . $value['XML'] . '.xml';
         }
       }

       if (!empty($Customadvertise)) {
        foreach ($Customadvertise as $Customadvertisesub) {
          if($Customadvertisesub['isAll'] != 1 && $Customadvertisesub['IsHomePage'] != 1){
           if(array_key_exists($Customadvertisesub['Type_Id'],$homepageadv)){
            $Customadvertisesub = $homepageadv[$Customadvertisesub['Type_Id']];
          }
        }

        $Customadvertisesub['Type'] = $Customadvertisesub['Type_Id'];
        $customadarraylist[$Customadvertisesub['Type']] = $Customadvertisesub['XML'];
        $customadarraylist['Time'] = $Customadvertisesub['MidTime'];
      }

      if (array_key_exists("1", $customadarraylist)) {
        $adurl1 = CustomAdvertisePath() . $customadarraylist['1'] . '.xml';
          //echo $adurl1;
      }
      if (array_key_exists("2", $customadarraylist)) {
        $adurl2 = CustomAdvertisePath() . $customadarraylist['2'] . '.xml';
        $adurmidtime = $customadarraylist['Time'];
      }
      if (array_key_exists("3", $customadarraylist)) {
        $adurl3 = CustomAdvertisePath() . $customadarraylist['3'] . '.xml';
      }
      if (array_key_exists("0", $customadarraylist)) {
        $adurl1 = CustomAdvertisePath() . $customadarraylist['0'] . '.xml';
        $adurl2 = CustomAdvertisePath() . $customadarraylist['0'] . '.xml';
        $adurl3 = CustomAdvertisePath() . $customadarraylist['0'] . '.xml';
        $adurmidtime = $customadarraylist['Time'];
      }
    }

    $this->registerJs('
      var vmapXML = \'<vmap:VMAP xmlns:vmap="http://www.iab.net/videosuite/vmap" version="1.0">\' +
        \'<vmap:AdBreak timeOffset="start" breakType="linear" breakId="pre">\' +
          \'<vmap:AdSource id="pre-ad" allowMultipleAds="false" followRedirects="true">\' +
            \'<vmap:AdTagURI templateType="vast3"><![CDATA[' . $adurl1 . ']]></vmap:AdTagURI>\' +
          \'</vmap:AdSource>\' +
        \'</vmap:AdBreak>\' +
        \'<vmap:AdBreak timeOffset="' . $adurmidtime . '" breakType="linear" breakId="mid">\' +
          \'<vmap:AdSource id="mid-ad" allowMultipleAds="false" followRedirects="true">\' +
            \'<vmap:AdTagURI templateType="vast3"><![CDATA[' . $adurl2 . ']]></vmap:AdTagURI>\' +
          \'</vmap:AdSource>\' +
        \'</vmap:AdBreak>\' +
        \'<vmap:AdBreak timeOffset="end" breakType="linear" breakId="post">\' +
          \'<vmap:AdSource id="post-ad" allowMultipleAds="false" followRedirects="true">\' +
            \'<vmap:AdTagURI templateType="vast3"><![CDATA[' . $adurl3 . ']]></vmap:AdTagURI>\' +
          \'</vmap:AdSource>\' +
        \'</vmap:AdBreak>\' +
      \'</vmap:VMAP>\';

      var playerInstance = videojs("containerForShortVideo", {
        controls: true,
        autoplay: false,
        preload: "auto",
        fluid: true,
        poster: "'.S3_THUMB_CLOUDFRONT . '/' . THUMBNAILS . '/'. $HomePageModel->ExternalVideoThumb.'",
        sources: [{
          src: "' . $HomePageModel->ExternalVideoURL . '",
          type: "application/x-mpegURL"
        }]
      });

      var imaOptions = {
        id: "containerForShortVideo",
        adsResponse: vmapXML
      };
      playerInstance.ima(imaOptions);
      
      playerInstance.on("ads-ad-started", function(event){
        console.log(event);
      });
      ');
  }
}
$this->registerJs('
 $(".owl-theme").css("display", "block");
 $(".displaynonecls").css("display", "block");
 $(".breaking-news").css("display", "block");
 $("#slider1").responsiveSlides({
  speed:' . $HomePageModel->scroll_time . '
});
$("#s1").endlessScroll({ 
  width: "100%",
  height:"45px",
  steps: -2, speed:' . $HomePageModel->scroll_time . ', 
  mousestop: true });');
$this->registerCss('
  .is a::after
  {
    padding-left:20px;
    content:"|";
    padding-right:20px;
    color: #ffea00;
  }');
if (!empty($AccompanyingVideo)) {
  echo '<ul class="home-video-section">';
  foreach ($AccompanyingVideo as $AccompanyingVideovar) {
    array_push($notinarray, $AccompanyingVideovar['ID']);
    echo '<li><img  src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/site-lazy.png" data-src="' . S3_VIDEO_BUCKETABSOLUTE_PATH . $AccompanyingVideovar['ImageName'] . '" alt="" class="img-responsive lazyload lazy-hidden" onerror="this.error=false;this.src=\'' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png\'" />'
    . '<a href="' . Yii::$app->getUrlManager()->getBaseUrl() . '/' . $AccompanyingVideovar['slug'] . '-' . $AccompanyingVideovar['ID'] . '"><span class="home-video-vd-button"></span></a></li>';
  }
  echo '</ul>';
}
echo '</div></div>';
?>
<section class="color-bg wow fadeInDown">
  <div class="col-md-10 main_section">
    <?php
    if ($HomePageModel->NewsOrAdd == '1') {
      echo '<div class="breaking-news" style="display:none">
      <div class="breaking-main">
      <div class="breaking-logo"></div>
      <div class="breaking-logo2"></div>
      </div>
      <div class="breaking-color">
      <div id="s1" class="is">';
        //<ul id="demo">';
      foreach ($newsModel as $newsModelarray) {
        echo ' <a href="' . $newsModelarray->LandingLink . '" target="_blank">' . $newsModelarray->Title . '</a>';
      }
      echo '</div>';
//<div id="s1" class="is">
      echo '</div>';
//</div></div>
    } else {
      echo ' <div>
      <ul class="rslides" id="slider1">';
      foreach ($Advertise as $Advertisevar) {

        echo '<li><a href="' . $Advertisevar['LandingLink'] . '" target="_blank"><img  src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/site-lazy.png" data-src="' . S3_THUMB_CLOUDFRONT . '/' . ADVERISEMENT . '/' . $Advertisevar['ImagePath'] . '" class="lazyload lazy-hidden" onerror="this.error=false;this.src=\'' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png\'" /></a></li>';
      }
      echo '</ul></div>';
    }
    ?>

    <?php
    $video = '';
    $firstvar = 1;
    $Categorycount = count($Categories);
    foreach ($Categories as $key => $Categoriesary) {
      $subCategorycount = count($Categoriesary);
      $idarray = $this->context->array_value_recursive('ID', $Categories);
      if (is_array($idarray)) {
        $result = array_diff($idarray, $notinarray);
      } else {
        $result = array();
      }
      if (!in_array($Categoriesary[0]['CategoryID'], $notincategory)) {
        $firstvartext = $this->context->convert_number($firstvar);
        $ismobile = $this->context->isMobileDevice();
        if ($ismobile) {
          $numbervar = 1;
        } else {
          $numbervar = 4;
        }
        if (!empty($result)) {
          echo '<div class="col-sm-12 category_heading displaynonecls" style="display:none"><h3>' . $key . '</h3></div><div class="carousel-wraper">';
        }
        if ($subCategorycount > $numbervar) {
          echo '<span class="prev prev' . $firstvar . '"></span>
          <span class="next next' . $firstvar . '"></span>';
        }
        echo '<div id="' . $firstvartext . '-carousel" class="owl-carousel owl-theme" style="opacity: 1; display: none;">'
        . '';
        foreach ($Categoriesary as $subCategoriesary) {
          if (!in_array($subCategoriesary['ID'], $notinarray)) {
            $videoData = new frontend\models\Video();
            $videoStream = $videoData->find()->where(['ID' => $subCategoriesary['ID']])->all();
            if (!empty($videoStream[0]['VideoStreamURL'])) {
                //OLD URL = Yii::$app->UrlManager->createUrl(['video/index','id'=>$subCategoriesary['ID'],'CategoryID'=>$subCategoriesary['CategoryID']])
              echo '<div class="item"> 
              <div class="wr-video">
              <div class="video-post v-col-5 video-image-box">
              <img height="220px" width="340px"  src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/site-lazy.png" data-src="' . ImagesUrl($subCategoriesary) . '" alt="" class="img-responsive lazyload lazy-hidden" onerror="this.error=false;this.src=\'' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png\'" />
              <a href="' . Yii::$app->getUrlManager()->getBaseUrl() . '/' . $subCategoriesary['Categ_slug'] . '/' . $subCategoriesary['slug'] . '-' . $subCategoriesary['ID'] . '">
              <span class="vd-button"></span></a></div>
              <div class="data">
              <p><a href="' . Yii::$app->getUrlManager()->getBaseUrl() . '/' . $subCategoriesary['Categ_slug'] . '/' . $subCategoriesary['slug'] . '-' . $subCategoriesary['ID'] . '">' . $subCategoriesary['Title'] . '</a></p></div></div></div>
              ';
            }
          }
        }
        echo '</div></div>'
        . '';
        $firstvar++;
      }
    }
    ?>
  </section>
  <!--New Video-->
</div>
<script type="text/javascript">
  try {
    ga('send', {
      hitType: 'pageview',
      title: 'HomePage',
      location: location.pathname,
    });
  } catch (e) {
    console.log(e);
  }
</script>
<?php
$this->registerJS("
  $( document ).ready(function() {

   $('#containerForShortVideo').keyup(function(e){
    if(e.keyCode == 32){
      $('.ad-content').css('display','none');
    }    
  });

  $('#containerForShortVideo').click(function(){
    $('.ad-content').css('display','none');                
    /*var isPlay = $('#containerForShortVideo').hasClass('jw-state-playing');
    if(isPlay){
      $('.ad-content').css('display','none');
    }else{
      $('.ad-content').css('display','none');
    }*/

  });

  $.ajax({
    url: '" . Yii::$app->request->baseUrl . "/site/callthumb',
    type: 'post',
    success: function (data) {

    }
  });
});
/**
    * LIVETV_PREROLL_START
    * LIVETV_PREROLL_END
    * LIVETV_VIDEO_START
    * LIVETV_VIDEO_START
    * LIVETV_VIDEO_RESTART
    * LIVETV_BREAKAD_START
    * LIVETV_BREAK_START 
    * LIVETV_WAIT_END
    * LIVETV_WAIT_START
    * beforePlay adPlay adComplete adSkipped
    **/
play = false;
if (document.getElementById('containerForShortVideo') && typeof videojs !== 'undefined') {
videojs(\"containerForShortVideo\").on([\"play\", \"ads-ad-started\", \"ads-request\", \"ads-ad-ended\"], function(e) {
  event = new Array();

  console.log(e);
  switch(e.type){
    case \"play\" :
    if(!play){
      event.push(\"LIVETV_VIDEO_START\");
      play = true;
    }else{
      event.push(\"LIVETV_VIDEO_RESTART\");
    }
    break;
    case \"ads-request\": 
    event.push(\"LIVETV_BREAK_START\");
    break;
    case \"ads-ad-started\":
    event.push(\"LIVETV_BREAKAD_START\");
    break;
    case \"ads-ad-ended\":
    event.push(\"LIVETV_BREAKAD_END\");
    break;
  }
  for(i in event){
    console.log(event[i]);
    if(typeof gtag !== \"undefined\") {
      gtag(\"event\", event[i], {
        \"event_callback\": function(a) {
          console.log(a);
        }
      });
    }
  }
});
}
");


