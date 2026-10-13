<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model backend\models\UserRole */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl.'/css/multiselect.css'; ?>">

<?php 
 $this->registerJsFile("https://www.jqueryscript.net/demo/jQuery-Plugin-For-Multi-Select-Checboxes-multiselect/js/jquery.multiselect.js",['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);
 $this->registerJsFile(Yii::$app->request->baseUrl.'/js/user_role.js',['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);

?>
<div class="user-role-form">

    <?php $form = ActiveForm::begin(); ?>
   <?= $form->field($model, 'role_name')->textInput(['maxlength' => true]); ?>
   
		  <div class="form-group">
  	        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
		<?php ActiveForm::end(); ?> 
</div>    