<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\models\Member */

$this->title =Yii::t('frontend','Login');
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-view">
    <div class="col-md-10 single-page">

        <div class="col-sm-8 col-md-8 col-lg-8 register-page">
            <div class="registration-head">
                <h2><?php echo Yii::t('frontend','Login');?></h2>
            </div>

            <div class="col-md-6 log">
            <?php $form = ActiveForm::begin(['action' => ['member/login']]); ?>
            <?= $form->field($model, 'Email')->textInput(['maxlength' => true,'placeholder'=> Yii::t('frontend','emailid')])->label(false)  ?>
            <?= $form->field($model, 'Password')->passwordInput(['maxlength' => true,'placeholder'=>Yii::t('frontend','password')])->label(false)  ?>  
                     <?= Html::submitInput(Yii::t('frontend','Login'), ['class' => 'btn btn-default']) ?>
                    <a href="<?php echo Url::toRoute('member/register')?>"><?php echo Yii::t('frontend','signup');?></a>
                    <a href="<?php echo Url::toRoute('member/forgotpassword')?>"><?php echo Yii::t('frontend','forgotpwd');?></a>
             <?php ActiveForm::end(); ?>


            </div>
            <div class="col-md-6">
                <?php use yii\authclient\widgets\AuthChoice; ?>
<?php $authAuthChoice = AuthChoice::begin(['baseAuthUrl' => ['site/auth'], 'autoRender' => false]); ?>          
<?php foreach ($authAuthChoice->getClients() as $client): ?>
<?php if($client->name=='facebook'){
?>
<?= Html::a('<i class="fa fa-facebook"></i>'.Yii::t('frontend','Signinfb'), ['member/auth', 'authclient'=> $client->name, ], ['class' => "btn btn-block btn-social btn-facebook $client->name "]) ?>
<?php    
}
?>
<?php if($client->name=='google'){
?>
<?= Html::a('<i class="fa fa-google"></i>'.Yii::t('frontend','Signinggl'), ['member/auth', 'authclient'=> $client->name, ], ['class' => "btn btn-block btn-social btn-google $client->name "]) ?>
<?php    
}
?>
<?php endforeach; ?>
<?php AuthChoice::end(); ?>
            </div>

        </div><!-- /.col-lg-6 -->


    </div>
</div>
