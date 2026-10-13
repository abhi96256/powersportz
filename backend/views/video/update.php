<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Video */

$this->title = 'Update Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Title, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p class="pull-right">
    <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="video-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
        'playlistData'=>$playlistData,
        'topicsData'=>$topicsData,
        'talking_pointsData'=>$talking_pointsData,
        'countryData'=>$countryData,
        'images'=>$images,
        'videosList'=>$videosList,
        'isShowStatus'=>$isShowStatus,
        'VideoThumbImageList'=>$VideoThumbImageList,
        'DefaultGeneratedImages'=>$DefaultGeneratedImages,
        'autherName'=>$autherName
        ]); ?>

    </div>
