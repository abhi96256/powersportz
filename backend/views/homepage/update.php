<?php
ini_set("memory_limit","512M");

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Homepage */

$this->title = 'Homepage Config';
$this->params['breadcrumbs'][] = ['label' => 'Homepages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->HomeID, 'url' => ['view', 'id' => $model->HomeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="homepage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tagMessage' => $tagMessage,
        'videooutlist'=>$videooutlist,
        'categoryData'=>$categoryData,
        'advertisementData'=>$advertisementData,
        'recordedVideoImage'=>$recordedVideoImage,
        'recordedScheduleVideoImage'=>$recordedScheduleVideoImage,
        'mainVideoInfo' => $mainVideoInfo,
        'scheduleVideoInfo' => $scheduleVideoInfo,
        'countryData'=>$countryData,
    ]) ?>

</div>
