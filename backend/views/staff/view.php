<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Member */

$this->title = $model->MemberID;
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->MemberID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->MemberID], [
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
            'MemberID',
            'FirstName',
            'LastName',
            'DOB',
            'MobileNo',
            'Gender',
            'Occupation',
            'Interest',
            'DeviceType',
            'DeviceToken',
            'SignupType',
            'Status',
            'UserID',
            'ActivationCode',
            'ActivatedOn',
            'Created',
            'Updated',
            'CreatedBy',
            'UpdatedBy',
        ],
    ]) ?>

</div>
