<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Talking Turkey';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(
            ['id' => 'TopicsList', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]
        ); ?>
    <?= GridView::widget([
        'dataProvider' => $searchModel->search(),
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'columns' => [
            //'ID',
            //'ParentCategID',
            //'CategName',
             [
           'label'=>'Name',
           'attribute' => 'CategName',
           'format' => 'raw',
       'value'=>function ($data) {
            return Html::a(Html::encode($data['CategName']),'view?id='.$data['ID'],['data-pjax'=>"0"]);
        },
                'filterInputOptions' => [
                'class'       => 'form-control',
                'placeholder' => 'Enter Action Title..'
             ],
    ],
		   [
                'header' => 'No. of Videos',
                'attribute' => 'video_count'
            ],
			     [
                'header' => 'Restricted Countries',
                'attribute' => 'cname',
                                 'value'     => function ($data) {
                if ($data['cname'] != null) {
                    return $data['cname']; 
              //or: return Html::encode($model->some_attribute)
                } else {
                    return '-';
                }
            },
            ],
            //'CategThumb',
            //'DisplayIndex',
              [
                'header' => 'Status',
                'attribute' => 'Status',
                'filter'=>Html::activeDropDownList($searchModel, 'Status',array(""=>"All","1"=>"Active","2"=>"Inactive"),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
            ],
             [ 
          'class' => \yii\grid\ActionColumn::className(),
          'template'=>'{delete}',
          'buttons'=>[
            'delete'=>function($url,$model){
                return Html::a('<span class="glyphicon glyphicon-trash"></span>',['talking-points/delete','id'=>$model['ID']],[
                    'title'=>"Delete",
                    'aria-label'=>"Delete",
                    'data-confirm'=>"Are you sure you want to delete this item?",
                    'data-method'=>"post",
                    'data-pjax'=>"0"
                ]);
            }
        ]
    ],
            // 'LangID',
            // 'CreatedBy',
            // 'UpdatedBy',
            // 'Created',
            // 'Updated',

            //	['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
