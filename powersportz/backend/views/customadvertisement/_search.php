<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CustomadvertisementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customadvertisement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CustomAdvertiseID') ?>

    <?= $form->field($model, 'Title') ?>

    <?= $form->field($model, 'URL') ?>

    <?= $form->field($model, 'LandingLink') ?>

    <?= $form->field($model, 'FromDate') ?>

    <?php // echo $form->field($model, 'ToDate') ?>

    <?php // echo $form->field($model, 'IsAll') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'Created') ?>

    <?php // echo $form->field($model, 'CreatedBy') ?>

    <?php // echo $form->field($model, 'Updated') ?>

    <?php // echo $form->field($model, 'UpdatedBy') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
