<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Breakingnews */

$this->title = 'Update Breakingnews: ' . ' ' . $model->Title;
$this->params['breadcrumbs'][] = ['label' => 'Breakingnews', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Title, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="breakingnews-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
<h1> Breaking News Details </h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
