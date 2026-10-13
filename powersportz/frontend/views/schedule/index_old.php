<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

date_default_timezone_set("Asia/Kolkata");
$cookies = Yii::$app->request->cookies;
?>
<!--<h1>schedule/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>-->
<script type="text/javascript" src='http://content.jwplatform.com/libraries/DkwOvSfA.js'></script>
<?php
$this->title = Yii::t('frontend', 'Schedule');
$this->params['breadcrumbs'][] = $this->title;
$mainvideovar = '';
$Rightcoloumnvar = '';
$displayindexvar = count($searchModel);
//echo "<pre>"; print_r($searchModel);die;
$VideoID = $searchModelmain['VideoID'];
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
?>
    <?php 
     $newtitle = str_replace(' ', '+',$searchModelmain['Title']);
$socialcontentvar="<ul class='socialiconsul'>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModelmain['ID']."' data-url='http://www.facebook.com/share.php?u=".Yii::$app->params['domainName'].Url::current()."&title=".$searchModelmain['Title']."'><i class='fa fa-facebook'></i></a></li>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModelmain['ID']."' data-url='https://plus.google.com/share?url=".Yii::$app->params['domainName'].Url::current()."'><i class='fa fa-google-plus'></i></a></li>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModelmain['ID']."' data-url='http://twitter.com/share?text=".$newtitle."&url=".Yii::$app->params['domainName'].Url::current()."'><i class='fa fa-twitter'></i></a></li>"
."<li><a href='#' id='pintrestshare' class='socialsharebutton' data-videoid='".$searchModelmain['ID']."' data-url='http://pinterest.com/pin/create/bookmarklet/?media=".S3_VIDEO_BUCKETABSOLUTE_PATH . $searchModelmain['ImageName'] ."&url=http://stackoverflow.com/questions/22728051/sharing-image-on-pinterst-from-bundle-getting-not-valid-url-format&is_video=false&description=".$searchModelmain['Title']."'><i class='fa fa-pinterest'></i></a></li>"
."<li><a href='#' class='socialsharebutton' data-videoid='".$searchModelmain['ID']."' data-url='http://www.linkedin.com/shareArticle?mini=true&url=".Yii::$app->params['domainName'].Url::current()."&title=".$searchModelmain['Title']."&source=[SOURCE/DOMAIN]'><i class='fa fa-linkedin'></i></a></li></ul>";
?>
<div class="col-md-11 single-page">
    <div class="col-md-6">
        <div class="col-md-10 wr-video">
            <div class="video-post v-col-5"> 

                <!-- Video code starts here -->             
                <div id="myElement">Loading the player...</div>
                <?php
                $this->registerJs('
                        var checkcookievar=0;
                        var playerInstance = jwplayer("myElement");
                        playerInstance.setup({
                        file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $searchModelmain['VideoStreamURL'] . '",
                        image: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $searchModelmain['ImageName'] . '",    
                        primary: "flash",
                        type: "mp4",
                        width: "100%",
                        autostart: false,
                        advertising: {
                        client: "vast",
                        schedule: {
                            adbreak1: {
                                    offset: "pre",
                                    tag: "' . $searchModelmain['PreAdvertisementTagURL'] . '",
                            },
                            adbreak2: {
                            offset: "3",
                            tag: "' . $searchModelmain['MidAdvertisementTagURL'] . '",
                            },
                            adbreak3: {
                            offset: "post",
                            tag: "' . $searchModelmain['PostAdvertisementTagURL'] . '",
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
                        var videoid=$(this).data("videoid");
                        var urlto=$(this).data("url");
                        var URL="videolike";
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
            ');
                if ($cookies->has($searchModelmain['ID'] . 'cookies')) {
                    $varcookies = 1;
                } else {
                    $varcookies = 0;
                }
                ?>




                <div class="favourite-icon-wrap">
                    <?php
                    if (in_array('3', $actiontype)) {
                        $watchlistvar = Yii::t('frontend', 'removewatchlist');
                        echo '<div class="watch-later favourite-icon tab-active"><a href="#" id="watchlink" class="videounwatchlink" data-videoid="' . $searchModelmain["ID"] . '">';
                    } else {
                        $watchlistvar = Yii::t('frontend', 'watchlater');
                        echo '<div class="watch-later favourite-icon"><a href="#" id="watchlink" class="videowatchlink" data-videoid="' . $searchModelmain["ID"] . '">';
                    }
                    ?>
                    <img src="../images/watch-leter.png" alt="<?php echo $watchlistvar; ?>" />
                    <span class="watchlisttext"><?php echo $watchlistvar; ?></span>
                    </a></div>
                <!--<div class="favourite favourite-icon">
                   
                    <a href="#" class="videofavlink" data-videoid="<?php //echo $searchModelmain["ID"];   ?>">-->


<?php
if (in_array('2', $actiontype)) {
    $favouvar = Yii::t('frontend', 'removefavourite');
    echo '<div class="favourite favourite-icon tab-active">
            <a href="#" id="favlink" class="videounfavlink" data-videoid="' . $searchModelmain["ID"] . '">';
} else {
    $favouvar = Yii::t('frontend', 'addtofav');
    echo '<div class="favourite favourite-icon">
            <a href="#" id="favlink" class="videofavlink" data-videoid="' . $searchModelmain["ID"] . '">';
}
?>
                <img src="../images/favourite.png" alt="<?php echo $favouvar; ?>" />
                <span class="favouritetext"><?php echo $favouvar; ?></span></a></div>  
            <!-- <div class="like favourite-icon">
                
<?php
/* if ($varcookies == 0) {
  echo '<a href="#" class="videolikelink" data-videoid="' . $searchModelmain["ID"] . '">';
  } else {
  echo '<a href="#">';
  } */
?>
            -->


<?php
if (in_array('1', $actiontype)) {
    $liketextvar = Yii::t('frontend', 'unlike');
    echo '<div class="like favourite-icon tab-active"><a href="#" id="likelink" class="videounlikelink" data-videoid="' . $searchModelmain["ID"] . '">';
} else {
    $liketextvar = Yii::t('frontend', 'likethisvideo');
    /*if ($varcookies == 0) {
        echo '<div class="like favourite-icon"><a href="#" id="likelink" class="videolikelink" data-videoid="' . $searchModelmain["ID"] . '">';
    } else {
        echo '<div class="like favourite-icon tab-active"><a href="#">';
    }*/
    
        if(!Yii::$app->getUser()->isGuest){
    echo '<div class="like favourite-icon"><a href="#" id="likelink" class="videolikelink" data-videoid="'.$searchModelmain["ID"].'">';    
    }
    else{
            if($varcookies==0)
            {
    echo '<div class="like favourite-icon"><a href="#" id="likelink" class="videolikelink" data-videoid="'.$searchModelmain["ID"].'">';
            }
    else
            {
    echo '<div class="like favourite-icon tab-active"><a href="#">';
            } 
    }
}
?>
            <img src="../images/like.png" alt="<?php echo $liketextvar; ?>" />
            <i class="displynumbr"><?php echo $searchModelmain['LikeCount']; ?></i>
            <span class="liketext"><?php echo $liketextvar; ?></span>
            </a></div>




        <div class="share favourite-icon">
            <a href="#" id="sharelink" class="videosharelink" data-toggle="popover" data-videoid="<?php echo $searchModelmain["ID"];?>">
        <img src="../images/share-icon.png" alt="<?php echo Yii::t('frontend', 'sharethisvideo'); ?>" />
        <span><?php echo Yii::t('frontend', 'sharethisvideo'); ?></span>
    </a>
        </div>
    </div>
    <div class="clear"></div>


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
</div>
<div class="col-md-6">
    <div class="schedule-wraper">
        <!--<div class="schedule-type">
          <h1>Showtime East</h1>
          <h1>Showtime West</h1>
        </div>-->
        <div class="shcedule-content" id="east">
            <div class="schedule-inner">
                <h2><?php echo Yii::t('frontend', 'Onnow'); ?></h2>
                <h1><?php echo $searchModelmain['ProgramTitle']; ?></h1>
                <span><?php echo date('l, F d', strtotime($searchModelmain['ScheduleDate'])); ?></span>
                <time><?php echo date("g:i a", strtotime($searchModelmain['ScheduleTime'])); ?></time>
            </div>



<?php if (isset($searchModel[0]['ScheduleDate']) && $searchModel[0]['ScheduleDate'] != '') { ?>
                <h2></h2>
                <h1><?php echo date('l, F d', strtotime($searchModel[0]['ScheduleDate'])); ?>&nbsp;&nbsp;&nbsp;</h1>
                <input type="hidden" id="sdpredate" name="sdpredate" value="<?php echo date('Y-m-d', strtotime($searchModel[0]['ScheduleDate'] . "-1 days")); ?>"/>
                <input type="hidden" id="sdnxtdate" name="sdnxtdate" value="<?php echo date('Y-m-d', strtotime($searchModel[0]['ScheduleDate'] . "+1 days")); ?>"/>
    <?php
} else {
    echo '<br/>';
    if(!Yii::$app->getRequest()->getQueryParam('sdate')){
    echo "No records avaibles for " . date('l, F d');
    }else{
        echo "No records avaibles for " . date('l, F d', strtotime(Yii::$app->getRequest()->getQueryParam('sdate')));
    }
}
?>


            <div class="schedule-con">


                <!--<div class="schedule-inner">
                           <h2>On Now</h2>
                      <h1><?php //echo $searchModelmain['ProgramTitle'];   ?></h1>
                      <span><?php //echo date("g:i a", strtotime($searchModelmain['ScheduleTime']));  ?></span>
                      <time><?php //echo date('d-M-Y',strtotime($searchModelmain['ScheduleDate']));     ?></time>
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
<?php foreach ($searchModel as $key => $searchModelsub) { ?>

                    <?php if (($searchModelsub['ScheduleTime'] < date('H:i:s')) && ($searchModelsub['ScheduleDate'] <= date('Y-m-d'))) { ?>
                        <div class="schedule-inner">
                       <?php  if($searchModelsub['PublishDate']<= date('Y-m-d H:i:s')){ ?>
                            <h1> <?= Html::a($searchModelsub['ProgramTitle'], ['/video/index?id=' . $searchModelsub['VideoID']], ['target' => ' _blank']) ?></h1>
                         <?php }else{?>
                             <h1><?php echo $searchModelsub['ProgramTitle']; ?></h1>
                        <?php   }?>
                          
                            <span><?php echo date('d-M-Y', strtotime($searchModelsub['ScheduleDate'])); ?></span>
                            <time><?php echo date("g:i a", strtotime($searchModelsub['ScheduleTime'])); ?></time>
                        </div>
                    <?php } else if (($searchModelsub['ScheduleTime'] > date('H:i:s')) && ($searchModelsub['ScheduleDate'] < date('Y-m-d'))) {
                        ?>
                        <div class="schedule-inner">
                           <?php  if($searchModelsub['PublishDate']<= date('Y-m-d H:i:s')){ ?>
                            <h1> <?= Html::a($searchModelsub['ProgramTitle'], ['/video/index?id=' . $searchModelsub['VideoID']], ['target' => ' _blank']) ?></h1>
                         <?php }else{?>
                             <h1><?php echo $searchModelsub['ProgramTitle']; ?></h1>
                        <?php   }?>
                             <span><?php echo date('d-M-Y', strtotime($searchModelsub['ScheduleDate'])); ?></span>
                            <time><?php echo date("g:i a", strtotime($searchModelsub['ScheduleTime'])); ?></time>
                        </div>
    <?php } else if (($searchModelsub['ScheduleTime'] > date('H:i:s'))) { ?>
                        <div class="schedule-inner">
                            <h1><?php echo $searchModelsub['ProgramTitle']; ?></h1>
                            <span><?php echo date('d-M-Y', strtotime($searchModelsub['ScheduleDate'])); ?></span>
                            <time><?php echo date("g:i a", strtotime($searchModelsub['ScheduleTime'])); ?></time>
                        </div>



                    <?php
                    }
                }
                ?>




            </div>
            </br/>
            <div class="schedule-con">
                <?php
                if (isset($searchModel[0]['ScheduleDate']) && $searchModel[0]['ScheduleDate'] != '') {
                    $previusdate = date('Y-m-d', strtotime($searchModel[0]['ScheduleDate'] . "-1 days"));
                    $nextdate = date('Y-m-d', strtotime($searchModel[0]['ScheduleDate'] . "+1 days"));
                } else {

                    $previusdate = date('Y-m-d', strtotime(Yii::$app->getRequest()->getQueryParam('sdate') . "-1 days"));
                    $nextdate = date('Y-m-d', strtotime(Yii::$app->getRequest()->getQueryParam('sdate') . "+1 days"));
                }
                ?>
                <?= Html::a(Yii::t('frontend', 'previous'), ['/schedule/index?sdate=' . $previusdate], ['class' => 'btn btn-success']) ?>

                <div class="pull-right"><?= Html::a(Yii::t('frontend', 'next'), ['/schedule/index?sdate=' . $nextdate], ['class' => 'btn btn-success']) ?></div>
            </div>

        </div>
    </div>
</div>
</div>

<script>
    function getPreviousdaySchedule() {
        $("#spinnerLoader").show();
        var sdpredate = $('#sdpredate').val();
        //  alert(sdpredate);return false;

        var datastring = 'sdpredate=' + sdpredate;
        $.ajax({
            type: 'POST',
            url: '<?php echo Url::to(['/schedule/index']); ?>',
            data: datastring,
            success: function (msg) {
                location.reload();
                //  $("#spinnerLoader").hide();
            }
        });
    }

    function getNextdaySchedule() {
        var sdnxtdate = $('#sdnxtdate').val();
        //alert(sdnxtdate);return false;
        var datastring = 'sdnxtdate=' + sdnxtdate;
        $.ajax({
            type: 'POST',
            url: '<?php echo Url::to(['/schedule/index']); ?>',
            data: datastring,
            success: function (msg) {
                alert(msg);
                return false;
            }
        });
    }
    /*function getMerchantType(t) {
     
     if(t.value == ''){
     $("#mtype").val('');
     $("#mtypeID").val('');
     $("#mydiv").hide();
     return false;
     }
     
     var MerchantID = t.value;
     
     var cattext,typeID;
     var datastring  = 'MerchantID='+MerchantID;
     $.ajax({
     type : 'POST',
     url  :  '<?php //echo Yii::app()->createUrl('memberreceipt/getMerchantType');    ?>',
     data : datastring,
     success : function(msg) {
     $("#mtype").val(msg);
     if(msg == "Non-applicable") {
     typeID = 0;
     }
     if(msg == "General") {
     typeID = 1;
     }
     if(msg == "Dining") {
     typeID = 2;
     }
     if(msg == "Supermarket") {
     typeID = 3;
     }
     $("#mtypeID").val(typeID);
     $("#mydiv").hide();
     }
     });
     }
     */

</script>
