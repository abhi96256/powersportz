<?php

use yii\helpers\Html;

$this->title = 'Verify OTP';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login login-page certificate-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Enter the OTP sent to <?= Html::encode($email) ?>.</p>
    <p class="certificate-note">After verification, you will be redirected to a dedicated certificates page.</p>

    <?php $resentMessage = Yii::$app->session->getFlash('otp-resent'); ?>
    <?php $otpError = Yii::$app->session->getFlash('otp-error'); ?>
    <?php if ($otpError) : ?>
        <div class="otp-error-note">
            <span class="otp-error-label">Error:</span>
            <?= Html::encode($otpError) ?>
        </div>
    <?php endif; ?>
    <?php if ($resentMessage) : ?>
        <div class="otp-resent-note">
            <span class="otp-resent-label">Resent:</span>
            <?= Html::encode($resentMessage) ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12">
            <section id="sign_in_form">
                <?= Html::beginForm(['certificate/verify', 'email' => $email], 'post', ['id' => 'otp-form']) ?>
                    <div class="form-group">
                        <?= Html::label('OTP', 'certificate-otp', ['class' => 'control-label']) ?>
                        <?= Html::input('text', 'otp', '', [
                            'class' => 'form-control',
                            'id' => 'certificate-otp',
                            'required' => true,
                            'placeholder' => 'Enter OTP',
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Verify', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Resend OTP', ['certificate/resend-otp', 'email' => $email], ['class' => 'resend-otp-link']) ?>
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
    padding: 10px 24px;
    font-weight: 500;
    font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif !important;
    color: #fff !important;
}
.certificate-note {
    font-size: 13px;
    color: #efefef;
    margin-bottom: 14px;
}
.resend-otp-link {
  color: #c01616;
  text-decoration: underline;
  cursor: pointer;
  padding-left: 6px;
}
.otp-resent-note {
    margin: 10px 0 16px;
    padding: 8px 12px;
    background: #1f1f1f;
    color: #e7efe7;
    border-left: 3px solid #7fb37f;
    font-size: 13px;
}
.otp-resent-label {
    color: #b8d9b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-right: 6px;
}
.otp-error-note {
    margin: 10px 0 16px;
    padding: 8px 12px;
    background: #2a1a1a;
    color: #f1dddd;
    border-left: 3px solid #d86a6a;
    font-size: 13px;
}
.otp-error-label {
    color: #f0b8b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-right: 6px;
}
.site-login.login-page.certificate-login {
    background-color: rgb(118 119 120);
    padding: 17px 40px 26px 29px;
}
</style>
