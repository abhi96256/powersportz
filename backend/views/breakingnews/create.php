<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Breakingnews */

$this->title = 'Add Breakingnews';
$this->params['breadcrumbs'][] = ['label' => 'Breakingnews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="breakingnews-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
