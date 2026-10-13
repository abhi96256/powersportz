<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Member */

$this->title =Yii::t('frontend','resetpassword');
//$model->Password='';
?>

<?php  $this->registerJs("
");?>
<div class="member-update">
  <div class="col-md-10 single-page">

   <!--<div class="col-sm-8 col-md-6 col-lg-6 register-page">-->

    <div class="col-md-3 tab-menu">
      <div id="togglebtn"> Profile</div>
      <?php include('menu.php');?>
    </div>
    <!--<div class="">-->
     <div class="col-md-9 tab-content change-password-wrapper">
      <div class="tab-content">
        <div>
          <?php $form = ActiveForm::begin(); ?>
          <h3><label id="cpassword"><?php echo Yii::t('frontend','changepwd');?></label></h3>

          <?php echo $form->field($model, 'oldPassword')->passwordInput(['maxlength' => true]) ?>
          <?php echo $form->field($model, 'Password')->passwordInput(['maxlength' => true])  ?>
          <?php echo $form->field($model, 'ConfirmPassword')->passwordInput(['maxlength' => true])?>
          <div class="submit-wrap">
            <input type="submit" class="btn btn-default" value="<?php echo Yii::t('frontend','Submit');?>">
          </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
