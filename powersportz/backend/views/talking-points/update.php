<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Topics */

$this->title = 'Update Talking Turkey: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Talking Turkey', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="talking-points-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
