<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BreakingnewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Breaking News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="breakingnews-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'columns' => [
           [
           'label'=>'Title',
           'attribute' => 'Title',
           'format' => 'raw',
       'value'=>function ($data) {
               return Html::a(Html::encode($data['Title']),'update?id='.$data['ID']);
        },
                                'filterInputOptions' => [
                'class'       => 'form-control',
                'placeholder' => 'Enter Breaking News Title..'
             ],
    ],[
                'header' => 'Status',
                'attribute' => 'Status',
          'value' => function ($data) {
                        return \backend\models\Breakingnews::getStatusValue($data['Status']);
                    },
                'filter'=>Html::activeDropDownList($searchModel, 'Status',array(""=>"All","1"=>"Active","2"=>"Inactive"),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
            ],
        ],
    ]); ?>

</div>
