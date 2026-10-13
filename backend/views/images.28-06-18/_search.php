<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ImagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="images-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ImageID') ?>

    <?= $form->field($model, 'VideoID') ?>

    <?= $form->field($model, 'Title') ?>

    <?= $form->field($model, 'ImageName') ?>

    <?= $form->field($model, 'IsThumb') ?>

    <?php // echo $form->field($model, 'ImageType') ?>

    <?php // echo $form->field($model, 'Created') ?>

    <?php // echo $form->field($model, 'CreatedBy') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
