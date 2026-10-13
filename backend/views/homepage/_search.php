<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HomepageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="homepage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'HomeID') ?>

    <?= $form->field($model, 'MainVideoType') ?>

    <?= $form->field($model, 'VideoID') ?>

    <?= $form->field($model, 'ExternalVideoURL') ?>

    <?= $form->field($model, 'AccompanyingID') ?>

    <?php // echo $form->field($model, 'NewsOrAdd') ?>

    <?php // echo $form->field($model, 'AdvertisementID') ?>

    <?php // echo $form->field($model, 'CategoryID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
