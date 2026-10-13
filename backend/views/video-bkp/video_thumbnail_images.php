<?php 
use yii\helpers\Html;
use kartik\typeahead\Typeahead;
use kartik\spinner\Spinner;

$content = '';
$addvideobutton = '';
$selectedVideoTitle = array();

if (!empty($VideoThumbImageList)) {
    foreach ($VideoThumbImageList as $videolistsub) {
        $videothumb = $videolistsub['ImageName'];
        if ($videothumb != '') {
            // $s3BucketDetail = @getimagesize(ImagesUrl($videolistsub));

            // if (isset($s3BucketDetail['bits']) && $s3BucketDetail['bits'] > 0){
                $videothumbpage =
                '<img class="thumbnail img-responsive" src="'.ImagesUrl($videolistsub) . '">';
           //  }else{
           //     $videothumbpage =
           //     Html::img('@web/images/thumbnail-default.jpg',
           //      ['class' => 'thumbnail img-responsive']);
           // }
       } else {
        $videothumbpage =
        Html::img('@web/images/thumbnail-default.jpg',
            ['class' => 'thumbnail img-responsive']);
    }
    $content.='<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumbimages" class="videothumbimagechkbox videothumbchkbox" value="' . $videolistsub['ImageID'] . '">' . $videothumbpage . '<p>' . $videolistsub['Title'] . '</p></div>';
    array_push($selectedVideoTitle,$videolistsub['Title']);
}
$addthumbImagesbutton = Html::label('Add Thumb Images','',['class' => 'addthumbimages btn btn-primary','style' => 'cursor:pointer']);
} else {
    $content = 'No Records Found';
    echo $content;
}
?>
<div class="modal fade bs-example-modal-lg filterPopupModel" id="VideoThumbnailImageModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <?php 
                if (!empty($VideoThumbImageList)) { ?>

                <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Video Thumbnail </h4>
                    <div class="pull-right">
                        <?php
                        echo Typeahead::widget([
                            'name' => 'videolist',
                            'options' => ['placeholder' => 'Enter Thumbnail Title ...',
                            'class' => 'videoname filterInput',
                            'style'=>'width:400px;background-color:none;',
                            'id'=>'videoThumbnailImage_input',
                        ],
                        'pluginOptions' => ['highlight' => true],
                        'pluginEvents' => [
                                                           // "typeahead:selected" => "function(obj, item) { selectThumbnailImages(item); return false;}",],
                           "typeahead:selected" => "function(obj, item) { filterPopup($('#videoThumbnailImage_input'));return false; }",
                       ],
                       'dataset' => [
                        [
                            'local' => $selectedVideoTitle,
                            'limit' => 10,
                        ]
                    ]
                ]);
                ?>
                <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick="$('#videoThumbnailImage_input').val('');filterPopup($('#videoThumbnailImage_input')); return false; ">
                    <span class="close_icon glyphicon glyphicon-remove"></span>
                </a>
            </div>
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