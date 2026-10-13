<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Member */

$this->title = Yii::t('frontend','MemberRegistration');
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//Yii::$app->language='hi-IN';
?>
<div class="member-create">
            <div class="col-md-10 single-page">
     
  <div class="col-sm-8 col-md-6 col-lg-6 register-page">
  	<div class="registration-head">
    	<h2><?php echo Yii::t('frontend','MemberRegistration');?></h2>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
                </div>
    </div>
