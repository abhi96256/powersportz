<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pull-right">
    <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'playlistData'=>$playlistData,
        'topicsData'=>$topicsData,
        'countryData'=>$countryData,
        'videosList'=>$videosList,
        'isShowStatus'=>$isShowStatus,
        'VideoThumbImageList'=>$VideoThumbImageList,
        'autherName'=>$autherName
        ]) ?>

    </div>
