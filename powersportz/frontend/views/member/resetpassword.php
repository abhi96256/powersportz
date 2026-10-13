<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Member */

$this->title =Yii::t('frontend','resetpassword');
$model->Password='';
 $request = Yii::$app->request;
        $Accesstoken = $request->get('Accesstoken');
?>
<div class="member-update">
        <div class="col-md-10 single-page">
     
  <div class="col-sm-8 col-md-6 col-lg-6 register-page">
  	<div class="registration-head">
    	<h2><?php echo Yii::t('frontend','resetpassword');?></h2>
    </div>
  	
   <div class="">
        <?php $form = ActiveForm::begin(['action' => ['member/resetpassword?Accesstoken='.$Accesstoken]]); ?>
      <?= $form->field($model, 'Password')->passwordInput(['placeholder'=> 'Password'])->label(false)  ?>
    
<?= $form->field($model, 'ConfirmPassword')->passwordInput(['placeholder'=> 'Confirm Password'])->label(false)  ?>
  	<?= Html::submitInput(Yii::t('frontend','reset'), ['class' => 'btn btn-default']) ?>
</form>
   
   </div>   
      
  </div><!-- /.col-lg-6 -->
     
     
    </div>
</div>
