<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
$model->UserType =(!empty($model->UserType)) ? $model->UserType :  '1';
$readOnly = array();
if(!$model->isNewRecord) {
    $readOnly = array('readonly'=>'readonly');
    $model->Password = '';

}
?>

<div class="user-form">
    <?php $form = ActiveForm::begin([
       ]
    ); ?>
    <?php echo $form->errorSummary([$model,$member_model]); ?>
    <?php if($model->isNewRecord) {
        echo $form->field($model, 'UserType')->radioList(array(1=>'Admin',2=>'Staff')); 
    }else{
        echo $form->field($model, 'UserType')->textInput(['value'=>($model->UserType == 1) ? 'Admin' : "Staff","readonly"=>true]); 
    }   
    ?>

    <?= $form->field($member_model, 'MemberID')->hiddenInput(['maxlength' => true,'class'=>'form-control member_model'])->label(false); ?>
    <?php if( ($model->UserType != 1 && !$model->isNewRecord) || $model->isNewRecord) { ?>
        <?= $form->field($member_model, 'FirstName')->textInput(['maxlength' => true,'class'=>'form-control member_model']) ?>
        <?= $form->field($member_model, 'LastName')->textInput(['maxlength' => true,'class'=>'form-control member_model']) ?>
    <?php } ?>
    
    <?= $form->field($model, 'UserName')->textInput($readOnly) ?>
    <?= $form->field($model, 'Email')->textInput($readOnly) ?>
    <?= $form->field($model, 'Password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ConfirmPassword')->passwordInput(['maxlength' => true]); 
    
    //$member_model->parent_role_user_id = $model->parent_role_user_id;
            
    ?>
    
    <?php if( ($model->UserType != 1 && !$model->isNewRecord) || $model->isNewRecord) { ?>
    <input type="hidden" name="hidden_parent_id" id="hidden_parent_id" value="<?= $model->parent_role_user_id; ?>">
    <?php  // Normal parent select
        echo $form->field($member_model, 'Designation')->dropDownList(\backend\models\Member::getDesignation(2),['class'=>'form-control member_model']);

        // Dependent Dropdown
        echo $form->field($member_model, 'parent_role_user_id')->widget(DepDrop::classname(), [
            'options' => ['class'=>'form-control member_model'],
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
    <?= $form->field($member_model, 'MobileNo')->textInput(['maxlength' => true,'class'=>'form-control member_model']) ?>
    <?php } ?>
    <?= $form->field($model, 'Status')->dropDownList(\backend\models\User::getStatus()) //['prompt' => ''] ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php 
$this->registerJs('
        $(document).ready(function(){

            $("#user-usertype").trigger("change");
        });

        var radio_name = "User[UserType]";
        $("#user-usertype").change(function(){
      
            if($("#user-usertype input:radio:checked").val() == 1){
                $(".member_model").closest("div").addClass("hide_div");
            }else{
                $(".member_model").closest("div").removeClass("hide_div");
            }
        });

     ',yii\web\View::POS_END,'playlist-form');
?>
