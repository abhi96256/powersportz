<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\academy\models\School */

$this->title = 'Update School';
?>
<p class="pull-right">
    <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>

<div class="academy-school-update">
    
    <style>
        .academy-school-update h1 {
            float: none;
            margin-bottom: 20px;
        }
    </style>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model,]) ?>
</div>
