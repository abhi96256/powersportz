<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Customadvertisement */

$this->title = $model->Title;
$this->params['breadcrumbs'][] = ['label' => 'Customadvertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customadvertisement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->CustomAdvertiseID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->CustomAdvertiseID], [
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
            'CustomAdvertiseID',
            'Title',
            'URL:url',
            'LandingLink',
            'FromDate',
            'ToDate',
            'IsAll',
            'Status',
            'Created',
            'CreatedBy',
            'Updated',
            'UpdatedBy',
        ],
    ]) ?>

</div>
