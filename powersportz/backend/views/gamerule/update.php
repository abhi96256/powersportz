<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Gamerule */

$this->title = 'Update Live Scores: ' . ' ' . $model->Title;
$this->params['breadcrumbs'][] = ['label' => 'Gamerules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Title, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="gamerule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
