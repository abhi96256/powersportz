<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

date_default_timezone_set("Asia/Kolkata");
$cookies = Yii::$app->request->cookies;
$this->registerJsFile(Yii::$app->homeUrl . 'js/endless_scroll_min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$HomePageModel->scroll_time = $HomePageModel->scroll_time * 10;
// print_r($searchModel);exit;

?>
<!--<h1>schedule/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>-->
<style>
    .schedule-inner {
        float: left;
        width: 100%;
        margin-bottom: 15px;
    }
    .shcedule-content h1 {
        font-size: 13px;
        display: inline-block;
        padding: 0;
        margin: 15px 0;
        font-weight: 100;
        position: relative;
        width: 80%;
        float: left;
    }
    .shcedule-content time {
        text-align: right;
        display: block;
        font-size: 14px;
        float: right;
        margin: 2px 0;
    }
    .shcedule-content h2:after {
        opacity: 0;
    }
    .shcedule-content h2 {
        font-size: 15px;
        font-weight: 100;
        position: relative;
        border-top: 1px #fff solid;
        border-bottom: 1px #fff solid;
        padding: 10px 0;
    }
</style>
<script type="text/javascript" src='http://content.jwplatform.com/libraries/DkwOvSfA.js'></script>
<?php
$this->title = Yii::t('frontend', 'Schedule') . ' ';
$this->params['breadcrumbs'][] = $this->title;
$mainvideovar = '';
$Rightcoloumnvar = '';
$displayindexvar = count($searchModel);
//echo "<pre>"; print_r($searchModel);die;
$VideoID = $scheduleInfo[0]['ID'];

$modelMember = array();
if (!Yii::$app->getUser()->isGuest) {
    $userID = Yii::$app->user->identity->UserID;
    $modelMember = \frontend\models\Videolike::find()->where(['UserID' => $userID, 'VideoID' => $VideoID])->asArray()->all();
}
$actiontype = array();
if (!empty($modelMember)) {
    foreach ($modelMember as $modelMemberarray) {
        array_push($actiontype, $modelMemberarray['Type']);
    }
}


$highResolutionURL = str_replace('mp4_', 'hls1080m_', $scheduleInfo[0]['VideoStreamURL']);
$highmediumResolutionURL = str_replace('mp4_', 'hls720m_', $scheduleInfo[0]['VideoStreamURL']);
$mediumResolutionURL = str_replace('mp4_', 'hls480m_', $scheduleInfo[0]['VideoStreamURL']);
$lowmediumResolutionURL = str_replace('mp4_', 'hls360m_', $scheduleInfo[0]['VideoStreamURL']);
$lowResolutionURL = str_replace('mp4_', 'hls240m_', $scheduleInfo[0]['VideoStreamURL']);
    
if(isset($scheduleInfo[0])) {

    $newtitle = str_replace(' ', '+', $scheduleInfo[0]['Title']);
    $socialcontentvar = '';
    $reqquesturi = $_SERVER['REQUEST_URI']; 
    $reqquesturi =str_replace('/devpowersport/', '/', $reqquesturi);
    $reqquesturi = ltrim($reqquesturi, '/');
    
    Yii::$app->view->registerMetaTag([
        'name' => 'fb:app_id',
            //'content' => trim($searchModel[0]['description']) 
        'content' => '948450055241654'
    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'og:title',
            //'content' => 'Test Title'
        'content' => trim($scheduleInfo[0]['Title']),
        'property'=>"og:title" ,
        'itemprop'=>"title name" ,
        'prefix'=>"og: http://ogp.me/ns#"
    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'og:description',
        'content' => trim($scheduleInfo[0]['description']),
        'property'=>"og:description" ,
        'itemprop'=>"description",


    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'og:site_name',
        'content' => 'Power Sportz'
    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'og:image',
        'content' => ImagesUrl($scheduleInfo[0]),
        'itemprop'=>'image',
        'property'=>'og:image',
        'prefix'=>"og: http://ogp.me/ns#"
    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'og:url',
        'content' => Yii::$app->params['domainName'] . $reqquesturi,
        'property'=>'og:url',
        'itemprop'=>'url',
        'prefix'=>"og: http://ogp.me/ns#"
    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'og:type',
        'content' => 'website',
        'property'=>'og:type',
        'prefix'=>"og: http://ogp.me/ns#"
    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'description',
        'content' => $scheduleInfo[0]['description']
    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'keyword',
        'content' => $scheduleInfo[0]['MetaKeywords']
    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'name',
        'content' => $scheduleInfo[0]['Title']
    ]);
    Yii::$app->view->registerMetaTag([
        'name' => 'image',
        'content' => ImagesUrl($scheduleInfo[0])
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
      'content' => $scheduleInfo[0]['Title']
  ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'twitter:url',
      'content' =>Yii::$app->params['domainName'] . $reqquesturi
  ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'twitter:description',
      'content' => $scheduleInfo[0]['description']
  ]);
    Yii::$app->view->registerMetaTag([
      'name' => 'twitter:image',
      'content' => ImagesUrl($scheduleInfo[0])
  ]);

    if(isset($scheduleInfo[0]['shared_on'])) {
        $shared_on = $scheduleInfo[0]['shared_on'];
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
        $socialcontentvar .= ($fb == 1) ? "<li><a href='#' class='socialsharebutton' data-videoid='" . $scheduleInfo[0]['ID'] . "' data-url='http://www.facebook.com/share.php?u=" . Yii::$app->params['domainName'] .$reqquesturi . "&title=" . $scheduleInfo[0]['Title'] . "'><i class='fa fa-facebook'></i></a></li>" : '';
        $socialcontentvar .= ($google == 1) ? "<li><a href='#' class='socialsharebutton' data-videoid='" . $scheduleInfo[0]['ID'] . "' data-url='https://plus.google.com/share?url=" . Yii::$app->params['domainName'] . $reqquesturi . "'><i class='fa fa-google-plus'></i></a></li>" : '';
        $socialcontentvar .= ($twiter == 1) ? "<li><a href='#' class='socialsharebutton' data-videoid='" . $scheduleInfo[0]['ID'] . "' data-url='http://twitter.com/share?text=" . $newtitle . "&url=" . Yii::$app->params['domainName'] .$reqquesturi . "'><i class='fa fa-twitter'></i></a></li>" : '';
        $socialcontentvar .= ($pintrest == 1) ? "<li><a href='#' id='pintrestshare' class='socialsharebutton' data-videoid='" . $scheduleInfo[0]['ID'] . "' data-url='http://pinterest.com/pin/create/bookmarklet/?media=" . S3_VIDEO_BUCKETABSOLUTE_PATH . $scheduleInfo[0]['ImageName'] . "&url=". Yii::$app->params['domainName'] .$reqquesturi . $scheduleInfo[0]['Title'] . "'><i class='fa fa-pinterest'></i></a></li>" : '';
        $socialcontentvar .= ($linkden == 1) ? "<li><a href='#' class='socialsharebutton' data-videoid='" . $scheduleInfo[0]['ID'] . "' data-url='http://www.linkedin.com/shareArticle?mini=true&url=" . Yii::$app->params['domainName'] . $reqquesturi . "&title=" . $scheduleInfo[0]['Title'] . "&source=".urlencode('Power Sportz')."'><i class='fa fa-linkedin'></i></a></li>" : '';
        $socialcontentvar .= "</ul>";
    }
}
?>
<div class="col-md-11 single-page">
    <div class="col-md-7">
        <div class="col-md-12 schedule-page-container  wr-video">
       

                <!-- Video code starts here -->             
                <div id="myElement">Loading the player...</div>
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

                        echo '<li><a href="' . $Advertisevar['LandingLink'] . '" target="_blank"><img src="' . S3_THUMB_CLOUDFRONT . '/' . ADVERISEMENT . '/' . $Advertisevar['ImagePath'] . '" /></a></li>';
                    }
                    echo '</ul></div>';
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
                ?>
                <?php
                $schedulevideothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
                if (!empty($recordedScheduleVideoImage['ImageName'])) {
                    $schedulevideothumbpage = ImagesUrl($recordedScheduleVideoImage);            
                }
                $this->registerJs('
                        var checkcookievar=0;
                        var playerInstance = jwplayer("myElement");
                        playerInstance.setup({
                        image: "' . Main_VideoUrl(ImagesUrl($scheduleInfo[0])) . '",
                        file:"' . S3_VIDEO_BUCKETABSOLUTE_PATH . $scheduleInfo[0]['VideoStreamURL'] . '.m3u8",
                        width: "100%",
                        autostart: false,
                        androidhls: true,
                        advertising: {
                        client: "vast",
                        schedule: {
                            adbreak1: {
                                    offset: "pre",
                                    tag: "' . $scheduleInfo[0]['PreAdvertisementTagURL'] . '",
                            },
                            adbreak2: {
                            offset: "3",
                            tag: "' . $scheduleInfo[0]['MidAdvertisementTagURL'] . '",
                            },
                            adbreak3: {
                            offset: "post",
                            tag: "' . $scheduleInfo[0]['PostAdvertisementTagURL'] . '",
                            },
                        }
                    }
                    });
                    
                                        
                           $("#likelink").click(function () {
                            var videoid=$(this).data("videoid");
                if($(this).hasClass("videolikelink")){
                            var URL="videolike";
                            $(this).toggleClass("videolikelink");
                            $(this).parent("div").addClass("tab-active");
                            $(".liketext").text("' . Yii::t("frontend", "unlike") . '");
                }
                else
                {
                            var URL="videounlike";
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
                            }); $("#watchlink").click(function () {
                            var videoid=$(this).data("videoid");
                            if($(this).hasClass("videowatchlink")){
                            var URL="videolike";
                            $(this).toggleClass("videowatchlink");
                            $(this).parent("div").addClass("tab-active");
                            $(".watchlisttext").text("' . Yii::t("frontend", "removewatchlist") . '");
                }
                else
                {
                                var URL="videounlike";
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
                            var URL="videolike";
                            $(this).toggleClass("videofavlink");
                            $(this).parent("div").addClass("tab-active");
                            $(".favouritetext").text("' . Yii::t("frontend", "removefavourite") . '");
                }
                else
                {
                        var URL="videounlike";
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
                          
                    $(document).on("click", ".socialsharebutton", function() {
                        console.log(this);
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
                                        title:"Be Social",
                                        html : true,
                                        content:"' . $socialcontentvar . '",
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
                if ($cookies->has($scheduleInfo[0]['ID'] . 'cookies')) {
                    $varcookies = 1;
                } else {
                    $varcookies = 0;
                }
                ?>



                <div class="favourite-icon-wrap">
                    <?php
                    if (in_array('3', $actiontype)) {
                        $watchlistvar = Yii::t('frontend', 'removewatchlist');
                        echo '<div class="watch-later favourite-icon tab-active" title="Remove from Watchlist"><a href="#" id="watchlink" class="videounwatchlink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
                    } else {
                        $watchlistvar = Yii::t('frontend', 'watchlater');
                        echo '<div class="watch-later favourite-icon" title="Add To Watchlist"><a href="#" id="watchlink" class="videowatchlink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
                    }
                    ?>
                    <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/watch-leter.png" alt="<?php echo $watchlistvar; ?>" />
                    <span class="watchlisttext"><?php echo $watchlistvar; ?></span>
                    </a></div>
                <!--<div class="favourite favourite-icon">
                   
                    <a href="#" class="videofavlink" data-videoid="<?php //echo $scheduleInfo[0]["ID"];    ?>">-->


                <?php
                if (in_array('2', $actiontype)) {
                    $favouvar = Yii::t('frontend', 'removefavourite');
                    echo '<div class="favourite favourite-icon tab-active" title="Remove from Favourites">
            <a href="#" id="favlink" class="videounfavlink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
                } else {
                    $favouvar = Yii::t('frontend', 'addtofav');
                    echo '<div class="favourite favourite-icon" title="Add to Favourites">
            <a href="#" id="favlink" class="videofavlink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
                }
                ?>
                <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/favourite.png" alt="<?php echo $favouvar; ?>" />
                <span class="favouritetext"><?php echo $favouvar; ?></span></a></div>  
            <!-- <div class="like favourite-icon">
                
            <?php
            /* if ($varcookies == 0) {
              echo '<a href="#" class="videolikelink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
              } else {
              echo '<a href="#">';
              } */
            ?>
            -->


            <?php
            /*
              if (in_array('1', $actiontype)) {
              $liketextvar = Yii::t('frontend', 'unlike');
              echo '<div class="like favourite-icon tab-active"><a href="#" id="likelink" class="videounlikelink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
              } else {
              $liketextvar = Yii::t('frontend', 'likethisvideo');


              if(!Yii::$app->getUser()->isGuest){
              echo '<div class="like favourite-icon"><a href="#" id="likelink" class="videolikelink" data-videoid="'.$scheduleInfo[0]["ID"].'">';
              }
              else{
              if($varcookies==0)
              {
              echo '<div class="like favourite-icon"><a href="#" id="likelink" class="videolikelink" data-videoid="'.$scheduleInfo[0]["ID"].'">';
              }
              else
              {
              echo '<div class="like favourite-icon tab-active"><a href="#">';
              }
              }
              } */
            ?>
           <!-- <img src="../images/like.png" alt="<?php //echo $liketextvar; ?>" />
            <i class="displynumbr"><?php //echo $scheduleInfo[0]['LikeCount'];  ?></i>
            <span class="liketext"><?php //echo $liketextvar;  ?></span>-->
            <?php
            if (in_array('1', $actiontype)) {
                $liketextvar = Yii::t('frontend', 'unlike');
                echo '<div class="like favourite-icon tab-active" title="Like"><a href="#" id="likelink" class="videounlikelink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
            } else {

                if (!Yii::$app->getUser()->isGuest) {
                    $liketextvar = Yii::t('frontend', 'likethisvideo');
                    echo '<div class="like favourite-icon" title="Like"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
                } else {
                    if ($varcookies == 0) {
                        $liketextvar = Yii::t('frontend', 'likethisvideo');
                        echo '<div class="like favourite-icon" title="Like"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
                    } else {
                        $liketextvar = Yii::t('frontend', 'unlike');
                        echo '<div class="like favourite-icon tab-active" title="Unlike"> <a href="#" id="likelink" data-videoid="' . $scheduleInfo[0]["ID"] . '">';
                    }
                }
            }
            ?>
            <img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/images/like.png" alt="<?php echo $liketextvar; ?>" />
            <i class="displynumbr"><?php echo $scheduleInfo[0]['LikeCount']; ?></i>
            <span class="liketext"><?php echo $liketextvar; ?></span>
            </a></div>




        <div class="share favourite-icon" title="Share Video">
            <a href="#" id="sharelink" class="videosharelink" data-toggle="popover" data-videoid="<?php echo $scheduleInfo[0]["ID"]; ?>">
                <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/images/share-icon.png" alt="<?php echo Yii::t('frontend', 'sharethisvideo'); ?>" />
                <span><?php echo Yii::t('frontend', 'sharethisvideo'); ?></span>
            </a>
        </div>
        <?php
        if ($scheduleInfo[0]['AllowDownload'] == '1') {
            echo '<div class="share favourite-icon" title="Download Video" >
    <a href="' . Url::toRoute(['video/downloadvideo', 'videoid' => $scheduleInfo[0]['ID']]) . '"><img src="' . Yii::$app->getUrlManager()->getBaseUrl() . '/images/download.png" alt="' . Yii::t('frontend', 'downlodthisvideo') . '" /><span>' . Yii::t('frontend', 'downlodthisvideo') . '</span>
    </a></div>';
        }
        ?>
    </div>
<div class="data descraption">
                        <h1> <?= $scheduleInfo[0]['Title'] ?></h1> 
    <div class="clear">
        
    </div>
</div> 



    <script type="text/javascript">
        jwplayer("myElement").setup({
            playlist: [{
                    image: "includes/video/sports-video.jpg",
                    file: "includes/video/sports.mp4",
                    title: " "
                }],
            width: "100%",
            aspectratio: "16:9",
            autostart: false,
            mute: true,
            'playlist.position': 'right',
            'playlist.size': '320',
            //sharing: {
            //      code: encodeURI("<iframe src='#' />"),
            //      link: "#",
            //   },
            // logo: {
            //		file: 'includes/images/video-logo.png',
            //		link: 'http://www.e2logy.com/'
            //	},

        });
        function goFullscreen(id) {
            // Get the element that we want to take into fullscreen mode
            var element = document.getElementById(id);

            // These function will not exist in the browsers that don't support fullscreen mode yet,
            // so we'll have to check to see if they're available before calling them.

            if (element.mozRequestFullScreen) {
                // This is how to go into fullscren mode in Firefox
                // Note the "moz" prefix, which is short for Mozilla.
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullScreen) {
                // This is how to go into fullscreen mode in Chrome and Safari
                // Both of those browsers are based on the Webkit project, hence the same prefix.
                element.webkitRequestFullScreen();
            }
            // Hooray, now we're in fullscreen mode!
        }
    </script>    

 
</div>
</div>

<div class="col-md-5">
    <div class="schedule-wraper">
        <!--<div class="schedule-type">
          <h1>Showtime East</h1>
          <h1>Showtime West</h1>
        </div>-->
        <div class="shcedule-content" id="east">
<?php if (!empty($scheduleInfo[0]['ProgramTitle'])) { ?>
                <div>
                    <h2><?php echo Yii::t('frontend', 'Onnow'); ?></h2>
                    <h1><?php echo $scheduleInfo[0]['ProgramTitle']; ?></h1>
    <?php
    /* ---------------------Convet local time------------------------------ */
    $date = $scheduleInfo[0]['ScheduleDate'];
    $time = $scheduleInfo[0]['ScheduleTime'];
    $sdatetime = $date . ' ' . $time;
    $convertlocaldatetime = ConvertDateTolocaltime($sdatetime);
    $spitdatetime = explode(" ", $convertlocaldatetime);
    /* -------------- DISPLAY DATE ,time -------------------- */
    $convertdate = $spitdatetime[0];
    $converttime = $spitdatetime[1];
    ?>
                    <span><?php echo date('l, F d', strtotime($convertdate)); ?></span>
                    <span>&nbsp;&nbsp;</span>
                    <time><?php //echo date("g:i a", strtotime($converttime));
                echo $spitdatetime[1] . ' ' . $spitdatetime[2];
                ?></time>
                </div>
                    <?php } ?>

            <?php //echo "<pre>";print_r($searchModel);die;?>
          


            <div class="schedule-con">

<?php

if (isset($searchModel) && empty($searchModel)){
//if (isset($searchModel) && !isset($searchModel[0]['ScheduleDate']) && $searchModel[0]['ScheduleDate'] == '')  {
                    echo '<br/>';
                    if (!Yii::$app->getRequest()->getQueryParam('sdate')) {
                        echo "No records available for " . date('l, F d');
                    } else {
                        echo "No records available for " . date('l, F d', strtotime(Yii::$app->getRequest()->getQueryParam('sdate')));
                    }
             //   }
                }?>
                <!--<div class="schedule-inner">
                           <h2>On Now</h2>
                      <h1><?php //echo $scheduleInfo[0]['ProgramTitle'];    ?></h1>
                      <span><?php //echo date("g:i a", strtotime($scheduleInfo[0]['ScheduleTime']));   ?></span>
                      <time><?php //echo date('d-M-Y',strtotime($scheduleInfo[0]['ScheduleDate']));      ?></time>
                  </div>
                <h2></h2>
                -->
<?php
/*
  echo "<br/>";
  echo "CURRENT DATE:".date('Y-m-d') ;
  echo "<br/>";
  echo "CURRENT time:".date('H:i:s') ; */

?>
                <?php 
                $i = 0;
                foreach($searchModel as $key => $searchModel)
{
     ?>
                <!--<h2></h2>-->
       <?php
                $temp1 = $searchModel[0]['ScheduleDate']." ". $searchModel[0]['ScheduleFromTime'];
                
                $date = explode(" ", $temp1);
                //$date = explode(" To ", $key);
                $datet = $searchModel[0]['ScheduleDate'];
                $timet = $date[1];
                $ftimet = $date[0];
                $sdatetimet = $datet . ' ' . $timet;
                if($i==0){
                ?>
                <div><h3 style="width: 100%">
                    <sub class="days"><?= date('l, F d', strtotime($datet)) ?></sub>
                    <time> Time </time></h3>
                </div>
                <?php 
                    $i++;
                }
                $convertlocaldatetimet = ConvertDateTolocaltime($sdatetimet);
                $spitdatetimet = explode(" ", $convertlocaldatetimet);
                ///* -------------- DISPLAY DATE ,time -------------------- */
                $convertdatet = $spitdatetimet[0];
                $converttime1 = $spitdatetimet[1];
                //
                $fsdatetimet = $datet . ' ' . $searchModel[0]['ScheduleTime'];
                $fconvertlocaldatetimet = ConvertDateTolocaltime($fsdatetimet);
                
                

                $fspitdatetimet = explode(" ", $fconvertlocaldatetimet);
                ///* -------------- DISPLAY DATE ,time -------------------- */
                $fconvertdatet = $fspitdatetimet[0];
                $fconverttime1 = $fspitdatetimet[1];            
               
               ?>
                <input type="hidden" id="sdpredate" name="sdpredate" value="<?php //echo date('Y-m-d', strtotime($convertdatet . "-1 days")); ?>"/>
                <input type="hidden" id="sdnxtdate" name="sdnxtdate" value="<?php //echo date('Y-m-d', strtotime($convertdatet . "+1 days")); ?>"/>
                    <?php
                 
                
                foreach ($searchModel as $key => $searchModelsub) { ?>
 
                    <?php
                    /* ---------------------Convet local time------------------------------ */
                    $date1 = $searchModelsub['ScheduleDate'];
                    $time1 = $searchModelsub['ScheduleTime'];
                    $sdatetime1 = $date1 . ' ' . $time1;
                    $convertlocaldatetime1 = ConvertDateTolocaltime($sdatetime1);
                    $spitdatetime1 = explode(" ", $convertlocaldatetime1);
                    /* -------------- DISPLAY DATE ,time -------------------- */
                    $convertdate1 = $spitdatetime1[0];
                    $converttime1 = $spitdatetime1[1];
                    ?>

                    <?php
                     
                    if ($searchModelsub['VideoURL'] == "") {
                        ?>
                        <div class="schedule-inner">
                            <div class="schedule-unit">
                                <?php echo $searchModelsub['ProgramTitle']; ?> <time><?php echo $spitdatetimet[1] . ' ' . $spitdatetimet[2]; ?> To <?php  echo $fspitdatetimet[1] . ' ' . $fspitdatetimet[2]; ?></time>

                            </div>
                            
                            

                            <!-- <time><?php echo $spitdatetime1[1] . ' ' . $spitdatetime1[2]; ?></time> -->
                        </div><?php } else if (($searchModelsub['ScheduleTime'] < date('H:i:s')) && ($searchModelsub['ScheduleDate'] <= date('Y-m-d'))) {
                        ?>
                        <div class="schedule-inner">
                            <h1> <?= Html::a($searchModelsub['ProgramTitle'], $searchModelsub['VideoURL'], ['target' => ' _blank']) ?></h1>
                            <time><?php echo $spitdatetime1[1] . ' ' . $spitdatetime1[2]; ?></time>
                        </div>
    <?php } else if (($searchModelsub['ScheduleDate'] < date('Y-m-d'))) {
       
        ?>
                        <div class="schedule-inner">
                            <h1> <?= Html::a($searchModelsub['ProgramTitle'], $searchModelsub['VideoURL'], ['target' => ' _blank']) ?></h1>
                            <time><?php echo $spitdatetime1[1] . ' ' . $spitdatetime1[2]; ?></time>
                        </div>
                    <?php } else if (($searchModelsub['ScheduleDate'] > date('Y-m-d'))) {
                        ?>
                        <div class="schedule-inner">
                            <h1><?= Html::a($searchModelsub['ProgramTitle'], $searchModelsub['VideoURL'], ['target' => ' _blank']) ?></h1>
                            <time><?php echo $spitdatetime1[1] . ' ' . $spitdatetime1[2]; ?></time>
                        </div>
                    <?php } else if (($searchModelsub['ScheduleTime'] > date('H:i:s'))) { ?>
                        <div class="schedule-inner">
                            <h1><?= Html::a($searchModelsub['ProgramTitle'], $searchModelsub['VideoURL'], ['target' => ' _blank']) ?></h1>
                            <time><?php echo $spitdatetime1[1] . ' ' . $spitdatetime1[2]; ?></time>
                        </div>
                        <div></div>
        <?php
    }
}
                }
?>




            </div>
            </br/>
            <div class="schedule-con">

<?php
// if (isset($searchModel[0]['ScheduleDate']) && $searchModel[0]['ScheduleDate'] != '') {
//     print_r($searchModel[0]['ScheduleDate']);exit;
//     /* ---------------------Convet local time------------------------------ */
//     $date2 = $searchModel[0]['ScheduleDate'];
//     $time2 = $searchModel[0]['ScheduleFromTime'];
//     $sdatetime2 = $date2 . ' ' . $time2;
//     $convertlocaldatetime2 = ConvertDateTolocaltime($sdatetime2);
//     $spitdatetime2 = explode(" ", $convertlocaldatetime2);
//     /* -------------- DISPLAY DATE ,time -------------------- */
//     $convertdate2 = $spitdatetime2[0];
//     $converttime2 = $spitdatetime2[1];


//   $previusdate = date('Y-m-d', strtotime($convertdate2 . "-1 days"));
//   $nextdate = date('Y-m-d', strtotime($convertdate2 . "+1 days"));
// } else {

    $previusdate = date('Y-m-d', strtotime(Yii::$app->getRequest()->getQueryParam('sdate') . "-1 days"));
    $nextdate = date('Y-m-d', strtotime(Yii::$app->getRequest()->getQueryParam('sdate') . "+1 days"));
// }
?>
                <?= Html::a(Yii::t('frontend', 'previous'), ['schedule/' . $previusdate], ['class' => 'btn btn-success']) ?>

                <div class="pull-right right-dir"><?= Html::a(Yii::t('frontend', 'next'), ['schedule/' . $nextdate], ['class' => 'btn btn-success']) ?></div>
            </div>

        </div>
    </div>
</div>
</div>
