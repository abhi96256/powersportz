<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = 'Create Talking Turkey';
$this->params['breadcrumbs'][] = ['label' => 'Talking Turkey', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'countrylist'=>$countrylist
    ]) ?>

</div>
