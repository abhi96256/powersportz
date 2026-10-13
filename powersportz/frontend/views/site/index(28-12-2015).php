<?php
/* @var $this yii\web\View */
$this->title = Yii::t('frontend','Home');
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
<script type="text/javascript" src='http://content.jwplatform.com/libraries/DkwOvSfA.js'></script>
<div class="site-index">
<?php
            echo '<div class="container-fluid wow fadeInDown">
                    <div class="row">
                    <div class="col-md-6 my-slider">';
             if(empty($Videogeographics)){
                    echo '<div id="containerForShortVideo">Loading the player...</div>';
}
else{	
       echo '<div class="error-video-msg clearfix" style="width:100%">
        	<div class="error-video-img"><img src="../images/video-error-img.png" alt="error-img"></div>
        	<div class="error-video-text">
        		<p>'.Yii::t('frontend','VideoNotAvailable').'</p>
        	</div>
    	</div>';
}
         
        if(!empty($VideoDetails)){ 
            if(empty($Videogeographics)){
                $adurmidtime=$VideoDetails[0]['StartMidAdvertisementTime'];
                if(!empty($Customadvertise)){
        foreach($Customadvertise as $Customadvertisesub){
                    $customadarraylist[$Customadvertisesub['Type']]=$Customadvertisesub['XML'];
                    $customadarraylist['Time']=$Customadvertisesub['MidTime'];
        }
        if (array_key_exists("1",$customadarraylist)){
                    $adurl1= CustomAdvertisePath().$customadarraylist['1'].'.xml';
        }
                if (array_key_exists("2",$customadarraylist)){
                    $adurl2= CustomAdvertisePath().$customadarraylist['2'].'.xml';
                    $adurmidtime=$customadarraylist['Time'];
        }
                if (array_key_exists("3",$customadarraylist)){
                    $adurl3= CustomAdvertisePath().$customadarraylist['3'].'.xml';
        }
}
else{
    $customadarraylist=array();
                    $adurl1= $VideoDetails[0]['PreAdvertisementTagURL'];
                    $adurl2= $VideoDetails[0]['MidAdvertisementTagURL'];
                    $adurl3= $VideoDetails[0]['PostAdvertisementTagURL'];
}
          /*print_r( $adurl1);
          print_r( $adurl2);
          print_r( $adurl3);die;*/
         
                                       $this->registerJs('
                                        var playerInstance = jwplayer("containerForShortVideo");
                                        playerInstance.setup({
                                        file: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $VideoDetails[0]['VideoStreamURL'] . '",
                                        image: "' . S3_VIDEO_BUCKETABSOLUTE_PATH . $VideoDetails[0]['ImageName'] . '",    
                                        primary: "flash",
                                        type: "mp4",
                                        autostart: false,
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
                                        primary: "flash",
                                        type: "mp4",
                                        autostart: true,
                                        width: "100%",
                                        });
                                        
');
            
        }
         $this->registerJs('
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
    echo '<div class="breaking-news">
    <div class="breaking-logo"></div>
    <div class="breaking-color">
    <div id="s1" class="is">';
foreach($newsModel as $newsModelarray){
echo '<a href="'.$newsModelarray->LandingLink.'" target="_blank">'.$newsModelarray->Title.'</a>';
}
echo '</div></div></div>';
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
    $result=array_diff($idarray,$notinarray);
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
      echo '<div class="col-sm-12 category_heading"><h3>'.$key.'</h3></div><div class="carousel-wraper">';   
     }
    if($subCategorycount>$numbervar){
     echo '<span class="prev prev'.$firstvar.'"></span>
          <span class="next next'.$firstvar.'"></span>';   
    }
    echo '<div id="'.$firstvartext.'-carousel" class="owl-carousel owl-theme" style="opacity: 1; display: block;">'
            . '';
    
    foreach($Categoriesary as $subCategoriesary){
      //print_r($subCategoriesary);die;
        if(!in_array($subCategoriesary['ID'],$notinarray)){
                 echo '<div class="item"> 
            <div class="wr-video">
            <div class="video-post v-col-5">
            <img src="'.S3_VIDEO_BUCKETABSOLUTE_PATH . $subCategoriesary['ImageName'].'" alt="" class="img-responsive"/>
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
