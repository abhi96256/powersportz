<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Video */

$this->title = $model->Title;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'Title',
            'Description:ntext',
            'GeneratedThumbnailTime',
            'ChangeThumbnailTime',
            'VideoURL:url',
            'VideoStreamURL:url',
            'MetaKeywords',
            //'ExternalVideoURL:url',
          //  'AdvertisementTagRL',
            'PublishDate',
            'FullVideoURL:url',
            'FullVideoStreamURL:url',
            'DisplayIndex',
            'LikeCount',
            'ViewCount',
            'IsFBShareEnabled:boolean',
            'IsTwitterShareEnabled:boolean',
            'AllowDownload',
            'LangID',
            'Status',
            'CreatedBy',
            'UpdatedBy',
            'Created',
            'Updated',
        ],
    ]) ?>

</div>
