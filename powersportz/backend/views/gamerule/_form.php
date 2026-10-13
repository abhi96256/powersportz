<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\Gamerule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gamerule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'GameName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'Description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => [
        'filebrowserImageUploadUrl' => 'uploadckeditor'
        ]
    ]) ?>
    
    <?= $form->field($model, 'Status')->dropDownList([ 1 => 'Active', 2 => 'Inactive'], ['prompt' => '--Select Status--']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
