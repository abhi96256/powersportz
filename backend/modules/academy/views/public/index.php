<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $email string */

$this->title = 'Download Certificate';
?>

<div class="academy-public-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Enter your email to receive an OTP.</p>

    <?php $form = ActiveForm::begin(); ?>
    <?= Html::input('email', 'email', $email, ['class' => 'form-control', 'required' => true]) ?>
    <br>
    <?= Html::submitButton('Send OTP', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>
