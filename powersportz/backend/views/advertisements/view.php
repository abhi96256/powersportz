<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Advertisemnts */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Advertisemnts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisemnts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'ImagePath',
            'Content',
            'LandingLink',
            'ScrollTime:datetime',
            'FromDate',
            'Todate',
            'Status',
            'CreatedBy',
            'UpdatedBy',
            'Created',
            'Updated',
        ],
    ]) ?>

</div>
