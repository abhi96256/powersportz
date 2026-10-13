<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\videoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/common.js',['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/video.js', ['depends' => [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ]]); 

?>
<div class="video-index table-responsive">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(
            ['id' => 'VideoList', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]
        ); ?>

    <?= GridView::widget([
        'dataProvider' => $model->search(),        
        'filterModel' => $model,
        'layout'=>"{items}\n{pager}{summary}",
        'columns' => [
            [
                    'header'=>'Thumbnail',
                    'attribute'=>'ImageName',
                    'value' => function($data) {
                        if($data['ImageName'] != ''){
                            return '<img src="'.ImagesUrl($data).'">';
                        }
                        else {
                            return '<img src="../../images/thumbnail-default.jpg" width="50" height="50">';
                        }
                    },
                    'format'=>'html', 
                    'filter'=>false,        
            ],
            [
                    'header'=>'Video Title',
                    'attribute'=>'Title',
                    'filterInputOptions' => [
                        'class'=>'form-control',
                        'placeholder'=>'Enter Title',
                    ],
                    'value' => function($data) {
                        $url = Url::toRoute('video/update?id='.$data['ID']);
                        return Html::a($data['Title'],$url,['data-pjax'=>"0"]);
                    },
                    'format'=>'raw',         
            ],
            [
                    'header'=>'Uploded Date',
                    'attribute'=>'Created',
                    'value'=>function($data){ 
                        return $data['Created'] != '0000-00-00 00:00:00' ? ConvertDateTolocaltime($data['Created'],'d M Y h:i A'):'';
                    },
                    'filter'=>false,
            ],
            [
                    'header'=>'Published Date',
                    'attribute'=>'PublishDate',
                    'value' => function($data) {
                        return $data['PublishDate']!= '0000-00-00 00:00:00' ? ConvertDateTolocaltime( $data['PublishDate'],'d M Y h:i A'):'';
                       // return $data['PublishDate'];
                    },
                    'format'=>'raw',  
                    'filter' => false,
            ],
            [
                    'header'=>'Category',
                    'value' => function($data) {
                        return \backend\models\Video::GetVideoCategory($data['ID']);
                    },
                    'format'=>'html',  
                    'filter' => false,
            ],
            [
                    'header'=>'Approver Name',
                    'attribute'=>'username',
                    'filterInputOptions' => [
                        'class'=>'form-control',
                        'placeholder'=>'Approver Name',
                    ],
                    'value' => function($data) {
                        return $data['UserName'];
                        //return ($data['Status'] == 'Pending Approval') ? \backend\models\Video::GetSupervisorName($data['CreatedBy']) : ' - ';
                    },
                    'format'=>'html',  
                    'filter' => true,
            ],
            [
                'header' => 'Status',
                'attribute' => 'Status',
                'filter'=>Html::activeDropDownList($model, 'Status',array(""=>"All","1"=>"Active","2"=>"Inactive",'4'=>'Pending Approval','5'=>'Rejected'),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
            ], 
            [ 
              'class' => \yii\grid\ActionColumn::className(),
              'template'=>'{delete}',
              'buttons'=>[
                'delete'=>function($url,$model){
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',['video/delete','id'=>$model['ID']],[
                        'title'=>"Delete",
                        'aria-label'=>"Delete",
                        'data-confirm'=>"Are you sure you want to delete this item?",
                        'data-method'=>"post",
                        'data-pjax'=>"0"
                    ]);
                }
              ]
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
