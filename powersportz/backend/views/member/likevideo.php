<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Likes';
$this->params['breadcrumbs'][] = $this->title;
$id = $_GET['id'];
if (isset($id) && $id != '') {
    include 'tabs.php';
}
?>
<div class="post-index">

    <h1><?php //echo Html::encode($this->title)  ?></h1>
    <!--<div class="row">
                   <div class="col-lg-12">
                       <h1 class="page-header">Member Details</h1>
                   </div>
               </div>    
               <div class="clearfix">&nbsp;</div>-->
    <div class="row">
        <!-- <div class="col-lg-12">
             <div class="panel panel-default">-->
        <div class="row">
            <?php
            if (!empty($likemodel)) {
                foreach ($likemodel as $videolistinsub) {
                    echo '<div class="col-lg-3 col-sm-4 col-xs-6"><img class="thumbnail img-responsive" src="' . ImagesUrl($videolistinsub). '"><p>' . $videolistinsub['Title'] . '</p></div>';
                //echo '<div class="col-lg-3 col-sm-4 col-xs-6"><img class="thumbnail img-responsive" src="' . S3_VIDEO_BUCKETABSOLUTE_PATH . $videolistinsub['ImageName']. '"><p>' . $videolistinsub['Title'] . '</p></div>';
            
				}
            } else {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><p> No Records Found </p></div>';
            }
            ?>
        </div>
    </div>
</div>
<!-- </div>

</div>
-->