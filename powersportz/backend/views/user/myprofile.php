<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
if (!$model->isNewRecord) {
    
}
?>
<div class="user-myprofile">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $form = ActiveForm::begin([
                'action' => ['user/myprofile']
    ]);
    ?> 
    <div class="container">
        <?= $form->field($model, 'OldPassword')->passwordInput() ?>   
<?= $form->field($model, 'NewPassword')->passwordInput() ?>  
<?= $form->field($model, 'ConfirmPassword')->passwordInput() ?>   
<?= Html::submitButton('Done', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
    </div></div>