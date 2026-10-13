<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(
            ['id' => 'ImagesList', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]
        ); ?>
    <?= GridView::widget([
        'dataProvider' => $model->search(),        
        'filterModel' => $model,
        'columns' => [
            [
                    'header'=>'Thumbnail',
                    'attribute'=>'ImageName',
                    'value' => function($data) {
                        return '<img src="'.S3_BUCKETABSOLUTE_PATH.'/'.THUMBNAILS.'/'.$data['ImageName'].'" width="50" height="50">';
                    },
                    'format'=>'html', 
                    'filter'=>false,        
            ],
            [
                    'attribute'=>'Title',
                    'value' => function($data) {
                        $url = Url::toRoute('images/update?id='.$data['ImageID']);
                        return Html::a($data['Title'],$url,['data-pjax'=>"0"]);
                    },
                    'format'=>'raw',        
            ],
            [
                    'header'=>'Action',
                    'value' => function($data) {
                        $url = Url::toRoute('images/delete?id='.$data['ImageID']);
                        return '<a href="'.$url.'"><span class="glyphicon glyphicon-trash" ></span></a>';
                    },
                    'format'=>'html', 
                    'filter'=>false,                
            ],                
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>

<?php
$this->registerJs('
            $(".glyphicon-trash").click(function() {
                if(!confirm("Are you sure you want to delete this item?")) {
                    return false;
                } 
            });    
');
?>
