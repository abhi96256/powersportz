<?php 
use yii\helpers\Html;
use kartik\typeahead\Typeahead;
use kartik\spinner\Spinner;

$content = '';
$addvideobutton = '';
$selectedVideoTitle = array();
$placeholder = Yii::$app->request->baseUrl . '/images/thumbnail-default.jpg';
$placeholderJs = json_encode($placeholder);

if (!empty($DefaultGeneratedImages)) {
    foreach ($DefaultGeneratedImages as $videolistsub) {
        $videothumb = $videolistsub['ImageName'];
        if ($videothumb != '') {
            $videothumbpage =
                    '<img class="thumbnail img-responsive" style="width:100%;height:120px;object-fit:cover;background:#222;" src="'.Html::encode(ImagesUrl($videolistsub)) . '" onerror="this.onerror=null;this.src=' . $placeholderJs . ';">';
        } else {
            $videothumbpage =
                    Html::img('@web/images/thumbnail-default.jpg',
                            ['class' => 'thumbnail img-responsive', 'style' => 'width:100%;height:120px;object-fit:cover;']);
        }
        $content.='<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumbimages" class="videothumbimagechkbox videothumbchkbox" value="' . Html::encode($videolistsub['ImageID']) . '">' . $videothumbpage . '<p>' . Html::encode($videolistsub['Title']) . '</p></div>';
       // array_push($selectedVideoTitle,$videolistsub['Title']);
    }
    $addthumbImagesbutton = Html::label('Add Default Images','',['class' => 'addgeneratedthumbimages btn btn-primary','style' => 'cursor:pointer']);
} else {
    $content = 'No Records Found';
}
?>
<div class="modal fade bs-example-modal-lg filterPopupModel" id="DefaultVideoThumbnailImageModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <?php 
                    if (!empty($DefaultGeneratedImages)) { ?>

                            <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Generated Thumbnail Images</h4>
                               <!--  <div class="pull-right">
                                    <?php
                                   /* echo Typeahead::widget([
                                        'name' => 'videolist',
                                        'options' => ['placeholder' => 'Enter Thumbnail Title ...',
                                                        'class' => 'videoname filterInput',
                                                        'style'=>'width:400px;background-color:none;',
                                                        'id'=>'defaultvideoThumbnailImage_input',
                                                     ],
                                                'pluginOptions' => ['highlight' => true],
                                                'pluginEvents' => [
                                                           // "typeahead:selected" => "function(obj, item) { selectThumbnailImages(item); return false;}",],
                                                       "typeahead:selected" => "function(obj, item) { filterPopup($('#defaultvideoThumbnailImage_input'));return false; }",
                                                       ],
                                                 'dataset' => [
                                                [
                                                    'local' => $selectedVideoTitle,
                                                    'limit' => 10,
                                                ]
                                        ]
                                    ]);*/
                                    ?>
                                     <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick="$('#videoThumbnailImage_input').val('');filterPopup($('#videoThumbnailImage_input')); return false; ">
                                            <span class="close_icon glyphicon glyphicon-remove"></span>
                                    </a>
                                </div> -->
                            </div>
                    <?php }
                ?>
                <div class="panel-body">
                    <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Thumb Images</div>
                    <div class="displaycontetnForThumbImages"><?= $content; ?></div>
                </div>

                <div class="panel-footer"><?= (!empty($addthumbImagesbutton)) ? $addthumbImagesbutton : "";?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="spinnerLoaderForThumbImages" style="display:none;">
    <?php echo Spinner::widget([
                    'preset' => Spinner::LARGE,
                    'color' => 'blue',
                    'align' => 'center'
            ]);
    ?>
    </div>
</div>