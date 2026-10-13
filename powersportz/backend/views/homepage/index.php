<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HomepageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Homepages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homepage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Homepage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}{summary}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'HomeID',
            'MainVideoType',
            'VideoID',
            'ExternalVideoURL:url',
            'AccompanyingID',
            // 'NewsOrAdd',
            // 'AdvertisementID',
            // 'CategoryID',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
