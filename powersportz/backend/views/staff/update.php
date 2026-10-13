<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Member */

$this->title = 'Update Staff';
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->MemberID, 'url' => ['view', 'id' => $model->MemberID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<h1><?= Html::encode($this->title) ?></h1>
<div class="member-update">


    <?= $this->render('_form', [
        'model' => $model,
        'modelUser'=>$modelUser,
    ]) ?>

</div>
