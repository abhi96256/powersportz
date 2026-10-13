<?php
use yii\helpers\Url;
$actionName = Yii::$app->controller->action->id;

?>

   <ul class="left-menu">
          <li <?php if($actionName == 'mywatchlist') { ?> class="active" <?php } ?>> <a href="<?php echo Url::toRoute(['member/mywatchlist'])?> "> <i class="my-wathc-list"></i> <span><?php echo Yii::t('frontend','mywatchlist');?></span></a> </li>
          <li <?php if($actionName == 'myfavourite') { ?> class="active" <?php } ?>> <a href="<?php echo Url::toRoute(['member/myfavourite'])?> "> <i class="my-favorites"></i> <span><?php echo Yii::t('frontend','myfavourite');?></span></a> </li>
          <li <?php if($actionName == 'myvideo') { ?> class="active" <?php } ?>> <a href="<?php echo Url::toRoute(['member/myvideo'])?>"> <i class="my-videos"></i> <span><?php echo Yii::t('frontend','myvideo');?></span></a> </li>
          <li <?php if($actionName == 'myprofile') { ?> class="active" <?php } ?>> <a href="<?php echo Url::toRoute(['member/myprofile'])?>"> <i class="profile"></i><span><?php echo Yii::t('frontend','profileinfo');?></span></a></li>
            <?php if(!isset($_SESSION['is_social']))
            {?>
                <li <?php if($actionName == 'changepassword') { ?> class="active" <?php } ?>> <a href="<?php echo Url::toRoute(['member/changepassword'])?>"> <i class="glyphicon glyphicon-cog" style="font-size: 25px;"></i> <span><?php echo Yii::t('frontend','changepwd');?></span></a> </li>
           <?php  } ?>
          <li > <a href="<?php echo Url::toRoute(['member/logout'])?>"> <i class="glyphicon glyphicon-off" style="font-size: 25px;"></i> <span><?php echo Yii::t('frontend','Logout');?></span></a> </li>
      
        </ul>