<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PlaylistsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile(Yii::$app->homeUrl . 'js/endless_scroll_min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$cookies = Yii::$app->request->cookies;
$actiontype = array();
$reqquesturi = $_SERVER['REQUEST_URI'];
$reqquesturi = str_replace('/devpowersport/', '/', $reqquesturi);
$reqquesturi = ltrim($reqquesturi, '/');
$adurl1 = '';
$adurl2 = '';
$adurl3 = '';
if (!empty($modelMember)) {
    foreach ($modelMember as $modelMemberarray) {
        array_push($actiontype, $modelMemberarray['Type']);
    }
}
$HomePageModel->scroll_time = $HomePageModel->scroll_time * 10;
//var_dump($Playlistgeographics);
$this->registerJs('function sortUsingNestedText(parent, childSelector, keySelector, dir) {
    var items = parent.children(childSelector).sort(function (a, b) {
        var vA = $(keySelector, a).data("index");
        var vB = $(keySelector, b).data("index");
        if (dir == "up") return (vA < vB) ? -1 : (vA > vB) ? 1 : 0;
            else return (vA > vB) ? -1 : (vA < vB) ? 1 : 0;
            });
            parent.append(items);
        }
        /* setup sort attributes */
        $("#sDiv").data("sortKey", "span.div");
        /* sort on button click */
        var checkcookievar=0;
        $("#sDiv").click(function () {
           var asc = $(this).attr("asc") == "up" ? "down" : "up";
           $(this).attr("asc", asc);
           sortUsingNestedText($("#sortThis"), "div", $(this).data("sortKey"), asc);
           if(asc=="up")
           {
            $("#sorticonid").attr("class","fa fa-sort-desc");
        }
        else
        {
           $("#sorticonid").attr("class","fa fa-sort-asc");
       }
   });
   $("#likelink").click(function () {
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
    .is a
    {
        padding-left:60px;
    }');
?>
<link href="https://vjs.zencdn.net/8.6.0/video-js.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/videojs-ima@2.2.0/dist/videojs.ima.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/8.6.0/video.min.js"></script>
<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-ads@7.3.2/dist/videojs.contrib.ads.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-ima@2.2.0/dist/videojs.ima.min.js"></script>
<?php
$this->title = $searchModel[0]['PlayListTitle'] . ' | Power Sportz';
// $this->params['breadcrumbs'][] = $this->title;
$mainvideovar = '';
$idarray = array();
$Rightcoloumnvar = '';
$displayindexvar = count($searchModel);
$videoincrementvar = 0;
foreach ($searchModel as $key => $searchModelsub1) {
    array_push($idarray, $searchModelsub1['ID']);
}
foreach ($searchModel as $key => $searchModelsub) {
    $key1 = $key + 1;
    $ismainvar = '0';
    if (Yii::$app->getRequest()->getQueryParam('video')) {
        $videoid = Yii::$app->getRequest()->getQueryParam('video');
        $dbvideoid = $searchModel[$key]['slug'] . '-' . $searchModel[$key]['ID'];

        if ($videoid == $dbvideoid) {
            $this->title = $searchModelsub['Title'];
            if (empty($Videogeographics)) {
                if ($cookies->has($videoid . 'cookies')) {
                    $varcookies = 1;
                } else {
                    $varcookies = 0;
                }
                $adurmidtime = $searchModelsub['StartMidAdvertisementTime'];
                $VideoID = $searchModelsub['ID'];
                $playListID = $searchModel[0]['PlaylistId'];
                if (!empty($Customadvertise)) {
                    $customPlaylist = frontend\models\Customadplaylist::find()->where(['CustomAdvertiseID' => $Customadvertise[0]['CustomAdvertiseID'], 'PlaylistID' => $playListID, 'IsDelete' => 0])->all();
                    foreach ($Customadvertise as $Customadvertisesub) {
                        $Customadvertisesub['Type'] = $Customadvertisesub['Type_Id'];
                        $customadarraylist[$Customadvertisesub['Type']] = $Customadvertisesub['XML'];
                        $customadarraylist['Time'] = $Customadvertisesub['MidTime'];
                    }
                    $isAll = $Customadvertise[0]['IsAll'];
                    if (count($customPlaylist) > 0 || $isAll == 1) {
                        if (array_key_exists("1", $customadarraylist)) {
                            $adurl1 = CustomAdvertisePath() . $customadarraylist['1'] . '.xml';
                        } else {
                            //$adurl1= $searchModel[0]['PreAdvertisementTagURL'];
                            $adurl1 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModelsub['PreXML'] . ".xml";
                        }
                        if (array_key_exists("2", $customadarraylist)) {

                            $adurl2 = CustomAdvertisePath() . $customadarraylist['2'] . '.xml';
                            $adurmidtime = $customadarraylist['Time'];
                        } else {
                            //$adurl1= $searchModel[0]['PreAdvertisementTagURL'];
                            $adurl2 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModelsub['MidXML'] . ".xml";
                        }
                        if (array_key_exists("3", $customadarraylist)) {
                            $adurl3 = CustomAdvertisePath() . $customadarraylist['3'] . '.xml';
                        } else {
                            //$adurl1= $searchModel[0]['PreAdvertisementTagURL'];
                            $adurl3 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModelsub['PostXML'] . ".xml";
                        }
                    } else {

                        if ($isAll == 2) {
                            $isAd = backend\models\Customadvideo::find()->where(['VideoID' => $VideoID, 'IsDelete' => 0])->all();
                            if (count($isAd) > 0) {
                                if (array_key_exists("1", $customadarraylist)) {
                                    $adurl1 = CustomAdvertisePath() . $customadarraylist['1'] . '.xml';
                                }
                                if (array_key_exists("2", $customadarraylist)) {
                                    $adurl2 = CustomAdvertisePath() . $customadarraylist['2'] . '.xml';
                                    $adurmidtime = $customadarraylist['Time'];
                                }
                                if (array_key_exists("3", $customadarraylist)) {
                                    $adurl3 = CustomAdvertisePath() . $customadarraylist['3'] . '.xml';
                                }
                            } else {
                                $adurl1 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModelsub['PreXML'] . ".xml";
                                $adurl2 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModelsub['MidXML'] . ".xml";
                                $adurl3 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModelsub['PostXML'] . ".xml";
                            }
                        }
                    }
                } else {

                    $adurl1 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModelsub['PreXML'] . ".xml";
                    $adurl2 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModelsub['MidXML'] . ".xml";
                    $adurl3 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModelsub['PostXML'] . ".xml";
                }

                //  print_r($searchModelsub);
                Yii::$app->view->registerMetaTag([
                    'name' => 'fb:app_id',
                    //'content' => trim($searchModelsub['description'])
                    'content' => '948450055241654'
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'og:title',
                    //'content' => 'Test Title'
                    'content' => trim($searchModelsub['Title']),
                    'property' => "og:title",
                    'itemprop' => "title name",
                    'prefix' => "og: http://ogp.me/ns#"
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'og:description',
                    'content' => trim($searchModelsub['Description']),
                    'property' => "og:description",
                    'itemprop' => "description",
                ]);


                Yii::$app->view->registerMetaTag([
                    'name' => 'og:site_name',
                    'content' => 'Power Sportz'
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'og:image',
                    'content' => ImagesUrl($searchModelsub, TRUE),
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
                    'content' => $searchModelsub['Description']
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'keyword',
                    'content' => $searchModelsub['MetaKeywords']
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'name',
                    'content' => $searchModelsub['Title']
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'image',
                    'content' => ImagesUrl($searchModelsub, TRUE)
                ]);

                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:card',
//                    'content' => 'player',
                    'content' => 'summary_large_image'
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:site',
                    'content' => 'Power Sportz'
                ]);

                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:title',
                    'content' => $searchModelsub['Title']
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:url',
                    'content' => S3_VIDEO_BUCKETABSOLUTE_PATH_AUTO . $searchModelsub['VideoStreamURL'] . ".m3u8"
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:description',
                    'content' => $searchModelsub['Description']
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:image',
                    'content' => ImagesUrl($searchModelsub, TRUE)
                ]);
                $newtitle = str_replace(' ', '+', $searchModelsub['Title']);
                $socialcontentvar = "<ul class='socialiconsul'>"
                  . "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModelsub['ID'] . "' data-url='http://www.facebook.com/share.php?u=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-facebook'></i></a></li>"
                  . "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModelsub['ID'] . "' data-url='https://plus.google.com/share?url=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-google-plus'></i></a></li>"
                  . "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModelsub['ID'] . "' data-url='http://twitter.com/share?text=" . $newtitle . "&url=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-twitter'></i></a></li>"
                  . "<li><a href='#' id='pintrestshare' class='socialsharebutton' data-videoid='" . $searchModelsub['ID'] . "' data-url='http://pinterest.com/pin/create/bookmarklet/?media=" . ImagesUrl($searchModelsub) . "&url=" . Yii::$app->params['domainName'] . $reqquesturi . "&description=" . urlencode($searchModelsub['Title']) . "'><i class='fa fa-pinterest'></i></a></li>"
                  . "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModelsub['ID'] . "' data-url='http://www.linkedin.com/shareArticle?mini=true&url=" . Yii::$app->params['domainName'] . $reqquesturi . "&title=" . urlencode($searchModelsub['Title']) . "&source=" . urlencode(Yii::$app->params['domainName']) . "'><i class='fa fa-linkedin'></i></a></li></ul>";
                $ismainvar = '1';


                $highResolutionURL = str_replace('mp4_', 'hls1080m_', $searchModelsub['VideoStreamURL']);
                $highmediumResolutionURL = str_replace('mp4_', 'hls720m_', $searchModelsub['VideoStreamURL']);
                $mediumResolutionURL = str_replace('mp4_', 'hls480m_', $searchModelsub['VideoStreamURL']);
                $lowmediumResolutionURL = str_replace('mp4_', 'hls360m_', $searchModelsub['VideoStreamURL']);
                $lowResolutionURL = str_replace('mp4_', 'hls240m_', $searchModelsub['VideoStreamURL']);


                $mainvideovar .= '<div class="col-md-7" style="position:relative">
                    <div class="col-md-12 wr-video">
                    <div class="v-col-5">
                    <div class="overlapdiv">
                    <p class="reloadbutton"><a href="#" class="reloadlink"><i class="fa fa-refresh"></i></a></p>
                    <p class="showfullvideo"><a href="' . Url::toRoute(['video/index', 'videoid' => $searchModelsub['FullVideoId']]) . '">' . Yii::t('frontend', 'watchfullvideo') . '</a></p></div>
                    <video id="containerForShortVideo" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="100%" playsinline></video>';
                if ($HomePageModel->NewsOrAdd == '1') {
                    $mainvideovar .= '<div class="breaking-news" style="display:none">
                        <div class="breaking-main">
                        <div class="breaking-logo"></div>
                        <div class="breaking-logo2"></div>
                        </div>
                        <div class="breaking-color">
                        <div id="s1" class="is">';
                    foreach ($newsModel as $newsModelarray) {
                        $mainvideovar .= '<a href="' . $newsModelarray->LandingLink . '" target="_blank">' . $newsModelarray->Title . '</a>';
                    }
                    $mainvideovar .= '</div></div></div>';
                } else {
                    $mainvideovar .= ' <div>
                        <ul class="rslides" id="slider1">';
                    foreach ($Advertise as $Advertisevar) {

                        $mainvideovar .= '<li><a href="' . $Advertisevar['LandingLink'] . '" target="_blank"><img src="' . S3_THUMB_CLOUDFRONT . '/' . ADVERISEMENT . '/' . $Advertisevar['ImagePath'] . '" /></a></li>';
                    }
                    $mainvideovar .= '</ul></div>';
                }
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
                  type: "mp4"
                  },
                  {
                  file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $lowResolutionURL . '",
                  label: "240p",
                  default: "true",
                  type: "mp4"
                  }

                  ],
                 */
                ?><?php
                $mainvideovar .= $this->registerJs('
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
                        poster: "' . Main_VideoUrl(ImagesUrl($searchModelsub)) . '",
                        sources: [{
                            src: "' . S3_VIDEO_BUCKETABSOLUTE_PATH_AUTO . $searchModelsub['VideoStreamURL'] . '.m3u8",
                            type: "application/x-mpegURL"
                        }]
                    });

                    var imaOptions = {
                        id: "containerForShortVideo",
                        adsResponse: vmapXML
                    };
                    playerInstance.ima(imaOptions);
                ');
                if ($searchModelsub['FullVideoId'] != '') {
                    $mainvideovar .= $this->registerJs('playerInstance.on("ended", function(){$(".overlapdiv").show();});');
                }
                $mainvideovar .= $this->registerJs('$(document).on("click", ".socialsharebutton", function() {
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
          ');
                ?>
                <?php
                $mainvideovar .= '<div class="favourite-icon-wrap">';
                /* if (in_array('3', $actiontype)) {
                  $watchlistvar = Yii::t('frontend', 'removewatchlist');
                  $mainvideovar.='<div class="watch-later favourite-icon tab-active" title="Remove from Watchlist" ><a href="#" id="watchlink" class="videounwatchlink" data-videoid="' . $searchModelsub["ID"] . '">';
                  } else {
                  if (Yii::$app->getUser()->isGuest) {
                  $watchtourl = Url::toRoute('member/login/1');
                  $mainvideovar.='<div class="watch-later favourite-icon" title="Add To Watchlist"><a href="' . $watchtourl . '" id="watchlink" class="" data-videoid="' . $searchModelsub["ID"] . '">';
                  } else {
                  $watchtourl = '#';
                  $mainvideovar.='<div class="watch-later favourite-icon" title="Add To Watchlist"><a href="' . $watchtourl . '" id="watchlink" class="videowatchlink" data-videoid="' . $searchModelsub["ID"] . '">';
                  }
                  $watchlistvar = Yii::t('frontend', 'watchlater');
                  }
                  $mainvideovar.='<img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/watch-leter.png" alt="' . $watchlistvar . '" />
                  <span class="watchlisttext">' . $watchlistvar . '</span>
                  </a>
                  </div>';
                  if (in_array('2', $actiontype)) {
                  $favouvar = Yii::t('frontend', 'removefavourite');
                  $mainvideovar.='<div class="favourite favourite-icon tab-active" title="Remove from Favourites">
                  <a href="#" id="favlink" class="videounfavlink" data-videoid="' . $searchModelsub["ID"] . '">';
                  } else {
                  if (Yii::$app->getUser()->isGuest) {

                  $favtourl = Url::toRoute('member/login/1');
                  $mainvideovar.='<div class="favourite favourite-icon" title="Add to Favourites">
                  <a href="' . $favtourl . '" id="favlink" class="" data-videoid="' . $searchModelsub["ID"] . '">';
                  } else {
                  $favtourl = '#';
                  $mainvideovar.='<div class="favourite favourite-icon" title="Add to Favourites">
                  <a href="' . $favtourl . '" id="favlink" class="videofavlink" data-videoid="' . $searchModelsub["ID"] . '">';
                  }
                  $favouvar = Yii::t('frontend', 'addtofav');
                  }
                  $mainvideovar.='<img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/heart.png" alt="' . $favouvar . '" />
                  <span class="favouritetext">' . $favouvar . '</span>
                  </a></div>';
                 */
                if (in_array('1', $actiontype)) {
                    $liketextvar = Yii::t('frontend', 'likethisvideo');
                    $mainvideovar .= '<div class="like favourite-icon tab-active"  title="Like"><a href="#" id="likelink" class="videounlikelink" data-videoid="' . $searchModelsub["ID"] . '">';
                } else {

                    if (!Yii::$app->getUser()->isGuest) {
                        $liketextvar = Yii::t('frontend', 'likethisvideo');
                        $mainvideovar .= '<div class="like favourite-icon"  title="Like"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModelsub["ID"] . '">';
                    } else {
                        if ($varcookies == 0) {
                            $liketextvar = Yii::t('frontend', 'likethisvideo');
                            $mainvideovar .= '<div class="like favourite-icon"  title="Like"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModelsub["ID"] . '">';
                        } else {
                            $liketextvar = Yii::t('frontend', 'unlike');
                            $mainvideovar .= '<div class="like favourite-icon tab-active" title="Unlike"><a href="#"  id="likelink" data-videoid="' . $searchModelsub["ID"] . '">';
                        }
                    }
                }
                $mainvideovar .= '<img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/like.png" alt="' . $liketextvar . '" />
        <i class="displynumbr">' . $searchModelsub['LikeCount'] . '</i>
        <span class="liketext">' . $liketextvar . '</span>
        </a></div>
        <div class="share favourite-icon" title="Share Video">
        <a href="#" id="sharelink" class="videosharelink" data-toggle="popover" data-videoid="' . $searchModelsub["ID"] . '"> 
        <img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/share-icon.png" alt="' . Yii::t('frontend', 'sharethisvideo') . '" />
        <span>' . Yii::t('frontend', 'sharethisvideo') . '</span>
        </a>
        </div>';
                if ($searchModelsub['AllowDownload'] == '1') {
                    $mainvideovar .= '<div class="share favourite-icon" title="Download Video">
            <a href="' . Url::toRoute(['video/downloadvideo', 'videoid' => $searchModelsub['ID']]) . '"><img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/download.png" alt="' . Yii::t('frontend', 'downlodthisvideo') . '" /><span>' . Yii::t('frontend', 'downlodthisvideo') . '</span>
            </a></div>';
                }


                $mainvideovar .= '</div><div class="clear"></div>
        <div class=" descraption playlist-description">
        <h1>' . $searchModelsub['Title'] . '</h1>
        
        <p class="playlists-peragraph">
        ' . $searchModelsub['Description'] . '
        </p></div>
        </div>
        </div></div>';
            } else {
                $mainvideovar .= '<div class="col-md-7" style="position:relative"><div class="error-video-msg clearfix" style="width:90%">
        <div class="error-video-img"><img src="' . Yii::$app->params['domainName'] . 'frontend/web/images/video-error-img.png" alt="error-img"></div>
        <div class="error-video-text">
        <p>' . Yii::t('frontend', 'VideoNotAvailable') . '</p>
        </div>
        </div></div>';
            }
        }
    } else {
        if ($mainvideovar == '') {
            if (empty($Videogeographics)) {
                // Check the availability of the cookie
                if ($cookies->has($searchModel[0]["ID"] . 'cookies')) {
                    $varcookies = 1;
                } else {
                    $varcookies = 0;
                }
                Yii::$app->view->registerMetaTag([
                    'name' => 'fb:app_id',
                    //'content' => trim($searchModel[0]['description'])
                    'content' => '948450055241654'
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'og:title',
                    'content' => $searchModel[0]['Title'],
                    'property' => "og:title",
                    'itemprop' => "title name",
                    'prefix' => "og: http://ogp.me/ns#"
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'og:description',
                    'content' => $searchModel[0]['Description'],
                    'property' => "og:description",
                    'itemprop' => "description",
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'og:image',
                    'content' => ImagesUrl($searchModel[0], TRUE),
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
                    'content' => $searchModel[0]['Description'],
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
                    'content' => ImagesUrl($searchModel[0], TRUE)
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:card',
//                    'content' => 'player',
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
                    'content' => Yii::$app->params['domainName'] . $reqquesturi,
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:description',
                    'content' => $searchModel[0]['Description']
                ]);
                Yii::$app->view->registerMetaTag([
                    'name' => 'twitter:image',
                    'content' => ImagesUrl($searchModel[0], TRUE)
                ]);

                $newtitle = str_replace(' ', '+', $searchModel[0]['Title']);
                $socialcontentvar = "<ul class='socialiconsul'>"
                  . "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='http://www.facebook.com/share.php?u=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-facebook'></i></a></li>"
                  . "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='https://plus.google.com/share?url=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-google-plus'></i></a></li>"
                  . "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='http://twitter.com/share?text=" . $newtitle . "&url=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-twitter'></i></a></li>"
                  . "<li><a href='#' id='pintrestshare' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='http://pinterest.com/pin/create/bookmarklet/?media=" . ImagesUrl($searchModel[0]) . "&url=" . Yii::$app->params['domainName'] . $reqquesturi . "&description=" . $searchModel[0]['Title'] . "'><i class='fa fa-pinterest'></i></a></li>"
                  . "<li><a href='#' class='socialsharebutton' data-videoid='" . $searchModel[0]['ID'] . "' data-url='http://www.linkedin.com/shareArticle?mini=true&url=" . Yii::$app->params['domainName'] . $reqquesturi . "&title=" . $searchModel[0]['Title'] . "&source=" . Yii::$app->params['domainName'] . "'><i class='fa fa-linkedin'></i></a></li></ul>";
                $ismainvar = '1';
                $adurmidtime = $searchModel[0]['StartMidAdvertisementTime'];
                if (!empty($Customadvertise)) {
                    foreach ($Customadvertise as $Customadvertisesub) {
                        $Customadvertisesub['Type']=$Customadvertisesub['Type_Id'];
                        $customadarraylist[$Customadvertisesub['Type']] = $Customadvertisesub['XML'];
                        $customadarraylist['Time'] = $Customadvertisesub['MidTime'];
                    }
                    if (array_key_exists("1", $customadarraylist)) {
                        $adurl1 = CustomAdvertisePath() . $customadarraylist['1'] . '.xml';
                    } else {
                        $adurl1 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModel[0]['PreXML'] . ".xml";
                    }
                    if (array_key_exists("2", $customadarraylist)) {
                        $adurl2 = CustomAdvertisePath() . $customadarraylist['2'] . '.xml';
                        $adurmidtime = $customadarraylist['Time'];
                    } else {
                        $adurl2 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModel[0]['MidXML'] . ".xml";
                        $adurmidtime = $searchModel[0]['StartMidAdvertisementTime'];
                    }
                    if (array_key_exists("3", $customadarraylist)) {
                        $adurl3 = CustomAdvertisePath() . $customadarraylist['3'] . '.xml';
                    } else {
                        $adurl3 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModel[0]['PostXML'] . ".xml";
                    }
                    //Yii::$app->
                } else {
                    $adurl1 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModel[0]['PreXML'] . ".xml";
                    $adurl2 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModel[0]['MidXML'] . ".xml";
                    $adurl3 = S3_THUMB_CLOUDFRONT . "/xml/" . $searchModel[0]['PostXML'] . ".xml";
                }


                $highResolutionURL = str_replace('mp4_', 'hls1080m_', $searchModel[0]['VideoStreamURL']);
                $highmediumResolutionURL = str_replace('mp4_', 'hls720m_', $searchModel[0]['VideoStreamURL']);
                $mediumResolutionURL = str_replace('mp4_', 'hls480m_', $searchModel[0]['VideoStreamURL']);
                $lowmediumResolutionURL = str_replace('mp4_', 'hls360m_', $searchModel[0]['VideoStreamURL']);
                $lowResolutionURL = str_replace('mp4_', 'hls240m_', $searchModel[0]['VideoStreamURL']);

                $mainvideovar .= '<div class="col-md-7">
            <div class="col-md-12 wr-video">
            <div class="v-col-5" style="position:relative">
            <div class="overlapdiv">
            <p class="reloadbutton"><a href="#" class="reloadlink"><i class="fa fa-refresh"></i></a></p>
            <p class="showfullvideo"><a href="' . Url::toRoute(['video/index', 'videoid' => $searchModel[0]['FullVideoId']]) . '">' . Yii::t('frontend', 'watchfullvideo') . '</a></p></div>           
            <video id="myElement" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="100%" playsinline></video>';
                if ($HomePageModel->NewsOrAdd == '1') {
                    $mainvideovar .= '<div class="breaking-news" style="display:none">
                <div class="breaking-main">
                <div class="breaking-logo"></div>
                <div class="breaking-logo2"></div>
                </div>
                <div class="breaking-color">
                <div id="s1" class="is">';
                    foreach ($newsModel as $newsModelarray) {
                        $mainvideovar .= '<a href="' . $newsModelarray->LandingLink . '" target="_blank">' . $newsModelarray->Title . '</a>';
                    }
                    $mainvideovar .= '</div></div></div>';
                } else {
                    $mainvideovar .= ' <div>
                <ul class="rslides" id="slider1">';
                    foreach ($Advertise as $Advertisevar) {

                        $mainvideovar .= '<li><a href="' . $Advertisevar['LandingLink'] . '" target="_blank"><img src="' . S3_THUMB_CLOUDFRONT . '/' . ADVERISEMENT . '/' . $Advertisevar['ImagePath'] . '" /></a></li>';
                    }
                    $mainvideovar .= '</ul></div>';
                }
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
                  type: "mp4"
                  },
                  {
                  file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $lowResolutionURL . '",
                  label: "240p",
                  default: "true",
                  type: "mp4"
                  }


                  ],
                 */
                ?><?php
                $mainvideovar .= $this->registerJs('
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
                        poster: "' . Main_VideoUrl(ImagesUrl($searchModel[0])) . '",
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
                    $mainvideovar .= $this->registerJs('playerInstance.on("ended", function(){$(".overlapdiv").show();});');
                }
                $mainvideovar .= $this->registerJs('$(document).on("click", ".socialsharebutton", function() {
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
          ');
                ?>



                <?php
                $mainvideovar .= '<div class="favourite-icon-wrap">';
                /*   if (in_array('3', $actiontype)) {
                  $watchlistvar = Yii::t('frontend', 'removewatchlist');
                  $mainvideovar.='<div class="watch-later favourite-icon tab-active" title="Remove from Watchlist"><a href="#" id="watchlink" class="videounwatchlink" data-videoid="' . $searchModel[0]["ID"] . '">';
                  } else {
                  $watchlistvar = Yii::t('frontend', 'watchlater');
                  if (Yii::$app->getUser()->isGuest) {
                  $watchtourl = Url::toRoute('member/login/1');
                  $mainvideovar.='<div class="watch-later favourite-icon" title="Add To Watchlist"><a href="' . $watchtourl . '" id="watchlink" class="" data-videoid="' . $searchModel[0]["ID"] . '">';
                  } else {
                  $watchtourl = '#';
                  $mainvideovar.='<div class="watch-later favourite-icon" title="Add To Watchlist"> <a href="' . $watchtourl . '" id="watchlink" class="videowatchlink" data-videoid="' . $searchModel[0]["ID"] . '">';
                  }
                  }
                  $mainvideovar.='<img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/watch-leter.png" alt="' . $watchlistvar . '"/>
                  <span class="watchlisttext">' . $watchlistvar . '</span>
                  </a></div>';
                  if (in_array('2', $actiontype)) {
                  $favouvar = Yii::t('frontend', 'removefavourite');
                  $mainvideovar.='<div class="favourite favourite-icon tab-active" title="Remove from Favourites">
                  <a href="#" id="favlink" class="videounfavlink" data-videoid="' . $searchModelsub["ID"] . '">';
                  } else {
                  $favouvar = Yii::t('frontend', 'addtofav');
                  if (Yii::$app->getUser()->isGuest) {
                  $favtourl = Url::toRoute('member/login/1');
                  $mainvideovar.='<div class="favourite favourite-icon"  title="Add to Favourites">
                  <a href="' . $favtourl . '" id="favlink" class="" data-videoid="' . $searchModelsub["ID"] . '">';
                  } else {
                  $favtourl = '#';
                  $mainvideovar.='<div class="favourite favourite-icon"  title="Add to Favourites" >
                  <a href="' . $favtourl . '" id="favlink" class="videofavlink" data-videoid="' . $searchModelsub["ID"] . '">';
                  }
                  }
                  $mainvideovar.='<img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/heart.png" alt="' . $favouvar . '" />
                  <span class="favouritetext">' . $favouvar . '</span>
                  </a></div>'; */
                if (in_array('1', $actiontype)) {

                    $liketextvar = Yii::t('frontend', 'likethisvideo');
                    $mainvideovar .= '<div class="like favourite-icon tab-active" title="Like" ><a href="#" id="likelink" class="videounlikelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                } else {

                    if (!Yii::$app->getUser()->isGuest) {
                        $liketextvar = Yii::t('frontend', 'likethisvideo');
                        $mainvideovar .= '<div class="like favourite-icon" title="Like"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                    } else {
                        if ($varcookies == 0) {
                            $liketextvar = Yii::t('frontend', 'likethisvideo');
                            $mainvideovar .= '<div class="like favourite-icon" title="Like"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                        } else {
                            $liketextvar = Yii::t('frontend', 'unlike');
                            $mainvideovar .= '<div class="like favourite-icon tab-active" title="Unlike"><a href="#" id="likelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                        }
                    }
                }
                $mainvideovar .= '<img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/like.png" alt="' . $liketextvar . '" />
        <i class="displynumbr">' . $searchModel[0]['LikeCount'] . '</i>
        <span class="liketext">' . $liketextvar . '</span>
        </a></div>
        <div class="share favourite-icon" title="Share Video">
        <a href="#" id="sharelink" class="videosharelink" data-toggle="popover" data-videoid="' . $searchModel[0]["ID"] . '">
        <img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/share-icon.png" alt="' . Yii::t('frontend', 'sharethisvideo') . '" />
        <span>' . Yii::t('frontend', 'sharethisvideo') . '</span>
        </a>
        </div>';
                if ($searchModel[0]['AllowDownload'] == '1') {
                    $mainvideovar .= '<div class="share favourite-icon" title="Download Video">
            <a href="' . Url::toRoute(['video/downloadvideo', 'videoid' => $searchModel[0]['ID']]) . '"><img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/download.png" alt="' . Yii::t('frontend', 'downlodthisvideo') . '" /><span>' . Yii::t('frontend', 'downlodthisvideo') . '</span>
            </a></div>';
                }
                $mainvideovar .= '</div>
        <div class="clear"></div>
        <div class="descraption playlist-description">
        <h1>' . $searchModel[0]['Title'] . '</h1>
        
        
        <p class="playlists-peragraph">
        ' . $searchModel[0]['Description'] . '
        </p></div></div>
        </div></div>';
            } else {
                $mainvideovar .= '<div class="col-md-7" style="position:relative"><div class="error-video-msg clearfix" style="width:90%">
        <div class="error-video-img"><img src="' . Yii::$app->params['domainName'] . 'frontend/web/images/video-error-img.png" alt="error-img"></div>
        <div class="error-video-text">
        <p>' . Yii::t('frontend', 'VideoNotAvailable') . '</p>
        </div>
        </div></div>';
            }
        }
    }

    if ($ismainvar == '0') {
        $Rightcoloumnvar .= '<!----Single playlist post ------->
    <div class="playList col-xs-12 col-sm-6 wr-video" id="' . $key1 . '" >
    <span class="div" data-index="' . $displayindexvar . '"></span> 
    
    <div class=" playlists-img-wraper video-image-box video-post">
    <img  src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/site-lazy.png" data-src="' . Main_VideoUrl(ImagesUrl($searchModelsub)) . '" style="width:100%;" alt="" class="lazyload lazy-hidden" onerror="this.error=false;this.src=\'' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png\'" />
    <a href="' . Yii::$app->getUrlManager()->getBaseUrl() . '/throwback/' . $searchModelsub['playlist_slug'] . '/' . $searchModelsub['slug'] . '-' . $searchModelsub['ID'] . '"><span class="vd-button"></span></a>
    </div>
    <div class="data"> 
    <h5 class="playlist-title-truncate">
    <a href="' . Yii::$app->getUrlManager()->getBaseUrl() . '/throwback/' . $searchModelsub['playlist_slug'] . '/' . $searchModelsub['slug'] . '-' . $searchModelsub['ID'] . '">' . $searchModelsub['Title'] . '</a>
    </h5>
    </div>
    </div> 
    <!----Single playlist post ------->';
        $videoincrementvar++;
    }
    $displayindexvar--;
}
?>
<!--New Video-->
<section class="color-bg wow fadeInDown" >
    <div class="col-md-11 single-page"> 
        <!--Left Sidebar -->
        <?php echo $mainvideovar; ?>
        <!-- Right Sidebar -->
        <div class="col-md-5 playlist-right-sidebar">
            <div class="playlists-wraper">
                <div class="heading">
                    <h1><?php echo $searchModel[0]['PlayListTitle']; ?> 
                        <?php
                        if ($videoincrementvar > 1) {
                            echo '<span style="cursor:pointer"  id="sDiv" asc="down"><i class="fa fa-sort-asc" id="sorticonid"></i></span>';
                        }
                        ?>                        
                    </h1>
                </div>

                <div class="small-playlists-wraper related-video" >
                    <div class="row" id="sortThis">
                        <?php echo $Rightcoloumnvar; ?>
                    </div>

                </div>

            </div>
        </div>
    </div></div>
</section>
<script type="text/javascript">
    try {
        ga('send', {hitType: 'event', eventCategory: '<?php echo $searchModel[0]["PlayListTitle"]; ?>', eventAction: 'Playlist', eventLabel: '<?php echo $searchModel[0]["Title"]; ?>', eventValue: location.pathname});
    } catch (e) {
        console.log(e);
    }
</script>
