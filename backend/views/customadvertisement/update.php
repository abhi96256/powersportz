<?php
ini_set('memory_limit', '-1');
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Customadvertisement */

$this->title = 'Update Custom Advertisement';
$this->params['breadcrumbs'][] = ['label' => 'Customadvertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Title, 'url' => ['view', 'id' => $model->CustomAdvertiseID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="customadvertisement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'videooutlist'=>$videooutlist,
        'playlistData'=>$playlistData,
        'categoryData'=>$categoryData,
        'topicsData'=>$topicsData,
        'talkingData'=>$talkingData,
        'customVideo'=>$customVideo,
    ]) ?>

</div>
