<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Member */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?=$form->errorSummary($model);?>
    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true,'placeholder'=>Yii::t('frontend','firstname')])->label(false)->error(false) ?>

    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true,'placeholder'=>Yii::t('frontend','lastname')])->label(false)->error(false)  ?>
    
    <?= $form->field($model, 'UserName')->textInput(['maxlength' => true,'placeholder'=>Yii::t('frontend','username')])->label(false)->error(false)  ?>
    
    <?= $form->field($model, 'Email')->textInput(['maxlength' => true,'placeholder'=>Yii::t('frontend','emailid')])->label(false)->error(false)  ?>
     <div class="form-inline">
<?= $form->field($model, 'DOB')->widget(
    DatePicker::className(), [
        // inline too, not bad 
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'mm/dd/yyyy',
			 'endDate' => date('m/d/Y')
        ]
])->error(false);?>
<?= $form->field($model, 'Gender')->radioList(array('1'=>Yii::t('frontend','male'),2=>Yii::t('frontend','female')))->label(false)->error(false)  ?>
         </div>
    
<?= $form->field($model, 'Password')->passwordInput(['placeholder'=>Yii::t('frontend','password')])->label(false)->error(false)  ?>
    
<?= $form->field($model, 'ConfirmPassword')->passwordInput(['placeholder'=>Yii::t('frontend','confirmpassword')])->label(false)->error(false)  ?>

<?= $form->field($model, 'Occupation')->dropDownList(\frontend\models\MEMBER::getOccupations(),['prompt' =>Yii::t('frontend','slctocu')])->label(false)->error(false); ?>
    
<?= $form->field($model,'Interest')->dropDownList(\frontend\models\MEMBER::getInterest(),['prompt' =>Yii::t('frontend','slctintrst')])->label(false)->error(false); ?>

<?= $form->field($model, 'TermCondition')->checkbox()->error(false); ?>
  <div class="submit-wrap">
    <?= Html::submitInput(Yii::t('frontend','signup'), ['class' =>'btn btn-default']) ?>
  </div>     
  </div><!-- /.col-lg-6 -->
  
<?php ActiveForm::end(); ?>