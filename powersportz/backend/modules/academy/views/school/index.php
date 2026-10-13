<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Academy Schools';
?>

<div class="academy-school-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create School', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}{summary}",
        'summaryOptions' => ['class' => 'summary pull-right'],
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'ntext',
                'headerOptions' => ['style' => 'width: 10%;'],
            ],
            'contact_email',
            'phone',
            [
                'attribute' => 'principal',
                'format' => 'ntext',
                'headerOptions' => ['style' => 'width: 10%;'],
            ],
            [
                'attribute' => 'address',
                'format' => 'ntext',
                'headerOptions' => ['style' => 'width: 20%;'],
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return ((int) $model->status === 1) ? 'Active' : 'Inactive';
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d'); // You can adjust the format as needed
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {students} {teachers}',
                'buttons' => [
                    'students' => function ($url, $model, $key) {
                        $url = ['/academy/player/index', 'school_id' => $model->id];
                        return Html::a('Students', $url, [
                            // 'class' => 'btn btn-xs btn-default',
                            'title' => 'Students',
                            'style' => 'margin-left:5px;',
                        ]);
                    },
                    'teachers' => function ($url, $model, $key) {
                        $url = ['/academy/teacher/index', 'school_id' => $model->id];
                        return Html::a('Teachers', $url, [
                            // 'class' => 'btn btn-xs btn-default',
                            'title' => 'Teachers',
                            'style' => 'margin-left:1px;',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>
</div>
