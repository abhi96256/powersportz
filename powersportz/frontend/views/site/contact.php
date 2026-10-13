<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact Us | Power Sportz';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-10 main_section ">
  <div class="col-sm-8 col-md-6 col-lg-6 register-page">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
      If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>
    <div class="row">
      <div class="col-lg-12">
        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'subject') ?>

        <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

        <?php /* = $form->field($model, 'verifyCode')->widget(Captcha::className(), [
          'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
          ]) */ ?>

        <div class="submit-wrap">
          <?php //echo  Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button'])  ?>
          <input type="submit" class="btn btn-default" name="contact-button" value="Submit">
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>

  </div>
</div>