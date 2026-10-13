<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Member */

$this->title = Yii::t('frontend','forgotpwd');
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MemberID, 'url' => ['view', 'id' => $model->MemberID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="member-update">
        <div class="col-md-10 single-page">
     
  <div class="col-sm-8 col-md-6 col-lg-6 register-page">
  	<div class="registration-head">
    	<h2><?php echo Yii::t('frontend','forgotpwd');?></h2>
    </div>
  	
   <div class="">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'Email')->textInput(['maxlength' => true,'placeholder'=> 'Email Id'])->label(false)  ?>
  	<?= Html::submitInput(Yii::t('frontend','reset'), ['class' => 'btn btn-default']) ?>
</form>
   
   </div>   
      
  </div><!-- /.col-lg-6 -->
     
     
    </div>
</div>
