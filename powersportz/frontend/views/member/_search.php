<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\MemberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MemberID') ?>

    <?= $form->field($model, 'FirstName') ?>

    <?= $form->field($model, 'LastName') ?>

    <?= $form->field($model, 'DOB') ?>

    <?= $form->field($model, 'Email') ?>

    <?php // echo $form->field($model, 'MobileNo') ?>

    <?php // echo $form->field($model, 'Designation') ?>

    <?php // echo $form->field($model, 'Gender') ?>

    <?php // echo $form->field($model, 'Occupation') ?>

    <?php // echo $form->field($model, 'Interest') ?>

    <?php // echo $form->field($model, 'DeviceType') ?>

    <?php // echo $form->field($model, 'DeviceToken') ?>

    <?php // echo $form->field($model, 'SignupType') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'UserID') ?>

    <?php // echo $form->field($model, 'ActivationCode') ?>

    <?php // echo $form->field($model, 'ActivatedOn') ?>

    <?php // echo $form->field($model, 'Created') ?>

    <?php // echo $form->field($model, 'Updated') ?>

    <?php // echo $form->field($model, 'CreatedBy') ?>

    <?php // echo $form->field($model, 'UpdatedBy') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
