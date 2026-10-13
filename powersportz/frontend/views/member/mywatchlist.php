<?php 

use yii\helpers\Html;
use yii\helpers\Url;;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $this yii\web\View */
$this->title =Yii::t('frontend','mywatchlist');
$this->params['breadcrumbs'][] = $this->title;

//echo "<pre>"; print_r($watchlistdetails);die;
?> 

<div class="col-md-10 single-page">
  <div class="col-md-3 tab-menu">
    <div id="togglebtn"> Profile</div>
       <!-- <ul class="left-menu">
          <li class="active"> <a href="#"> <i class="my-wathc-list"></i> <span>My watchlist</span></a> </li>
          <li> <a href="<?php //echo Url::toRoute(['member/myfavourite'])?> "> <i class="my-favorites"></i> <span>My favorites</span></a> </li>
          <li> <a href="<?php //echo Url::toRoute(['member/myvideo'])?> "> <i class="my-videos"></i> <span>My videos</span></a> </li>
          <li> <a href="<?php //echo Url::toRoute(['member/myprofile'])?> "> <i class="profile"></i><span>Profile information</span></a></li>
         <li> <a href="<?php //echo Url::toRoute(['member/changepassword'])?>"> <i class="glyphicon glyphicon-cog" style="font-size: 25px;"></i> <span>Change Password</span></a> </li>
      
       </ul>-->
       <?php include('menu.php');?>
     </div>
     <div class="col-md-9 tab-content">
      <div class="tab-content">
        <div>
          <h3><?php echo Yii::t('frontend','mywatchlist');?></h3>
          <div class="row"> 
           <?php if(count($watchlistdetails)>0){ ?>
           <?php foreach ($watchlistdetails as $key => $searchModelsub) { ?>
           <!--video post-->
           <div class="col-md-4 col-sm-6 col-xs-12 wr-video  topic-sec  ">
            <div class="video-post  v-col-5 video-image-box"> 
              <img  src="<?= Yii::$app->getUrlManager()->getBaseUrl()?>/images/site-lazy.png" data-src=" <?php echo  ImagesUrl($searchModelsub)?>" alt="" class="img-responsive lazyload lazy-hidden" <?= 'onerror="this.error=false;this.src=\''.Yii::$app->getUrlManager()->getBaseUrl().'/images/placeholder.png\'"'?> /> 
              <a href="<?php echo Url::toRoute(['/'.$searchModelsub['slug'].'-'.$searchModelsub['ID']])?> "><span class="vd-button"></span></a>
              <div onclick="deletevideo(<?php echo $searchModelsub['videolike_ID'];?>);"> <span title="Delete Video" class="delete">X</span></div>
            </div>
            <div class="data">
              <p>
               <a href="<?php echo Url::toRoute(['/'.$searchModelsub['slug'].'-'.$searchModelsub['ID']])?> "> <?php echo $searchModelsub['Title'];?>
               </a>
             </p>
           </div>


         </div>

         <!--video post--> 
         <?php }
       }else{	
        echo "No videos are added in your watchlist till now.";
      }
      ?> 


    </div>
  </div>

</div>
</div>
</div>
<script>
  function deletevideo(id){
    $("#spinnerLoader").show();
    var r = confirm("Are you sure you want to delete Your Watchlist video?");


    if(r == true)
    {   
      $("#spinnerLoader").show();
      var type='3';
      var datastring = 'sid='+id+'&type='+type;
      $.ajax({
        type: 'POST',
        url: '<?php echo Yii::$app->UrlManager->createUrl('member/deletevideo') ?>',
        data: datastring,
        success: function (msg) {
          $("#spinnerLoader").hide();
          window.location.href = '<?php echo Url::to(['/member/mywatchlist']) ?>' ;
        }
      });
    }
    else
    {
      $("#spinnerLoader").hide();
      window.location.href = '<?php echo Url::to(['/member/mywatchlist']) ?>' ;
    }



  }
</script>