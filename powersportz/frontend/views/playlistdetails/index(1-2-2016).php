<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PlaylistsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$cookies = Yii::$app->request->cookies;
$actiontype = array();
$adurl1='';$adurl2='';$adurl3='';
if (!empty($modelMember)) {
    foreach ($modelMember as $modelMemberarray) {
        array_push($actiontype, $modelMemberarray['Type']);
    }
}
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
                            var URL="'.Url::toRoute(["video/videolike"]).'";
                            $(this).toggleClass("videolikelink");
                            $(this).parent("div").addClass("tab-active");
                            $(".liketext").text("' . Yii::t("frontend", "unlike") . '");
                }
                else
                {
                            var URL="'.Url::toRoute(["video/videounlike"]).'";
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
                            var URL="'.Url::toRoute(["video/videolike"]).'";
                            $(this).toggleClass("videowatchlink");
                            $(this).parent("div").addClass("tab-active");
                            $(".watchlisttext").text("' . Yii::t("frontend", "removewatchlist") . '");
                }
                else
                {
                                var URL="'.Url::toRoute(["video/videounlike"]).'";
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
                            var URL="'.Url::toRoute(["video/videolike"]).'";
                            $(this).toggleClass("videofavlink");
                            $(this).parent("div").addClass("tab-active");
                            $(".favouritetext").text("' . Yii::t("frontend", "removefavourite") . '");
                }
                else
                {
                        var URL="'.Url::toRoute(["video/videounlike"]).'";
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
?>
<script type="text/javascript" src='http://content.jwplatform.com/libraries/DkwOvSfA.js'></script>
<?php
$this->title = Yii::t('frontend', 'PlaylistDetails');
$this->params['breadcrumbs'][] = $this->title;
$mainvideovar = '';
$Rightcoloumnvar = '';
$displayindexvar = count($searchModel);
foreach ($searchModel as $key => $searchModelsub) {
    $key1 = $key + 1;
    $ismainvar = '0';
    if (Yii::$app->getRequest()->getQueryParam('video')) {
        $videoid = Yii::$app->getRequest()->getQueryParam('video');
        if (in_array($videoid, $searchModelsub)) {
// Check the availability of the cookie
            if ($cookies->has($videoid . 'cookies')) {
                $varcookies = 1;
            } else {
                $varcookies = 0;
            }
$adurmidtime=$searchModelsub['StartMidAdvertisementTime'];
if(!empty($Customadvertise)){
            foreach($Customadvertise as $Customadvertisesub){
                    $customadarraylist[$Customadvertisesub['Type']]=$Customadvertisesub['XML'];
                    $customadarraylist['Time']=$Customadvertisesub['MidTime'];
        }
        if (array_key_exists("1",$customadarraylist)){
                    $adurl1= Yii::$app->params['domainName'].'powersportz/upload/xml/'.$customadarraylist['1'].'.xml';
        }
                if (array_key_exists("2",$customadarraylist)){
                    $adurl2= Yii::$app->params['domainName'].'powersportz/upload/xml/'.$customadarraylist['2'].'.xml';
                    $adurmidtime=$customadarraylist['Time'];
        }
                if (array_key_exists("3",$customadarraylist)){
                    $adurl3= Yii::$app->params['domainName'].'powersportz/upload/xml/'.$customadarraylist['3'].'.xml';
        }
}
else{
    $adurl1= $searchModelsub['PreAdvertisementTagURL'];
    $adurl2= $searchModelsub['MidAdvertisementTagURL'];
    $adurl3= $searchModelsub['PostAdvertisementTagURL'];
}
$newtitle = str_replace(' ', '+',$searchModelsub['Title']);
$socialcontentvar="<ul class='socialiconsul'>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModelsub['ID']."' data-url='http://www.facebook.com/share.php?u=".Yii::$app->params['domainName'].Url::current()."&title=".$searchModelsub['Title']."'><i class='fa fa-facebook'></i></a></li>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModelsub['ID']."' data-url='https://plus.google.com/share?url=".Yii::$app->params['domainName'].Url::current()."'><i class='fa fa-google-plus'></i></a></li>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModelsub['ID']."' data-url='http://twitter.com/share?text=".$newtitle."&url=".Yii::$app->params['domainName'].Url::current()."'><i class='fa fa-twitter'></i></a></li>"
."<li><a href='#' id='pintrestshare' class='socialsharebutton' data-videoid='".$searchModelsub['ID']."' data-url='http://pinterest.com/pin/create/bookmarklet/?media=".S3_VIDEO_BUCKETABSOLUTE_PATH .$searchModelsub['ImageName'] ."&url=http://stackoverflow.com/questions/22728051/sharing-image-on-pinterst-from-bundle-getting-not-valid-url-format&is_video=false&description=".$searchModelsub['Title']."'><i class='fa fa-pinterest'></i></a></li>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModelsub['ID']."' data-url='http://www.linkedin.com/shareArticle?mini=true&url=".Yii::$app->params['domainName'].Url::current()."&title=".$searchModelsub['Title']."&source=[SOURCE/DOMAIN]'><i class='fa fa-linkedin'></i></a></li></ul>";
            $ismainvar = '1';
            $mainvideovar.='<div class="col-md-7" style="position:relative">
                <div class="col-md-12 wr-video">
                <div class="v-col-5">
                <div class="overlapdiv">
        <p class="reloadbutton"><a href="#" class="reloadlink"><i class="fa fa-refresh"></i></a></p>
        <p class="showfullvideo"><a href="'.Url::toRoute(['video/index', 'videoid' =>$searchModelsub['FullVideoId']]).'">'.Yii::t('frontend','watchfullvideo').'</a></p></div>
                <div id="containerForShortVideo">Loading the player...</div>';
            ?><?php $mainvideovar.= $this->registerJs('
                                        var playerInstance = jwplayer("containerForShortVideo");
                                        playerInstance.setup({
                                        file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $searchModelsub['VideoStreamURL'] . '",
                                        image: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $searchModelsub['ImageName'] . '",    
                                        primary: "flash",
                                        type: "mp4",
                                        autostart: false,
                                        width: "100%",
                                        advertising: {
                                        client: "vast",
                                        schedule: {
                                        adbreak1: {
                                        offset: "pre",
                                        tag: "' .$adurl1. '", 
                                        },
                                    adbreak2: {
                                        offset: "'.$adurmidtime.'",
                                        tag: "'.$adurl2. '",
                                        },
                                    adbreak3: {
                                        offset: "post",
                                        tag: "' .$adurl3. '",
                                        },
                                          }
                                      }
                                        });');
        if($searchModelsub['FullVideoId']!=''){
        $mainvideovar.=$this->registerJs('playerInstance.onComplete(function(){$(".overlapdiv").show();});');
        }
        $mainvideovar.=$this->registerJs('$(document).on("click", ".socialsharebutton", function() {
                        var videoid=$(this).data("videoid");
                        var urlto=$(this).data("url");
                        var URL="'.Url::toRoute(["video/videolike"]).'";
                        $.ajax({
                        type: "POST",
                        data: {Videoid:videoid,Type:4},
                        url: URL,
                        success: function(msg){
                        var win=window.open(urlto,"_blank");
                        win.focus();
                        }
                });
                });
            $("[data-toggle=\'popover\']").popover({
                    placement : "bottom",
                    container: "body",
                    title:"Be Social",
                    html : true,
                    content:"'.$socialcontentvar.'",
                });
            '); ?>
            <?php
            $mainvideovar.='<div class="favourite-icon-wrap">';
            if (in_array('3', $actiontype)) {
                $watchlistvar = Yii::t('frontend', 'removewatchlist');
                $mainvideovar.='<div class="watch-later favourite-icon tab-active"><a href="#" id="watchlink" class="videounwatchlink" data-videoid="' . $searchModelsub["ID"] . '">';
            } else {
                $watchlistvar = Yii::t('frontend', 'watchlater');
                $mainvideovar.='<div class="watch-later favourite-icon"><a href="#" id="watchlink" class="videowatchlink" data-videoid="' . $searchModelsub["ID"] . '">';
            }
            $mainvideovar.='<img src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/watch-leter.png" alt="' . $watchlistvar . '" />
             <span class="watchlisttext">' . $watchlistvar . '</span>
             </a>
             </div>';
            if (in_array('2', $actiontype)) {
                $favouvar = Yii::t('frontend', 'removefavourite');
                $mainvideovar.='<div class="favourite favourite-icon tab-active">
            <a href="#" id="favlink" class="videounfavlink" data-videoid="' . $searchModelsub["ID"] . '">';
            } else {
                $favouvar = Yii::t('frontend', 'addtofav');
                $mainvideovar.='<div class="favourite favourite-icon">
            <a href="#" id="favlink" class="videofavlink" data-videoid="' . $searchModelsub["ID"] . '">';
            }
            $mainvideovar.='<img src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/favourite.png" alt="' . $favouvar . '" />
             <span class="favouritetext">' . $favouvar . '</span>
             </a></div>';
            if (in_array('1', $actiontype)) {
                
                $mainvideovar.='<div class="like favourite-icon tab-active"><a href="#" id="likelink" class="videounlikelink" data-videoid="' . $searchModelsub["ID"] . '">';
            } else {
               
                if (!Yii::$app->getUser()->isGuest) {
                     $liketextvar = Yii::t('frontend', 'likethisvideo');
                    $mainvideovar.='<div class="like favourite-icon"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModelsub["ID"] . '">';
                } else {
                    if ($varcookies == 0) {
                         $liketextvar = Yii::t('frontend', 'likethisvideo');
                        $mainvideovar.='<div class="like favourite-icon"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModelsub["ID"] . '">';
                    } else {
                        $liketextvar = Yii::t('frontend', 'unlike');
                        $mainvideovar.='<div class="like favourite-icon tab-active"><a href="#"  id="likelink" data-videoid="' . $searchModelsub["ID"] . '">';
                    }
                }
            }
            $mainvideovar.= '<img src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/like.png" alt="' . $liketextvar . '" />
                                <i class="displynumbr">' . $searchModelsub['LikeCount'] . '</i>
                                <span class="liketext">' . $liketextvar . '</span>
                               </a></div>
                                        <div class="share favourite-icon">
                                        <a href="#" id="sharelink" class="videosharelink" data-toggle="popover" data-videoid="'.$searchModelsub["ID"].'"> 
                                        <img src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/share-icon.png" alt="' . Yii::t('frontend', 'sharethisvideo') . '" />
                                        <span>' . Yii::t('frontend', 'sharethisvideo') . '</span>
                                        </a>
                                        </div>';
            if($searchModelsub['AllowDownload']=='1'){
    $mainvideovar.= '<div class="share favourite-icon">
    <a href="'.Url::toRoute(['video/downloadvideo', 'videoid' => $searchModelsub['ID']]).'"><span>'.Yii::t('frontend', 'downlodthisvideo').'</span>
    </a></div>';
}
                        $mainvideovar.= '</div>
                                        <div class="clear"></div>
                                        <div class="data">
                                        <p>' . $searchModelsub['Title'] . '</p>
                                        <span>28:45</span> </div>
                                        </div>
                                        <p class="playlists-peragraph">
                                        ' . $searchModelsub['Description'] . '
                                        </p>
                                        </div></div>';
        }
    } else {
        if ($mainvideovar == '') {
            // Check the availability of the cookie
            if ($cookies->has($searchModel[0]["ID"] . 'cookies')) {
                $varcookies = 1;
            } else {
                $varcookies = 0;
            }
$newtitle = str_replace(' ', '+',$searchModel[0]['Title']);
$socialcontentvar="<ul class='socialiconsul'>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModel[0]['ID']."' data-url='http://www.facebook.com/share.php?u=".Yii::$app->params['domainName'].Url::current()."&title=".$searchModel[0]['Title']."'><i class='fa fa-facebook'></i></a></li>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModel[0]['ID']."' data-url='https://plus.google.com/share?url=".Yii::$app->params['domainName'].Url::current()."'><i class='fa fa-google-plus'></i></a></li>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModel[0]['ID']."' data-url='http://twitter.com/share?text=".$newtitle."&url=".Yii::$app->params['domainName'].Url::current()."'><i class='fa fa-twitter'></i></a></li>"
."<li><a href='#' id='pintrestshare' class='socialsharebutton' data-videoid='".$searchModel[0]['ID']."' data-url='http://pinterest.com/pin/create/bookmarklet/?media=".S3_VIDEO_BUCKETABSOLUTE_PATH .$searchModel[0]['ImageName'] ."&url=http://stackoverflow.com/questions/22728051/sharing-image-on-pinterst-from-bundle-getting-not-valid-url-format&is_video=false&description=".$searchModel[0]['Title']."'><i class='fa fa-pinterest'></i></a></li>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModel[0]['ID']."' data-url='http://www.linkedin.com/shareArticle?mini=true&url=".Yii::$app->params['domainName'].Url::current()."&title=".$searchModel[0]['Title']."&source=[SOURCE/DOMAIN]'><i class='fa fa-linkedin'></i></a></li></ul>";
$ismainvar = '1';
$midadvertime=$searchModel[0]['StartMidAdvertisementTime'];
if(!empty($Customadvertise)){
   $adurl1= Yii::$app->params['domainName'].'powersportz/upload/xml/'.$Customadvertise[0]['XML'].'.xml';
   $adurl2= Yii::$app->params['domainName'].'powersportz/upload/xml/'.$Customadvertise[0]['XML'].'.xml';
   $adurl3= Yii::$app->params['domainName'].'powersportz/upload/xml/'.$Customadvertise[0]['XML'].'.xml';
   //Yii::$app->
}
else{
    $adurl1= $searchModel[0]['PreAdvertisementTagURL'];
    $adurl2= $searchModel[0]['MidAdvertisementTagURL'];
    $adurl3= $searchModel[0]['PostAdvertisementTagURL'];
}
            $mainvideovar.='<div class="col-md-7">
            <div class="col-md-12 wr-video">
            <div class="v-col-5" style="position:relative">
            <div class="overlapdiv">
        <p class="reloadbutton"><a href="#" class="reloadlink"><i class="fa fa-refresh"></i></a></p>
        <p class="showfullvideo"><a href="'.Url::toRoute(['video/index', 'videoid' =>$searchModel[0]['FullVideoId']]).'">'.Yii::t('frontend','watchfullvideo').'</a></p></div>
                    <div id="myElement">Loading the player...</div>';
            ?><?php $mainvideovar.= $this->registerJs('
                var playerInstance = jwplayer("myElement");
                playerInstance.setup({
                    file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $searchModel[0]['VideoStreamURL'] . '",
                    image: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $searchModel[0]['ImageName'] . '",    
                    primary: "flash",
                    autostart: false,
                    type: "mp4",
                    width: "100%",
                    advertising: {
                          client: "vast",
                          schedule: {
                        adbreak1: {
                            offset: "pre",
                            tag: "' .$adurl1. '", 
                            },
                        adbreak2: {
                            offset: "'.$midadvertime.'",
                            tag: "' .$adurl2. '",
                            },
                        adbreak3: {
                            offset: "post",
                            tag: "' .$adurl3. '",
                            },
                            }
                    }
                });');
                    if($searchModel[0]['FullVideoId']!=''){
        $mainvideovar.=$this->registerJs('playerInstance.onComplete(function(){$(".overlapdiv").show();});');
        }
                $mainvideovar.= $this->registerJs('$(document).on("click", ".socialsharebutton", function() {
                        var videoid=$(this).data("videoid");
                        var urlto=$(this).data("url");
                        var URL="'.Url::toRoute(["video/videolike"]).'";
                        $.ajax({
                        type: "POST",
                        data: {Videoid:videoid,Type:4},
                        url: URL,
                        success: function(msg){
                        var win=window.open(urlto,"_blank");
                        win.focus();
                        }
                        });
                        });
                $("[data-toggle=\'popover\']").popover({
                    placement : "bottom",
                    container: "body",
                    title:"Be Social",
                    html : true,
                    content:"'.$socialcontentvar.'",
                });
            '); ?>
            <?php
            $mainvideovar.='<div class="favourite-icon-wrap">';
            if (in_array('3', $actiontype)) {
                $watchlistvar = Yii::t('frontend', 'removewatchlist');
                $mainvideovar.='<div class="watch-later favourite-icon tab-active"><a href="#" id="watchlink" class="videounwatchlink" data-videoid="' . $searchModel[0]["ID"] . '">';
            } else {
                $watchlistvar = Yii::t('frontend', 'watchlater');
                $mainvideovar.='<div class="watch-later favourite-icon"><a href="#" id="watchlink" class="videowatchlink" data-videoid="' . $searchModel[0]["ID"] . '">';
            }
            $mainvideovar.='<img src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/watch-leter.png" alt="' . $watchlistvar . '"/>
           <span class="watchlisttext">' . $watchlistvar . '</span>
           </a></div>';
            if (in_array('2', $actiontype)) {
                $favouvar = Yii::t('frontend', 'removefavourite');
                $mainvideovar.='<div class="favourite favourite-icon tab-active">
            <a href="#" id="favlink" class="videounfavlink" data-videoid="' . $searchModelsub["ID"] . '">';
            } else {
                $favouvar = Yii::t('frontend', 'addtofav');
                $mainvideovar.='<div class="favourite favourite-icon">
            <a href="#" id="favlink" class="videofavlink" data-videoid="' . $searchModelsub["ID"] . '">';
            }
            $mainvideovar.='<img src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/favourite.png" alt="' . $favouvar . '" />
           <span class="favouritetext">' . $favouvar . '</span>
           </a></div>';
            if (in_array('1', $actiontype)) {
               

            $mainvideovar.='<div class="like favourite-icon tab-active"><a href="#" id="likelink" class="videounlikelink" data-videoid="' . $searchModel[0]["ID"] . '">';
            } else {
               
            if (!Yii::$app->getUser()->isGuest) {
                 $liketextvar = Yii::t('frontend', 'likethisvideo');
            $mainvideovar.='<div class="like favourite-icon"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModel[0]["ID"] . '">';
            }
            else{
            if ($varcookies == 0) {
                 $liketextvar = Yii::t('frontend', 'likethisvideo');
            $mainvideovar.='<div class="like favourite-icon"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                } else {
                     $liketextvar = Yii::t('frontend', 'unlike');
            $mainvideovar.='<div class="like favourite-icon tab-active"><a href="#" id="likelink" data-videoid="' . $searchModel[0]["ID"] . '">';
                }                    
                }

            }
            $mainvideovar.='<img src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/like.png" alt="' . $liketextvar . '" />
                    <i class="displynumbr">' . $searchModel[0]['LikeCount'] . '</i>
                    <span class="liketext">' . $liketextvar . '</span>
                    </a></div>
                    <div class="share favourite-icon">
                    <a href="#" id="sharelink" class="videosharelink" data-toggle="popover" data-videoid="'.$searchModel[0]["ID"].'">
                    <img src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/share-icon.png" alt="' . Yii::t('frontend', 'sharethisvideo') . '" />
                    <span>' . Yii::t('frontend', 'sharethisvideo') . '</span>
                    </a>
                    </div>';
                        if($searchModel[0]['AllowDownload']=='1'){
    $mainvideovar.= '<div class="share favourite-icon">
    <a href="'.Url::toRoute(['video/downloadvideo', 'videoid' => $searchModel[0]['ID']]).'"><span>'.Yii::t('frontend', 'downlodthisvideo').'</span>
    </a></div>';
}
            $mainvideovar.= '</div>
                    <div class="clear"></div>
                    <div class="data">
                        <p>' . $searchModel[0]['Title'] . '</p>
                        <span>28:45</span> </div>
                </div>
                <p class="playlists-peragraph">
                ' . $searchModel[0]['Description'] . '
                </p>
            </div></div>';
        }
    }
    if ($ismainvar == '0') {
        $Rightcoloumnvar.='<!----Single playlist post ------->
                        <div class="playlists-single-wraper" id="' . $key1 . '">
                        <span class="div" data-index="' . $displayindexvar . '"></span> 
                        <a href="' .Yii::$app->urlManager->createUrl(['playlistdetails/index','id' =>$searchModelsub['PlaylistId'],'video'=>$searchModelsub['ID']]).'">
                        <div class="col-md-4 playlists-img-wraper">
                        <img src="' . S3_VIDEO_BUCKETABSOLUTE_PATH . $searchModelsub['ImageName'] . '" style="width:100%;" alt="" />
                        </div>
                        <div class="col-md-8 playlists-name-wraper">
                        <h1>' . $searchModelsub['Title'] . '</h1>
                        </div></a></div>
                    <!----Single playlist post ------->';
    }
    $displayindexvar--;
}
?>
<script type="text/javascript" src='http://content.jwplatform.com/libraries/DkwOvSfA.js'></script>
<!--New Video-->
<section class="color-bg wow fadeInDown" >
    <div class="col-md-11 single-page"> 
        <!--Left Sidebar -->
<?php echo $mainvideovar; ?>
        <!-- Right Sidebar -->
        <div class="col-md-5">
            <div class="playlists-wraper">
                <div class="heading">
                    <h1><?php echo $searchModel[0]['PlayListTitle']; ?> <span style="cursor:pointer" class="pull-right" id="sDiv" asc="down"><i class="fa fa-sort-asc" id="sorticonid"></i></span></h1>
                </div>
                <div class="small-playlists-wraper" id="sortThis">
<?php echo $Rightcoloumnvar; ?>
                </div>
            </div>
        </div>
    </div></div>
</section>
<script type="text/javascript">


ga('send', {
  hitType: 'event',
  eventCategory: '<?php echo $searchModel[0]["PlayListTitle"]; ?>',
  eventAction: 'Playlist',
  eventLabel: '<= $searchModel[0]["Title"]; ?>',
  eventValue : location.pathname,
});


/*ga('send', {
  hitType: 'pageview',
  title: 'Video - <?= $searchModel[0]["Title"]; ?>',
  location: location.pathname,
});*/

</script>
