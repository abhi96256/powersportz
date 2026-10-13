<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaylistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Throwback';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="playlist-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(
        ['id' => 'PlayList', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]
        ); ?>
    <?= GridView::widget([
       'dataProvider' => $searchModel->search(),
       'filterModel' => $searchModel,
       'layout'=>"{items}\n{pager}",
       'columns' => [
        [
            'attribute' => 'Image',
            'format' => 'html',
        'value' => function($data) { return Html::img(S3_THUMB_CLOUDFRONT.'/'.PLAYLIST.'/Thumb/'.$data['VideoThumb']/*, ['width'=>'100']*/); },
    ],
    [
       'label'=>'Throwback Title',
       'attribute' => 'Title',
       'filterInputOptions' => [
        'class'       => 'form-control',
        'placeholder' => 'Enter Throwback Title..'
    ],
    'format' => 'raw',
    'value'=>function ($data) {
       return Html::a(Html::encode($data['Title']),'update?id='.$data['ID'],['data-pjax'=>"0"]);
   },
], 
[
    'label'=>'No of Active Videos',
    'attribute' => 'NoOfVideos',
    'filter'=>false,
],
[
    'header' => 'Restricted Country',
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
[
    'label'=>'Published Date',
    'attribute' =>'ScheduledRelease',
    'value' => function($data) {
        return ConvertDateTolocaltime($data['ScheduledRelease'],'d M Y h:i A');
    },
    'filter'=>false,
],
[
    'header' => 'Status',
    'attribute' => 'Status',
    'value' => function ($data) {
        return \backend\models\Playlist::getStatusValue($data['Status']);
    },
    'filter'=>Html::activeDropDownList($searchModel, 'Status',array(""=>"All","1"=>"Active","2"=>"Inactive"),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
],
[ 
  'class' => \yii\grid\ActionColumn::className(),
  'template'=>'{delete}',
  'buttons'=>[
    'delete'=>function($url,$model){
        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['playlist/delete','id'=>$model['ID']],[
            'title'=>"Delete",
            'aria-label'=>"Delete",
            'data-confirm'=>"Are you sure you want to delete this item?",
            'data-method'=>"post",
            'data-pjax'=>"0"
        ]);
    }
]
],

            // 'NoOfVideos',
            // 'DisplayIndex',
            // 'ScheduledRelease',
            // 'LangID',
            // 'Status',
            // 'CreatedBy',
            // 'UpdatedBy',
            // 'Created',
            // 'Updated',
],
]); ?>
<?php \yii\widgets\Pjax::end(); ?>
</div>
