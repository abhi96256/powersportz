<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\web\View;

$this->registerJsFile(Yii::$app->homeUrl . 'js/endless_scroll_min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
/* @var $this yii\web\View */

$cookies = Yii::$app->request->cookies;
$actiontype = array();
$adurl1 = '';
$adurl2 = '';
$adurl3 = '';
if (!empty($modelMember)) {
  foreach ($modelMember as $modelMemberarray) {
    array_push($actiontype, $modelMemberarray['Type']);
  }
}

//$Videogeographics
//var_dump($Customadvertise);
$HomePageModel->scroll_time = $HomePageModel->scroll_time * 10;

// Ensure detail-page poster/thumb matches homepage (SP ImageName is often empty)
if (!empty($searchModel[0]['ID']) && function_exists('ResolveVideoDisplayThumbnail')) {
  $resolvedThumb = ResolveVideoDisplayThumbnail(
    (int) $searchModel[0]['ID'],
    isset($searchModel[0]['ImageName']) ? $searchModel[0]['ImageName'] : '',
    isset($searchModel[0]['ImageType']) ? $searchModel[0]['ImageType'] : ''
  );
  $searchModel[0]['ImageName'] = $resolvedThumb['ImageName'];
  $searchModel[0]['ImageType'] = $resolvedThumb['ImageType'];
}
$videoPosterUrl = ImagesUrl($searchModel[0]);
?>
<link href="https://vjs.zencdn.net/8.6.0/video-js.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/videojs-ima@2.2.0/dist/videojs.ima.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/8.6.0/video.min.js"></script>
<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-ads@7.3.2/dist/videojs.contrib.ads.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-ima@2.2.0/dist/videojs.ima.min.js"></script>
<div class="col-md-11 single-page"> 
    <!---------Left Sidebar -------->
    <?php
    if (empty($Videogeographics)) {
        $reqquesturi = $_SERVER['REQUEST_URI'];
        $reqquesturi = str_replace('/devpowersport/', '/', $reqquesturi);
        $reqquesturi = ltrim($reqquesturi, '/');
        $this->title = $searchModel[0]['Title'] . ' ';
        $this->params['breadcrumbs'][] = $this->title;
        $newtitle = str_replace(' ', '+', $searchModel[0]['Title']);

        Yii::$app->view->registerMetaTag([
            'name' => 'fb:app_id',
            //'content' => trim($searchModel[0]['description'])
            'content' => '948450055241654'
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:title',
            //'content' => 'Test Title'
            'content' => trim($searchModel[0]['Title']),
            'property' => "og:title",
            'itemprop' => "title name",
            'prefix' => "og: http://ogp.me/ns#"
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:description',
            'content' => trim($searchModel[0]['description']),
            'property' => "og:description",
            'itemprop' => "description",
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:site_name',
            'content' => 'Power Sportz'
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:image',
            'content' => $videoPosterUrl,
            'itemprop' => 'image',
            'property' => 'og:image',
            'prefix' => "og: http://ogp.me/ns#"
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:url',
            'content' => Yii::$app->params['domainName'] . $reqquesturi,
            'property' => 'og:url',
            'itemprop' => 'url',
            'prefix' => "og: http://ogp.me/ns#"
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:type',
            'content' => 'website',
            'property' => 'og:type',
            'prefix' => "og: http://ogp.me/ns#"
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $searchModel[0]['description']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'keyword',
            'content' => $searchModel[0]['MetaKeywords']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'name',
            'content' => $searchModel[0]['Title']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'image',
            'content' => $videoPosterUrl
        ]);

        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:card',
            'content' => 'summary_large_image'
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:site',
            'content' => 'Power Sportz'
        ]);

        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:title',
            'content' => $searchModel[0]['Title']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:url',
            'content' => Yii::$app->params['domainName'] . $reqquesturi
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:description',
            'content' => $searchModel[0]['description']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:image',
            'content' => $videoPosterUrl
        ]);

        $fb = $google = $twiter = $pintrest = $linkden = 0;
        if (strpos($shared_on, '0') !== false) {
            $fb = 1;
        }
        if (strpos($shared_on, '1') !== false) {
            $linkden = 1;
        }
        if (strpos($shared_on, '2') !== false) {
            $twiter = 1;
        }
        if (strpos($shared_on, '3') !== false) {
            $google = 1;
        }
        if (strpos($shared_on, '4') !== false) {
            $pintrest = 1;
        }

        $socialcontentvar = "<ul class='socialiconsul'>";
        $socialcontentvar .= ($fb == 1) ? "<li><a href='javascript:void(0)' id='fbshare' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='http://www.facebook.com/share.php?u=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-facebook' style='background: #3b5998;'></i></a></li>" : '';
        $socialcontentvar .= ($google == 1) ? "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='https://plus.google.com/share?url=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-google-plus'></i></a></li>" : '';
        $socialcontentvar .= ($twiter == 1) ? "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='http://twitter.com/share?text=" . $newtitle . "&url=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-twitter'style='background: #00aced;'></i></a></li>" : '';
        $socialcontentvar .= ($pintrest == 1) ? "<li><a href='#' id='pintrestshare' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='http://pinterest.com/pin/create/bookmarklet/?media=" . ImagesUrl($searchModel[0]) . "&url=" . Yii::$app->params['domainName'] . $reqquesturi . "&description=" . urlencode($searchModel[0]['Title']) . "'><i class='fa fa-pinterest'></i></a></li>" : '';
        $socialcontentvar .= ($linkden == 1) ? "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='http://www.linkedin.com/shareArticle?mini=true&url=" . Yii::$app->params['domainName'] . $reqquesturi . "&title=" . $searchModel[0]['Title'] . "&source=" . urlencode('Power Sportz') . "'><i class='fa fa-linkedin'style='background: #0077B5;'></i></a></li>" : '';
        $socialcontentvar .= "</ul>";
        ?>
        <div class="col-md-7 details-vedio" style="position:relative">
            <div class="overlapdiv">
                <p class="reloadbutton"><a href="#" class="reloadlink"><i class="fa fa-refresh"></i></a></p>
                <p class="showfullvideo"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl() . '/' . $searchModel[0]['FullVideoId'] ?>"><?php echo Yii::t('frontend', 'watchfullvideo') ?></a></p></div>
            <video id="myElement" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="100%" playsinline<?php if ($videoPosterUrl !== '') { echo ' poster="' . Html::encode($videoPosterUrl) . '"'; } ?>></video>
            <?php
            if ($HomePageModel->NewsOrAdd == '1') {
                echo '<div class="breaking-news" style="display:none">
          <div class="breaking-main">
          <div class="breaking-logo"></div>
          <div class="breaking-logo2"></div>
          </div>
          <div class="breaking-color">
          <div id="s1" class="is">';
                foreach ($newsModel as $newsModelarray) {
                    echo '<a href="' . $newsModelarray->LandingLink . '" target="_blank">' . $newsModelarray->Title . '</a>';
                }
                echo '</div></div></div>';
            } else {
                echo ' <div>
          <ul class="rslides" id="slider1">';
                foreach ($Advertise as $Advertisevar) {

                    echo '<li><a href="' . $Advertisevar['LandingLink'] . '" target="_blank"><img class="lazyload lazy-hidden"  src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/site-lazy.png" data-src="' . S3_THUMB_CLOUDFRONT . '/' . ADVERISEMENT . '/' . $Advertisevar['ImagePath'] . '" onerror="this.error=false;this.src=\'' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png\'" /></a></li>';
                }
                echo '</ul></div>';
            }
            ?>
            <?php
//var_dump($Customadvertise);die;
            $adurmidtime = $searchModel[0]['StartMidAdvertisementTime'];
            if (!empty($Customadvertise)) {
                foreach ($Customadvertise as $Customadvertisesub) {
                    $Customadvertisesub['Type'] = $Customadvertisesub['Type_Id'];
                    $customadarraylist[$Customadvertisesub['Type']] = $Customadvertisesub['XML'];
                    $customadarraylist['Time'] = $Customadvertisesub['MidTime'];
                }
                if (array_key_exists("1", $customadarraylist)) {
                    $adurl1 = CustomAdvertisePath() . $customadarraylist['1'] . '.xml';
                } else {
                    //$adurl1= $searchModel[0]['PreAdvertisementTagURL'];
                    $adurl1 = Yii::$app->request->BaseUrl . "/../../backend/web/upload/xml/" . $searchModel[0]['PreXML'] . ".xml";
                }
                if (array_key_exists("2", $customadarraylist)) {
                    $adurl2 = CustomAdvertisePath() . $customadarraylist['2'] . '.xml';
                    $adurmidtime = $customadarraylist['Time'];
                } else {
                    //$adurl2= $searchModel[0]['MidAdvertisementTagURL'];
                    $adurl2 = Yii::$app->request->BaseUrl . "/../../backend/web/upload/xml/" . $searchModel[0]['MidXML'] . ".xml";
                    $adurmidtime = $searchModel[0]['StartMidAdvertisementTime'];
                }
                if (array_key_exists("3", $customadarraylist)) {
                    $adurl3 = CustomAdvertisePath() . $customadarraylist['3'] . '.xml';
                } else {
                    //$adurl3= $searchModel[0]['PostAdvertisementTagURL'];
                    $adurl3 = Yii::$app->request->BaseUrl . "/../../backend/web/upload/xml/" . $searchModel[0]['PostXML'] . ".xml";
                }
            } else {
                /* $result = frontend\models\Common::get_custom_ads($CategID);
                  if(count($result) > 0)
                  {
                  $procedure = 'SELECT * FROM `customadvertisement` WHERE  CustomAdvertiseID = :CustomAdvertiseID AND Status = 1' ;
                  $connection = Yii::$app->db;
                  $command = $connection->createCommand($procedure);
                  $command->bindParam(":CustomAdvertiseID", $result[0]['CustomAdvertiseID']);
                  $Adresult = $command->queryAll();
                  var_dump($Adresult);
                  if(empty($Adresult)){
                  $count = 0;
                  while($count > 0)
                  {   echo 'fsd';
                  $Adresult = frontend\models\Common::get_custom_ads($CategID);
                  $count = count($Adresult);
                  }
                  }
                  if ($Adresult[0]['Type'] == 1){
                  $adurl1= CustomAdvertisePath().$Adresult[0]['XML'].'.xml';

                  }
                  if ($Adresult[0]['Type'] == 2){
                  $adurl2= CustomAdvertisePath().$Adresult[0]['XML'].'.xml';
                  $adurmidtime=$customadarraylist['Time'];
                  }
                  if ($Adresult[0]['Type'] == 3){
                  $adurl3= CustomAdvertisePath().$Adresult[0]['XML'].'.xml';
                  }
                  var_dump($Adresult);
                  echo 'fsd00';die;
                  }
                  else
                  {  } */
                $adurl1 = Yii::$app->request->BaseUrl . "/../../backend/web/upload/xml/" . $searchModel[0]['PreXML'] . ".xml";
                $adurl2 = Yii::$app->request->BaseUrl . "/../../backend/web/upload/xml/" . $searchModel[0]['MidXML'] . ".xml";
                $adurl3 = Yii::$app->request->BaseUrl . "/../../backend/web/upload/xml/" . $searchModel[0]['PostXML'] . ".xml";
            }                  // echo Yii::$app->request->BaseUrl;
            //echo $adurl1;die;

            /* $highResolutionURL = str_replace('mp4_','webm_',$searchModel[0]['VideoStreamURL']);
              $lowResolutionURL = str_replace('mp4_','web180m_',$searchModel[0]['VideoStreamURL']);
              if(!checklowqualityvideo(S3_VIDEO_BUCKETABSOLUTE_PATH.$lowResolutionURL)){
              $lowResolutionURL=$searchModel[0]['VideoStreamURL'];
              }

             * androidhls: true,
             * file:"'.S3_VIDEO_BUCKETABSOLUTE_PATH_AUTO. $searchModel[0]['VideoStreamURL'].'.m3u8",

             *  playlist: [{

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
              type: "mp4"
              },
              {
              file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $lowResolutionURL . '",
              label: "240p",
              default: "true",
              type: "mp4"
              }
              ]
              }], */

            $highResolutionURL = str_replace('mp4_', 'hls1080m_', $searchModel[0]['VideoStreamURL']);
            $highmediumResolutionURL = str_replace('mp4_', 'hls720m_', $searchModel[0]['VideoStreamURL']);
            $mediumResolutionURL = str_replace('mp4_', 'hls480m_', $searchModel[0]['VideoStreamURL']);
            $lowmediumResolutionURL = str_replace('mp4_', 'hls360m_', $searchModel[0]['VideoStreamURL']);
            $lowResolutionURL = str_replace('mp4_', 'hls240m_', $searchModel[0]['VideoStreamURL']);
            // echo $adurl1;die;
            $this->registerJs('
              var checkcookievar=0;
              
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

              var playerInstance = videojs("myElement", {
                controls: true,
                autoplay: false,
                preload: "auto",
                fluid: true,
                poster: "' . addslashes($videoPosterUrl) . '",
                sources: [{
                  src: "' . S3_VIDEO_BUCKETABSOLUTE_PATH_AUTO . $searchModel[0]['VideoStreamURL'] . '.m3u8",
                  type: "application/x-mpegURL"
                }]
              });

              var imaOptions = {
                id: "myElement",
                adsResponse: vmapXML
              };
              playerInstance.ima(imaOptions);
              
              ');
            if ($searchModel[0]['FullVideoId'] != '') {
                $this->registerJs('playerInstance.on("ended", function(){$(".overlapdiv").show();});');
            }

            $this->registerJs('$("#likelink").click(function () {
              var videoid=$(this).data("videoid");
              if($(this).hasClass("videolikelink")){
                var URL="' . Url::toRoute(["video/videolike"]) . '";
                $(this).toggleClass("videolikelink");
                $(this).parent("div").addClass("tab-active");
                $(".liketext").text("' . Yii::t("frontend", "unlike") . '");
              }
              else
              {
                var URL="' . Url::toRoute(["video/videounlike"]) . '";
                $(this).toggleClass("videolikelink");
                $(this).parent("div").removeClass("tab-active");
                $(".liketext").text("' . Yii::t("frontend", "likethisvideo") . '");
              }
              $.ajax({
                type: "POST",
                data: {Videoid:videoid,Type:1},
                url: URL,
                success: function(msg){
                  $(".displynumbr").text(msg);
                }
              });                                       
            });
            $("#watchlink").click(function () {
              var videoid=$(this).data("videoid");
              if($(this).hasClass("videowatchlink")){
                var URL="' . Url::toRoute(["video/videolike"]) . '";
                $(this).toggleClass("videowatchlink");
                $(this).parent("div").addClass("tab-active");
                $(".watchlisttext").text("' . Yii::t("frontend", "removewatchlist") . '");
              }
              else
              {
                var URL="' . Url::toRoute(["video/videounlike"]) . '";
                $(this).toggleClass("videowatchlink");
                $(this).parent("div").removeClass("tab-active");
                $(".watchlisttext").text("' . Yii::t("frontend", "watchlater") . '");
              }
              $.ajax({
                type: "POST",
                data: {Videoid:videoid,Type:3},
                url: URL,
                success: function(msg){
                }
              });
            });

            $("#favlink").click(function () {
              var videoid=$(this).data("videoid");
              if($(this).hasClass("videofavlink")){
                var URL="' . Url::toRoute(["video/videolike"]) . '";
                $(this).toggleClass("videofavlink");
                $(this).parent("div").addClass("tab-active");
                $(".favouritetext").text("' . Yii::t("frontend", "removefavourite") . '");
              }
              else
              {
                var URL="' . Url::toRoute(["video/videounlike"]) . '";
                $(this).toggleClass("videofavlink");
                $(this).parent("div").removeClass("tab-active");
                $(".favouritetext").text("' . Yii::t("frontend", "addtofav") . '");
              }

              $.ajax({
                type: "POST",
                data: {Videoid:videoid,Type:2},
                url: URL,
                success: function(msg){
                }
              });
            });
            $(document).on("click", ".socialsharebutton", function(e) {
              e.preventDefault();
              var videoid=$(this).data("videoid");
              var urlto=$(this).data("url");
              var URL="' . Url::toRoute(["video/videolike"]) . '";
              $.ajax({
                type: "POST",
                data: {Videoid:videoid,Type:4},
                url: URL,
                success: function(msg){
                  var win=window.open(urlto,"_blank","resizable,height=500,width=500");
                  win.focus();
                }
              });
            });
            $("[data-toggle=\'popover\']").popover({
              placement : "bottom",
              container: "body",
              title:"Be Social <span class=\"popupover-close close\">X</span>",
              html : true,
              content:"' . $socialcontentvar . '",
            });
            $(document).on(\'click\',\'.popupover-close\',function(){
              $("[data-toggle=\'popover\']").popover(\'hide\');
            });
            $(".reloadlink").click(function(){
              $(".overlapdiv").hide();
              playerInstance.play();
            });
            ');
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
            if ($cookies->has($searchModel[0]['ID'] . 'cookies')) {
                $varcookies = 1;
            } else {
                $varcookies = 0;
            }
            ?>
            <div class="favourite-icon-wrap">
                <?php
                /*
                  if (in_array('3', $actiontype)) {
                  $watchlistvar = Yii::t('frontend', 'removewatchlist');
                  echo '<div class="watch-later favourite-icon tab-active" title="Remove from Watchlist"><a href="#" id="watchlink" class="videounwatchlink" data-videoid="' . $searchModel[0]["ID"] . '">';
                  } else {
                  if (Yii::$app->getUser()->isGuest) {

                  $watchtourl = Url::toRoute('member/login/1');
                  $watchlistvar = Yii::t('frontend', 'watchlater');
                  echo '<div class="watch-later favourite-icon" title="Add To Watchlist"><a href="' . $watchtourl . '" id="watchlink" class="" data-videoid="' . $searchModel[0]["ID"] . '">';
                  } else {
                  //$tabactive_watch = ($is_watch == 1)?'tab-active':'';
                  $watchlistvar = Yii::t('frontend', 'watchlater');
                  echo '<div class="watch-later favourite-icon " title="Add To Watchlist"><a href="#" id="watchlink" class="videowatchlink" data-videoid="' . $searchModel[0]["ID"] . '">';
                  }
                  }
                  ?>
                  <img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/images/watch-leter.png" alt="<?php echo $watchlistvar; ?>" />
                  <span class="watchlisttext"><?php echo $watchlistvar; ?></span>
                  </a></div>
                  <?php
                  if (in_array('2', $actiontype)) {
                  $favouvar = Yii::t('frontend', 'removefavourite');
                  echo '<div class="favourite favourite-icon tab-active" title="Remove from Favourites">
                  <a href="#" id="favlink" class="videounfavlink" data-videoid="' . $searchModel[0]["ID"] . '">';
                  } else {
                  if (Yii::$app->getUser()->isGuest) {

                  $favtourl = Url::toRoute('member/login/1');
                  echo '<div class="favourite favourite-icon" title="Add to Favourites">
                  <a href="' . $favtourl . '" id="favlink" class="" data-videoid="' . $searchModel[0]["ID"] . '">';
                  } else {
                  //$tabactive = ($is_favourite == 1)?'tab-active':'';
                  echo '<div class="favourite favourite-icon" title="Add to Favourites">
                  <a href="#" id="favlink" class="videofavlink" data-videoid="' . $searchModel[0]["ID"] . '">';
                  }
                  $favouvar = Yii::t('frontend', 'addtofav');
                  }
                  ?>
                  <img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/images/favourite.png" alt="<?php echo $favouvar; ?>" />
                  <span class="favouritetext"><?php echo $favouvar; ?></span></a></div>

                  <?php */
                if (in_array('1', $actiontype)) {
                    $liketextvar = Yii::t('frontend', 'unlike');
                    echo '<div class="like favourite-icon tab-active" title="Unlike"><a href="#" id="likelink" class="videounlikelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                } else {

                    if (!Yii::$app->getUser()->isGuest) {
                        $liketextvar = Yii::t('frontend', 'likethisvideo');
                        echo '<div class="like favourite-icon"  title="Like"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                    } else {
                        if ($varcookies == 0) {
                            $liketextvar = Yii::t('frontend', 'likethisvideo');
                            echo '<div class="like favourite-icon"  title="Like"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                        } else {
                            $liketextvar = Yii::t('frontend', 'unlike');
                            echo '<div class="like favourite-icon tab-active"  title="Unlike"><a href="#" id="likelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                        }
                    }
                }
                ?>
                <img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/images/like.png" alt="<?php echo $liketextvar; ?>" />
                <i class="displynumbr"><?php echo $searchModel[0]['LikeCount']; ?></i>
                <span class="liketext"><?php echo $liketextvar; ?></span>
                </a></div>
            <?php if ($shared_on != '') { ?>
                <div class="share favourite-icon" title="Share Video">
                    <a href="#" id="sharelink" class="videosharelink" data-toggle="popover" data-videoid="<?php echo $searchModel[0]["ID"]; ?>">
                        <img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/images/share-icon.png" alt="<?php echo Yii::t('frontend', 'sharethisvideo'); ?>" />
                        <span><?php echo Yii::t('frontend', 'sharethisvideo'); ?></span>
                    </a></div>
                <?php
            }
            if ($searchModel[0]['AllowDownload'] == '1') {
                echo '<div class="share download favourite-icon" title="Download Video">
  <a href="' . Url::toRoute(['video/downloadvideo', 'videoid' => $searchModel[0]['ID']]) . '"><img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/download.png" alt="' . Yii::t('frontend', 'downlodthisvideo') . '" /><span>' . Yii::t('frontend', 'downlodthisvideo') . '</span>
  </a></div>';
            }
            ?>
        </div>
        <div class="clear"></div>
        <div class=" descraption">
            <h1><?php echo $searchModel[0]['Title']; ?></h1>
            <p><?php echo $searchModel[0]['description']; ?></p>
            <?php
            $publishdate = $searchModel[0]['PublishDate'];
            $publishdate1 = date('d-M-Y', strtotime($publishdate));
            $date = gmdate('d-M-Y H:i:s');
            $currentdate = date('d-M-Y', strtotime($date));
            if (strtotime($currentdate) == strtotime($publishdate1)) {
                $datetime1 = strtotime($publishdate);
                $datetime2 = strtotime($date);
                $interval = abs($datetime1 - $datetime2);
                $minutes = round($interval / 60);

                $hours = floor($minutes / 60);
                $minute = $minutes % 60;
                if ($hours > 0) {
                    $publishdate = $hours . ' Hours and ' . $minute . ' minutes ago';
                } else {
                    $publishdate = $minute . ' minutes ago';
                }
            } else {

                $publishdate = date('d-M-Y', strtotime($publishdate));
            }
            ?>
            <div class="video-information">
                <div class="col-md-6">
                    <h4><?php echo Yii::t('frontend', 'details'); ?></h4>
                    <ul>
                        <li><?php echo Yii::t('frontend', 'Released'); ?> : <?php echo $publishdate; ?></li>
                    </ul>
                </div>
                <?php if (!empty($searchModel[0]['CategName'])) { ?>
                    <div class="col-md-6">
                        <h4><?php echo Yii::t('frontend', 'Categories'); ?></h4>
                        <ul>
                            <li><?php echo $searchModel[0]['CategName']; ?></li>
                        </ul>
                    </div>
                <?php } ?>
            </div> 
            <!--Description-->

        </div>
    </div>
    <?php
//
} else {
    echo '<div class="error-video-msg clearfix">
  <div class="error-video-img"><img src="../images/video-error-img.png" alt="error-img"></div>
  <div class="error-video-text">
  <p>' . Yii::t('frontend', 'VideoNotAvailable') . '</p>
  </div>
  </div>';
}
?>
<div class="col-md-5 related-video"> 
    <?php
    if (!empty($RelatedVideolist)) {
        echo '<h2>' . Yii::t('frontend', 'relatedvideos') . '</h2><div class="row">';
        $placeholderImg = Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png';
        foreach ($RelatedVideolist as $RelatedVideolistsub) {
            $videoData = new frontend\models\Video();
            $videoStream = $videoData->find()->where(['ID' => $RelatedVideolistsub['ID']])->all();
            if (!empty($videoStream[0]['VideoStreamURL'])) {
                $thumbUrl = ImagesUrl($RelatedVideolistsub);
                if (!empty($RelatedVideolistsub['ImageName'])) {
                    $thumbUrl = Main_VideoUrl($thumbUrl);
                }
                if (empty($RelatedVideolistsub['ImageName']) || empty($thumbUrl)) {
                    $thumbUrl = $placeholderImg;
                }
                $videoHref = Yii::$app->getUrlManager()->getBaseUrl() . '/' . $RelatedVideolistsub['slug'] . '-' . $RelatedVideolistsub['ID'];
                echo ' <!--video post-->
        <div class="col-sm-6 col-4 wr-video" >
        <div class="video-post v-col-5 video-image-box">
        <img src="' . htmlspecialchars($thumbUrl, ENT_QUOTES) . '" alt="" class="img-responsive related-thumb" onerror="this.onerror=null;this.src=\'' . $placeholderImg . '\'" />
        <a href="' . $videoHref . '" class="related-play-link" title="' . htmlspecialchars($RelatedVideolistsub['Title'], ENT_QUOTES) . '"><span class="vd-button"></span></a>
        </div>
        <div class="data">
        <h3><span> <a href="' . $videoHref . '">' . $RelatedVideolistsub['Title'] . '</a></span></h3>
        </div></div>
        <!--video post-->';
            }
        }
        echo '</div>';
    }
    ?>
</div>   
</div>  
<!-- Description -->

<script type="text/javascript">
    var videoCategoryName = '<?php echo (!empty($Category_Detail["CategName"])) ? $Category_Detail["CategName"] : ""; ?>';
    if (videoCategoryName != '') {
        try {
            ga('send', {
                hitType: 'event',
                eventCategory: '<?= ($Category_Detail["Type"] == 2) ? "Topics" : "Category"; ?>',
                eventAction: videoCategoryName,
                eventLabel: '<?= $searchModel[0]["Title"]; ?>'
            });
        } catch (e) {
            console.log(e);
        }
    }
</script>
<?php
$this->registerJS("
  $(document).ready(function() {
    $.ajax({
      url: '" . Yii::$app->request->baseUrl . "/site/callthumb',
      type: 'post',
      success: function (data) {

      }
    });

  });

  ");
?>
