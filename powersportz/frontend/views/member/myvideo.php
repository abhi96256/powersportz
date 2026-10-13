 <?php 
 use yii\helpers\Html;
 use yii\helpers\Url;;
 use yii\web\View;
 /* @var $this yii\web\View */
 /* @var $this yii\web\View */
 $this->title =Yii::t('frontend','myvideo');
 $this->params['breadcrumbs'][] = $this->title;

//echo "<pre>"; print_r($videolistdetails);die;
 ?> 
 <div class="col-md-10 single-page">
  <div class="col-md-3 tab-menu">
    <div id="togglebtn"> Profile</div>
        <!--<ul class="left-menu">
          <li> <a href="<?php //echo Url::toRoute(['member/mywatchlist'])?> "> <i class="my-wathc-list"></i> <span>My watchlist</span></a> </li>
          <li> <a href="<?php //echo Url::toRoute(['member/myfavourite'])?> "> <i class="my-favorites"></i> <span>My favorites</span></a> </li>
          <li class="active"> <a href="#"> <i class="my-videos"></i> <span>My videos</span></a> </li>
          <li> <a href="<?php //echo Url::toRoute(['member/myprofile'])?>"> <i class="profile"></i><span>Profile information</span></a></li>
         <li> <a href="<?php //echo Url::toRoute(['member/changepassword'])?>"> <i class="glyphicon glyphicon-cog" style="font-size: 25px;"></i> <span>Change Password</span></a> </li>
      
       </ul>-->
       <?php include('menu.php');?>
     </div>
     <div class="col-md-9 tab-content">
      <div class="tab-content">
        <div>
          <div class="upload-v">
            <h3><?php echo Yii::t('frontend','uploadedvideo');?></h3>
            <?php 
            //$modelsubscribervideoenable = new backend\models\Subscribervideosetting();
            //  $modelvideoenableupdate = \backend\models\Subscribervideosetting::find()->where(['SID' => '1'])->one();
            $modelvideoenableupdate = \backend\models\Subscribervideosetting::find()->orderBy(['SID'=>SORT_DESC])->one();
             //echo $modelvideoenableupdate['FromDate'];
             //$currentdate = ConvertDateToUTC(date("Y-m-d H:i:s"));
            $currentdate = date("Y-m-d H:i:s");


            
            if(($currentdate >= $modelvideoenableupdate['FromDate']) && ($currentdate <= $modelvideoenableupdate['ToDate'])) {
              ?>
              <a href="<?php echo Url::toRoute(['member/videoupload'])?>"><?php echo Yii::t('frontend','uploadvideo');?></a>
              <?php }else{ } ?> 
            </div>
            <div class="row" class “myvideo-sec”> 

              <?php if(count($videolistdetails)>0){?>
                
              <?php

               foreach ($videolistdetails as $key => $searchModelsub) { ?>
              <!--video post-->
              <div class="col-md-4 col-sm-6 col-xs-12 wr-video  topic-sec  ">
            <div class="video-post  v-col-5 video-image-box"> 
                  <?php  if($searchModelsub['ImageName']!='' || 1){?>
                  <img  src="<?= Yii::$app->getUrlManager()->getBaseUrl()?>/images/site-lazy.png" data-src=" <?php echo  ImagesUrl($searchModelsub);//S3_VIDEO_BUCKETABSOLUTE_PATH.$searchModelsub['ImageName']?>" alt="" class="img-responsive lazyload lazy-hidden" <?= 'onerror="this.error=false;this.src=\''.Yii::$app->getUrlManager()->getBaseUrl().'/images/placeholder.png\'"'?> /> 
                  <?php }else{ 
                   //echo  Html::img('@web/images/thumbnail-default.jpg', ['class' => 'img-responsive']);
                 } ?>


                 <?php  if($searchModelsub['VideoID']!=''){?>
                 <a href="<?php echo Url::toRoute(['/'.$searchModelsub['slug'].'-'.$searchModelsub['VideoID']])?> "><span class="vd-button"></span></a>
                 <?php }else{ ?>

                 <a href="javascript:void(0)" class="video-status"><span class=" <?php echo $searchModelsub['ApproveStatus'] == 'Pending'? 'video-pending':'video-rejected'?>"><?php echo $searchModelsub['ApproveStatus'];?></span></a>
                 <?php } ?>
                 <div onclick="deletevideo(<?php echo $searchModelsub['ID'];?>);"> <span title="Delete Video" class="delete">X</span></div>
               </div>

                 <div class="data">
                  <?php  if($searchModelsub['VideoID']!=''){ 
                    ?>
                     <p>
                  <a href="<?php echo Url::toRoute(['/'.$searchModelsub['slug'].'-'.$searchModelsub['VideoID']])?> ">
                   <?php echo $searchModelsub['VideoTitle'];?>
                  </a></p>
                  <?php }else{?>
                  <p><?php echo $searchModelsub['VideoTitle'];?></p>
                  <?php      }                  ?>
                  <!-- <h4><?php echo $searchModelsub['ApproveStatus'];?></h4> -->
                </div>
                  
              
              </div>
              
              <!--video post--> 
              <?php }  }else{	
                echo "You have not uploaded any videos till now.";
              }   ?> 

            </div>
            
            
            
          </div>
          
        </div>
      </div>
    </div>
    <script>
      function deletevideo(id){
        $("#spinnerLoader").show();
        var r = confirm("Are you sure you want to delete video?");


        if(r == true)
        {   
         var type='';
         var datastring = 'sid='+id+'&type='+type;
         $.ajax({
          type: 'POST',
          url: 'deletevideo',
          data: datastring,
          success: function (msg) {
            if(msg=='success'){
             $("#spinnerLoader").hide();
             window.location.href = '<?php echo Url::to(['/member/myvideo']) ?>' ;
           }else{
            $("#spinnerLoader").hide();
            window.location.href = '<?php echo Url::to(['/member/myvideo']) ?>' ;
          }
        }
      });
       }
       else
       {
        $("#spinnerLoader").hide();
        window.location.href = '<?php echo Url::to(['/member/myvideo']) ?>' ;
      }



    }
  </script>