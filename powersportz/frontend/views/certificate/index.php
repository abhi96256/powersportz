<?php

use yii\helpers\Html;

$this->title = 'Download Certificate';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login login-page certificate-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following field to get your certificate:</p>
    <?php $emailError = Yii::$app->session->getFlash('email-error'); ?>
    <?php if ($emailError) : ?>
        <div class="email-error-note">
            <span class="email-error-label">Error:</span>
            <?= Html::encode($emailError) ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <section id="sign_in_form">
                <?= Html::beginForm(['certificate/index'], 'post', ['id' => 'certificate-form']) ?>
                    <div class="form-group">
                        <?= Html::label('Email', 'certificate-email', ['class' => 'control-label']) ?>
                        <?= Html::input('email', 'email', $email, ['class' => 'form-control','id' => 'certificate-email','required' => true,'placeholder' => 'Enter Email',]) ?>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Send OTP', ['class' => 'btn btn-primary']) ?>
                    </div>
                <?= Html::endForm() ?>
            </section>
        </div>
    </div>
</div>

<style>
.certificate-login {
    max-width: 420px;
    margin: 60px auto;
}
.certificate-login .form-control {
    background: #f3f3f3;
}
.certificate-login .btn-primary {
    background: #c01616;
    border-color: #c01616;
    text-transform: uppercase;
    font-weight: 500;
    padding: 10px 24px;
    color: #fff !important;
    font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif !important;
}
.site-login.login-page.certificate-login {
    background-color: rgb(118 119 120);
    padding: 17px 40px 26px 29px;
}
.email-error-note {
    margin: 10px 0 16px;
    padding: 8px 12px;
    background: #2a1a1a;
    color: #f1dddd;
    border-left: 3px solid #d86a6a;
    font-size: 13px;
}
.email-error-label {
    color: #f0b8b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-right: 6px;
}

</style>
