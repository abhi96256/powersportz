<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Sports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sports-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ParentCategID')->textInput() ?>

    <?= $form->field($model, 'CategName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CategThumb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DisplayIndex')->textInput() ?>

    <?= $form->field($model, 'Status')->dropDownList([ 1 => '1', 2 => '2', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'LangID')->textInput() ?>

    <?= $form->field($model, 'CreatedBy')->textInput() ?>

    <?= $form->field($model, 'UpdatedBy')->textInput() ?>

    <?= $form->field($model, 'Created')->textInput() ?>

    <?= $form->field($model, 'Updated')->textInput() ?>

    <?= $form->field($model, 'Type')->dropDownList([ 1 => '1', 2 => '2', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
