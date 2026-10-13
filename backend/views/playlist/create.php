<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Playlist */

$this->title = 'Create Throwback';
$this->params['breadcrumbs'][] = ['label' => 'Throwback', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="playlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'videooutlist'=>$videooutlist,
        'countryData'=>$countrydata
    ]) ?>

</div>
