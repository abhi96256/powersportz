<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Video */

$this->title = 'Update Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Title, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<p class="pull-right">
    <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="video-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div style="clear: both; margin-top: 40px; margin-bottom: 30px; padding: 15px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 5px;">
        <button id="btn-check-transcoding" class="btn btn-warning" data-id="<?= $model->ID ?>">
            <i class="fa fa-refresh"></i> Check AWS Transcoding Status
        </button>
        <span id="transcoding-msg" style="margin-left: 15px; font-weight: bold;"></span>
    </div>

    <?php
    $ajaxUrl = yii\helpers\Url::to(['video/check-transcoding-status']);
    $js = <<<JS
    $('#btn-check-transcoding').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var msg = $('#transcoding-msg');
        var videoId = btn.data('id');
        
        var csrfParam = $('meta[name="csrf-param"]').attr("content");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var postData = { video_id: videoId };
        if (csrfParam) {
            postData[csrfParam] = csrfToken;
        }

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Checking...');
        msg.text('Checking status with AWS...').css('color', 'blue');
        
        $.ajax({
            url: "{$ajaxUrl}",
            type: "POST",
            data: postData,
            dataType: "json",
            success: function(response) {
                if(response.success) {
                    msg.text(response.message).css('color', 'green');
                    btn.html('<i class="fa fa-check"></i> Done');
                    // Reload page after a short delay
                    setTimeout(function(){ location.reload(); }, 2000);
                } else {
                    msg.text(response.message).css('color', 'red');
                    btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Check AWS Transcoding Status');
                }
            },
            error: function(xhr, status, error) {
                msg.text('Error occurred: ' + xhr.responseText).css('color', 'red');
                btn.prop('disabled', false).html('<i class="fa fa-refresh"></i> Check AWS Transcoding Status');
            }
        });
    });
JS;
    $this->registerJs($js);
    ?>


    <?= $this->render('_form', [
        'model' => $model,
        'playlistData'=>$playlistData,
        'topicsData'=>$topicsData,
        'countryData'=>$countryData,
        'images'=>$images,
        'videosList'=>$videosList,
        'isShowStatus'=>$isShowStatus,
        'VideoThumbImageList'=>$VideoThumbImageList,
        'DefaultGeneratedImages'=>$DefaultGeneratedImages,
        'autherName'=>$autherName
        ]); ?>

    </div>
