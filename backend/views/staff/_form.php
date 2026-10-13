<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model backend\models\Member */
/* @var $form yii\widgets\ActiveForm */
$readOnly = array();
if(!$model->isNewRecord) {
    $readOnly = array('readonly'=>'readonly');
    $model->Password = '';
}
?>

<div class="member-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'MemberID')->hiddenInput(['maxlength' => true])->label(false); ?>
    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'UserName')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ConfirmPassword')->passwordInput(['maxlength' => true]) ?>
    <input type="hidden" name="hidden_parent_id" id="hidden_parent_id" value="<?= $model->parent_role_user_id; ?>">
    <?php 
        // Normal parent select
        echo $form->field($model, 'Designation')->dropDownList(\backend\models\Member::getDesignation($modelUser->UserType));

        // Dependent Dropdown
        echo $form->field($model, 'parent_role_user_id')->widget(DepDrop::classname(), [
            //'options' => ['id' => 'subcat-id'],
            'pluginOptions' => [
                'initialize' => true,
                'depends' => ['member-designation'],
               // 'placeholder' => 'Select...',
                'url' => Yii::$app->urlManager->createUrl(['staff/parent-role-user-id']),
                'params'=>['member-memberid',"hidden_parent_id"]
            ]
        ]);
    ?>
    <?php //$form->field($model, 'Designation')->dropDownList(\backend\models\Member::getDesignation(),['prompt'=>'--Select Designation--']) ?>
    <?= $form->field($model, 'MobileNo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Status')->dropDownList(\backend\models\User::getStatus()) //['prompt' => ''] ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
