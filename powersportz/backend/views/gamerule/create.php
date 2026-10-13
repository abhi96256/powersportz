<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Gamerule */

$this->title = 'Create Live Score';
$this->params['breadcrumbs'][] = ['label' => 'Gamerules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="gamerule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
