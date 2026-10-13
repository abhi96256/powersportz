<?php
use yii\helpers\Url;
use yii\helpers\Html;
$actionName = Yii::$app->controller->action->id;
$id = $_GET['id'];
?>

<div class="row">
   
                <div class="col-lg-12">
                         <p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
                    <h1 class="page-header">Subscriber Details</h1>
                </div>

            </div>    
            <div class="clearfix">&nbsp;</div>
<div>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" <?php if($actionName == 'view') { ?> class="active" <?php } ?> ><a href="<?php echo Url::to(['/member/view?id='.$id]); ?>" >Details</a></li>
    <!--<li role="presentation" <?php //if($actionName == 'likedvideo') { ?> class="active" <?php //} ?>><a href="<?php //echo Url::to(['/member/likedvideo?id='.$id]); ?>" >Liked Videos</a></li>-->
     <li role="presentation" <?php if($actionName == 'sharedvideo') { ?> class="active" <?php } ?>><a href="<?php echo Url::to(['/member/sharedvideo?id='.$id]); ?>" >Shared Videos</a></li>
     <li role="presentation" <?php if($actionName == 'uploadvideo') { ?> class="active" <?php } ?>><a href="<?php echo Url::to(['/member/uploadvideo?id='.$id]); ?>" >Video Uploaded</a></li>
 
 </ul>
</div>