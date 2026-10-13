<?php 
use yii\helpers\Html;
use kartik\typeahead\Typeahead;
use kartik\spinner\Spinner;

$content = '';
$addvideobutton = '';
$selectedVideoTitle = array();
// $videosList=false;
if (!empty($videosList)) {
    foreach ($videosList as $videolistsub) {
        $isActive = backend\models\Video::find()->where(['ID' => $videolistsub['VideoID']])->all();
        $crntDate = date('Y-m-d H:i:s');
        if($isActive[0]['Status'] == 1 && $crntDate >= $isActive[0]['PublishDate'])
        {    
            $videothumb = $videolistsub['ImageName'];
            if ($videothumb != '') {
                $s3BucketDetail = @getimagesize(ImagesUrl($videolistsub));

                if (isset($s3BucketDetail['bits']) && $s3BucketDetail['bits'] > 0){
                    $videothumbpage =
                    '<img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub) . '">';

                }
                else {
                    $videothumbpage =
                    Html::img('@web/images/thumbnail-default.jpg',
                        ['class' => 'thumbnail img-responsive']);
                }
            } else {
                $videothumbpage =
                Html::img('@web/images/thumbnail-default.jpg',
                    ['class' => 'thumbnail img-responsive']);
            }
            $content.='<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumb" class="videothumbchkbox" value="' . $videolistsub['VideoID'] . '">' . $videothumbpage . '<p>' . $videolistsub['video']['Title'] . '</p></div>';
            array_push($selectedVideoTitle,$videolistsub['video']['Title']);
        }
    }
    $addvideobutton = Html::label('Add Related Videos','',['class' => 'addrelatedvideo btn btn-primary','style' => 'cursor:pointer']);
} else {
    $content = 'No Records Found';
}

?>

<div class="modal fade bs-example-modal-lg filterPopupModel" id="RelatedVideoModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Related Videos </h4>
                    <div class="pull-right">
                        <?php
                        if(!empty($selectedVideoTitle)){
                            echo Typeahead::widget([
                                'name' => 'videolist',
                                'options' => ['placeholder' => 'Enter Video Title ...',
                                'class' => 'videoname filterInput',
                                'style'=>'width:400px;background-color:none;',
                                'id'=>'related_videos_input',
                            ],
                            'pluginOptions' => ['highlight' => true],
                            'pluginEvents' => [
                                                        //"typeahead:selected" => "function(obj, item) { selectRelatedVideo(item); return false;}",
                             "typeahead:selected" => "function(obj, item) { filterPopup($('#related_videos_input'));return false; }",
                         ],
                         'dataset' => [
                            [
                                'local' => $selectedVideoTitle,
                                'limit' => 10
                            ]
                        ]
                    ]);
                        }
                        ?>
                        <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick=" $('#related_videos_input').val('');filterPopup($('#related_videos_input')); return false;">
                            <span class="close_icon glyphicon glyphicon-remove"></span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
                    <div class="displaycontetnForRelatedVideo"><?= $content; ?></div>
                </div>
                <div class="panel-footer"><?= $addvideobutton;?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="spinnerLoaderForRelatedVideo" style="display:none;">
        <?php echo Spinner::widget([
            'preset' => Spinner::LARGE,
            'color' => 'blue',
            'align' => 'center'
        ]);
        ?>
    </div>
</div>