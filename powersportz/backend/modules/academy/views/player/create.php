<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\academy\models\Player */
/* @var $school backend\modules\academy\models\School|null */

$this->title = 'Create Player';
?>

<div class="academy-player-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'school' => $school,
    ]) ?>
</div>
