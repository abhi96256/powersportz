<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Homepage */

$this->title = 'Department Update';
$this->params['breadcrumbs'][] = ['label' => 'Department', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->ro, 'url' => ['view', 'id' => $model->HomeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="homepage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
