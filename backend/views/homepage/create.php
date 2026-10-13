<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Homepage */

$this->title = 'Create Homepage';
$this->params['breadcrumbs'][] = ['label' => 'Homepages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homepage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
