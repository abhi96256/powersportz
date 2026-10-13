<?php
ini_set('memory_limit','2048M');
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Customadvertisement */

$this->title = 'Create Custom Advertisement';
$this->params['breadcrumbs'][] = ['label' => 'Customadvertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="customadvertisement-create">

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
