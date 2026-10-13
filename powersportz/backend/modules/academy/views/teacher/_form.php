<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\academy\models\School */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="academy-school-form">
    
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password', [
        'template' => "{label}\n<div class=\"input-group\">{input}<span class=\"input-group-btn\">" .
            Html::button('Generate', ['class' => 'btn btn-default', 'id' => 'school-generate-password']) .
            "</span></div>\n{error}\n{hint}",
    ])->passwordInput(['id' => 'school-password','maxlength' => true,]) ?>
    <?= $form->field($model, 'status')->dropDownList([1 => 'Active', 0 => 'Inactive'],['prompt' => 'Select status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs(<<<'JS'
function randomPassword(length) {
    let chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#$';
    let out = '';
    for (var i = 0; i < length; i++) {
        out += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return out;
}

$('#school-generate-password').on('click', function () {
    $('#school-password').val(randomPassword(10));
});
JS
);
?>
