<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(
            ['id' => 'PostList', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]
        ); ?>
    <?= GridView::widget([
        'dataProvider' => $model->search(),        
        'filterModel' => $model,
        'layout'=>"{items}\n{pager}{summary}",
        'columns' => [
                [
                    //'header'=>'Name',
                    'attribute'=>'UserName',
                    'filterInputOptions' => [
                        'class'=>'form-control',
                        'placeholder'=>'Enter UserName',
                    ],
                    'value' => function($data) {
                        $url = Url::toRoute('user/update?id='.$data['UserID']);
                        return Html::a($data['UserName'],$url,['data-pjax'=>"0"]);
                    },
                    'format'=>'raw',        
                ],
                [
                    //'header'=>'Name',
                    'attribute'=>'Email',
                    'filterInputOptions' => [
                        'class'=>'form-control',
                        'placeholder'=>'Enter Email',
                    ],
                ],
               // 'Email',
                [
                'header' => 'UserType',
                'attribute' => 'UserType',
                'filter'=>Html::activeDropDownList($model, 'UserType',array(""=>"All","1"=>"Admin","2"=>"Staff"),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
                ], 
                [
                'header' => 'Status',
                    'attribute' => 'Status',
                    'filter'=>Html::activeDropDownList($model, 'Status',array(""=>"All","1"=>"Active","2"=>"Inactive"),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
                ],            
            /*[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}',
                'buttons' => [
	                'update' => function ($url,$model) {
                            $url = Url::toRoute('user/update?id='.$model['UserID']);
	                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',$url,['data-pjax'=>"0"]);
	                },
	        ],
            ],*/
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
