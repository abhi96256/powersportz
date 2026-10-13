<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff Role Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-role-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add Staff User Role', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}{summary}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
         //   'id',
            //'role_name',
            [
                'attribute'=>'role_name',
                'value' => function($data) {
                    $url = Url::toRoute('user-role/update?id='.$data['id']);
                    return Html::a($data['role_name'],$url,['data-pjax'=>"0"]);
                },
                'format'=>'raw',        
            ],
           // 'status',
             /*['class' => 'yii\grid\ActionColumn',
              // 'template'=>'{view}{update}'
             ],*/
        ],
    ]); ?>

</div>
