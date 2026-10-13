<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomadvertisementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Custom Avertisements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customadvertisement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    \yii\widgets\Pjax::begin(
        ['id' => 'CustomAdvertisementList', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]
    );
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $model->search(),
        'filterModel' => $model,
        'layout' => "{items}\n{pager}{summary}",
        'columns' => [
            [
                'attribute' => 'Title',
                'value' => function($data) {
                    $url = Url::toRoute('customadvertisement/update?id=' . $data['CustomAdvertiseID']);
                    return Html::a($data['Title'], $url, ['data-pjax' => "0"]);
                },
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter Advertisement Title..'
                ],
                'format' => 'raw',
            ],
            [
                'attribute' => 'VideoURL',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter Advertisement URL..',
                ],
                'value' => function($data) {
                    if($data['IsExternal'] != 1)
                        return (!empty($data['VideoURL'])) ? urldecode(S3_THUMB_CLOUDFRONT . '/' . $data['VideoURL']) : '';
                    else
                        return (!empty($data['URL'])) ? urldecode ($data['URL']) : '';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'FromDate',
                'value' => function($data) {
                    return (!empty($data['FromDate'])) ? ConvertDateTolocaltime($data['FromDate'],"d M Y h:i A") : "";
                            // return $data['PublishDate'];
                },
                'filter' => false,
            ],
            [
                'attribute' => 'ToDate',
                'value' => function($data) {
                    return (!empty($data['ToDate'])) ? ConvertDateTolocaltime($data['ToDate'],"d M Y h:i A") : "";
                            // return $data['PublishDate'];
                },
                'filter' => false,
            ],
            [
                'header' => 'Status',
                'attribute' => 'Status',
                'filter' => Html::activeDropDownList($model, 'Status', array("" => "All", "1" => "Active", "2" => "Inactive"), ['class' => 'form-control', 'options' => [ "" => ['selected ' => true]]]),
            ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => ['delete' =>
            function ($url, $model) {
                return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        Url::toRoute('customadvertisement/delete?id=' . $model['CustomAdvertiseID']),[
                            'title'=>'Delete',
                            'aria-label'=>"Delete",
                            'data-pjax' => "0",
                            'data-method'=>"post",
                            'data-confirm'=>"Are you sure you want to delete this item?"
                    ]);
         }
     ],          


 ],
],
]);
?>
<?php \yii\widgets\Pjax::end(); ?>
</div>
