<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $email string */
/* @var $downloadUrl string */

$this->title = 'Verify OTP';
?>

<div class="academy-public-verify">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Enter the OTP sent to <?= Html::encode($email) ?>.</p>

    <?php if ($downloadUrl) : ?>
        <p><?= Html::a('Download Certificate', $downloadUrl, ['class' => 'btn btn-success']) ?></p>
    <?php else : ?>
        <?php $form = ActiveForm::begin(); ?>
        <?= Html::input('text', 'otp', '', ['class' => 'form-control', 'required' => true]) ?>
        <br>
        <?= Html::submitButton('Verify', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>
