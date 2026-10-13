<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login to Powersportz Account';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$(".wrap").addClass("login");');
?>
<div class="site-login login-page">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-12">
        	<section id="sign_in_form">
	            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
	
	                <?= $form->field($model, 'UserName') ?>
	
	                <?= $form->field($model, 'Password')->passwordInput() ?>
	
	                <?= $form->field($model, 'rememberMe')->checkbox() ?>
	
	                <div class="form-group">
	                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
	                </div>
	
	            <?php ActiveForm::end(); ?>
            </section>
        </div>
    </div>
</div>
