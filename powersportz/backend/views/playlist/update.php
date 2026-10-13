<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Playlist */

$this->title = 'Update Throwback';
$this->params['breadcrumbs'][] = ['label' => 'Throwback', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Title, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="playlist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
         'videoinlist'=>$videoinlist,
        'videooutlist'=>$videooutlist,
        'countryData'=>$Countrydata
    ]) ?>

</div>
