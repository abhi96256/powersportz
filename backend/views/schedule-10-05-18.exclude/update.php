<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Schedule */

$this->title = 'Update Schedule: ' . ' ' . $model->ScheduleID;
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ScheduleID, 'url' => ['view', 'id' => $model->ScheduleID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="schedule-update">

    <h1><?php  echo "Update Schedule"; ?></h1>

    <?= $this->render('_upadateform', [
        'model' => $model,
        'videooutlist'=>$videooutlist,
        
    ]) ?>

</div>
