<?php
$this->registerJsFile('../js/endless_scroll_min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
$this->title = Yii::t('frontend','Home').' ';
$notinarray=array();
$notincategory=array();
$adurl1='';$adurl2='';$adurl3='';
if($HomePageModel->MainVideoType=='1'){
    array_push($notinarray,$HomePageModel->VideoID);
}
if(!empty($Categorygeographics)){
    foreach($Categorygeographics as $Categorygeographicsarray){
        if(!empty($Categorygeographicsarray)){
array_push($notincategory, $Categorygeographicsarray['CategID']);    
        }
    }
}
$HomePageModel->scroll_time = $HomePageModel->scroll_time * 10;
?>
<script type="text/javascript" src='https://content.jwplatform.com/libraries/VsYqPT7i.js'></script>
<style>
  /* FIX: JW Player floating overlay blocks click events on play button */
  .jw-floating-dismissible,
  .jw-keep-thumbnail {
    pointer-events: none !important;
  }
  /* Ensure actual JW Player controls remain clickable */
  .jw-controls,
  .jw-display,
  .jw-display-icon-container,
  .jw-icon-display,
  .jw-controlbar,
  .jw-button-container {
    pointer-events: auto !important;
    z-index: 20 !important;
    position: relative !important;
  }
  /* Player container z-index */
  #containerForShortVideo,
  .jwplayer {
    position: relative !important;
    z-index: 10 !important;
  }
  /* Thumbnail/poster overlay - allow clicks to pass through to play button */
  .jw-media,
  .jw-preview {
    pointer-events: none !important;
  }
  .jw-display {
    pointer-events: auto !important;
  }
</style>
<div class="site-index no_main_video">
<?php
            echo '<div class="container-fluid wow fadeInDown">
                    <div class="row">
                    <div class="col-md-12 my-slider">';
             if(empty($Videogeographics)){
                    echo '<div id="containerForShortVideo">Loading the player...</div>';
}
else{	
      echo '<div class="error-video-imgideo-msg clearfix" style="width:100%">
          <div class="error-video-img"><img src="../images/video-error-img.png" alt="error-img"></div>
          <div class="error-video-text">
            <p>'.Yii::t('frontend','VideoNotAvailable').'</p>
          </div>
      </div>
      ';
}
         
     
        if(!empty($VideoDetails)){ 
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
            'content' => Main_VideoUrl(ImagesUrl($VideoDetails[0]))
        ]);
             Yii::$app->view->registerMetaTag([
            'name' => 'og:title',
            'content' => $VideoDetails[0]['Title']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:description',
            'content' => $VideoDetails[0]['description']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'og:image',
            'content' =>Main_VideoUrl(ImagesUrl($VideoDetails[0]))
        ]);
                \Yii::$app->view->registerMetaTag([
            'name' => 'twitter:card',
            'content' =>  Main_VideoUrl(ImagesUrl($VideoDetails[0]))
        ]);
  Yii::$app->view->registerMetaTag([
            'name' => 'twitter:title',
            'content' => $VideoDetails[0]['Title']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:description',
            'content' =>  $VideoDetails[0]['description']
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'twitter:image',
            'content' => Main_VideoUrl(ImagesUrl($VideoDetails[0]))
        ]);
            if(empty($Videogeographics)){
                $adurmidtime=$VideoDetails[0]['StartMidAdvertisementTime'];
                if(!empty($Customadvertise)){
        foreach($Customadvertise as $Customadvertisesub){
                    $customadarraylist[$Customadvertisesub['Type']]=$Customadvertisesub['XML'];
                    $customadarraylist['Time']=$Customadvertisesub['MidTime'];
        }
        if (array_key_exists("1",$customadarraylist)){
                    $adurl1=CustomAdvertisePath().$customadarraylist['1'].'.xml';
        }
        else{
             $adurl1= $VideoDetails[0]['PreAdvertisementTagURL'];
        }
        if (array_key_exists("2",$customadarraylist)){
                    $adurl2=CustomAdvertisePath().$customadarraylist['2'].'.xml';
                    $adurmidtime=$customadarraylist['Time'];
        }
        else{
                    $adurl2= $VideoDetails[0]['MidAdvertisementTagURL'];
                    $adurmidtime=$VideoDetails[0]['StartMidAdvertisementTime'];
        }
                if (array_key_exists("3",$customadarraylist)){
                    $adurl3=CustomAdvertisePath().$customadarraylist['3'].'.xml';
        }
        else{
                    $adurl3= $VideoDetails[0]['PostAdvertisementTagURL'];
        }
}
else{
    $customadarraylist=array();
                    $adurl1= $VideoDetails[0]['PreAdvertisementTagURL'];
                    $adurl2= $VideoDetails[0]['MidAdvertisementTagURL'];
                    $adurl3= $VideoDetails[0]['PostAdvertisementTagURL'];
}
    
                    $highResolutionURL = str_replace('mp4_','hls1080m_',$VideoDetails[0]['VideoStreamURL']);
                    $highmediumResolutionURL = str_replace('mp4_','hls720m_',$VideoDetails[0]['VideoStreamURL']);
                    $mediumResolutionURL = str_replace('mp4_','hls480m_',$VideoDetails[0]['VideoStreamURL']);
                    $lowmediumResolutionURL = str_replace('mp4_','hls360m_',$VideoDetails[0]['VideoStreamURL']);
                    $lowResolutionURL = str_replace('mp4_','hls240m_',$VideoDetails[0]['VideoStreamURL']);
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
                    var playerInstance = jwplayer("containerForShortVideo");
                    playerInstance.setup({
                    image: "' .Main_VideoUrl(ImagesUrl($VideoDetails[0])). '",  
                    file:"'.S3_VIDEO_BUCKETABSOLUTE_PATH_AUTO. $VideoDetails[0]['VideoStreamURL'].'.m3u8",                            
                    autostart: false,
                    width: "100%",
                    height: "400px",
                    androidhls: true,
                    advertising: {
                    client: "vast",
                    schedule: {
                    adbreak1: {
                        offset: "pre",
                        tag: "'.$adurl1.'", 
                    },
                    adbreak2: {
                        offset:"'.$adurmidtime.'",
                        tag: "'.$adurl2.'",
                    },
                    adbreak3: {
                        offset: "post",
                        tag: "'.$adurl3.'",
                    },
                      }
                  }
                    });
                    ');
                                          }
        }
        else{
            
            $this->registerJs('
                                        var playerInstance = jwplayer("containerForShortVideo");
                                        playerInstance.setup({
                                        file: "'.$HomePageModel->ExternalVideoURL.'",
                                        autostart: true,
                                        width: "100%",
                                        height: "400px",
                                        });
                                        
');
            
        }
         $this->registerJs('
             $(".owl-theme").css("display", "block");
             $(".displaynonecls").css("display", "block");
             $(".breaking-news").css("display", "block");
            $("#slider1").responsiveSlides({
            speed:'.$HomePageModel->scroll_time.'
            });
            $("#s1").endlessScroll({ 
                width: "100%",
                height:"45px",
		steps: -2, speed:'.$HomePageModel->scroll_time.', 
		mousestop: true });');
$this->registerCss('
            .is a
            {
            padding-left:60px;
            }');
          if(!empty($AccompanyingVideo)){
      echo '<ul class="home-video-section">';
      foreach($AccompanyingVideo as $AccompanyingVideovar){
          array_push($notinarray,$AccompanyingVideovar['ID']);
      echo '<li><img src="'. S3_VIDEO_BUCKETABSOLUTE_PATH . $AccompanyingVideovar['ImageName'].'" alt="" class="img-responsive">'
            .'<a href="' . Yii::$app->getUrlManager()->getBaseUrl(). '/video/index?id='.$AccompanyingVideovar['ID'].'"><span class="home-video-vd-button"></span></a></li>';    
      }
      echo  '</ul>';
  }
        echo '</div></div>'; 
?>
  <section class="color-bg wow fadeInDown">
    <div class="col-md-10 main_section">
<?php 
if($HomePageModel->NewsOrAdd=='1'){
    echo '<div class="breaking-news" style="display:none">
	<div class="breaking-main">
    <div class="breaking-logo"></div>
	<div class="breaking-logo2"></div>
	</div>
    <div class="breaking-color">
    <div id="s1" class="is">';
	//<ul id="demo">';
foreach($newsModel as $newsModelarray){
echo ' <a href="'.$newsModelarray->LandingLink.'" target="_blank">'.$newsModelarray->Title.'</a>';
}
echo '</div>';
//<div id="s1" class="is">
    echo '</div>';
//</div></div>
}
else{
    echo ' <div>
            <ul class="rslides" id="slider1">';
    foreach($Advertise as $Advertisevar){
       
echo '<li><a href="'.$Advertisevar['LandingLink'].'" target="_blank"><img src="'.S3_BUCKETABSOLUTE_PATH.'/'.ADVERISEMENT.'/'.$Advertisevar['ImagePath'].'" /></a></li>';    
    }
    echo '</ul></div>';
}    
?>

<?php
$video='';
$firstvar=1;
$Categorycount=count($Categories);
foreach($Categories as $key=>$Categoriesary){
   $subCategorycount=count($Categoriesary);
    $idarray=$this->context->array_value_recursive('ID', $Categories);
    if(is_array($idarray)){
    $result=array_diff($idarray,$notinarray);    
    }
    else{
        $result=array();
    }
    if(!in_array($Categoriesary[0]['CategoryID'], $notincategory)){
     $firstvartext=$this->context->convert_number($firstvar);
     $ismobile=$this->context->isMobileDevice();
     if($ismobile){
    $numbervar=1;    
     }
     else{
    $numbervar=4;    
     }
     if(!empty($result)){
      echo '<div class="col-sm-12 category_heading displaynonecls" style="display:none"><h3>'.$key.'</h3></div><div class="carousel-wraper">';   
     }
    if($subCategorycount>$numbervar){
     echo '<span class="prev prev'.$firstvar.'"></span>
          <span class="next next'.$firstvar.'"></span>';   
    }
    echo '<div id="'.$firstvartext.'-carousel" class="owl-carousel owl-theme" style="opacity: 1; display: none;">'
            . '';
    
    foreach($Categoriesary as $subCategoriesary){
        if(!in_array($subCategoriesary['ID'],$notinarray)){
                 echo '<div class="item"> 
            <div class="wr-video">
            <div class="video-post v-col-5">
            <img height="220px" width="340px" src="'.ImagesUrl($subCategoriesary).'" alt="" class="img-responsive"/>
            <a href="' . Yii::$app->UrlManager->createUrl(['video/index','id'=>$subCategoriesary['ID'],'CategoryID'=>$subCategoriesary['CategoryID']]).'">
            <span class="vd-button"></span></a>
            <div class="data">
            <p>'.$subCategoriesary['Title'].'</p>
            <span>28:45</span></div></div></div></div>
            ';   
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
ga('send', {
  hitType: 'pageview',
  title: 'HomePage',
  location: location.pathname,
});
</script>
<script>jwplayer.key="hD/b7LcQ+uZ4O7eAkGOKH3qZCbYXAKT9sl188g==";</script>
<?php $this->registerJs('jwplayer.key="hD/b7LcQ+uZ4O7eAkGOKH3qZCbYXAKT9sl188g==";', yii\web\View::POS_END); ?>
