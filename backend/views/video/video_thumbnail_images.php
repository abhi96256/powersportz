<?php 
use yii\helpers\Html;
use yii\helpers\Url;
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
} else {
  //  $content = 'No Records Found';
 //   echo $content;
} 
$addthumbImagesbutton = Html::label('Add Thumb Images','',['class' => 'addthumbimages btn btn-primary','style' => 'cursor:pointer']);
?>
<div class="modal fade bs-example-modal-lg filterPopupModel" id="VideoThumbnailImageModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <?php 
               // if (!empty($VideoThumbImageList)) { ?>

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
                         "typeahead:selected" => "function(obj, item) { /*filterPopup($('#videoThumbnailImage_input'));*/
                         return false; }",
                         'typeahead:render'=>"onRender",
                     ],
                     'dataset' => [
                        [
                          'display' => 'MetaKeywords',
                          'remote' => [
                            'url' => Url::to(['video/thumb-image-list']) . '?q=%QUERY',
                            'wildcard' => '%QUERY'
                        ],
                        'limit'=>9999999
                    ]
                ]
            ]);
            ?>
            <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick="$('#videoThumbnailImage_input').val(''); /*filterPopup($('#videoThumbnailImage_input')); return false;*/ ">
                <span class="close_icon glyphicon glyphicon-remove"></span>
            </a>
        </div>
    </div>
    <?php // }
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
<?php 
//template ="<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumbimages" class="videothumbimagechkbox videothumbchkbox" value="402"><img class="thumbnail img-responsive" src="https://drwqnsbdhm8v.cloudfront.net/Thumbnails/Thumb/1452593059801.jpg"><p>basket ball 3 </p></div>";
$this->registerJs('function onRender() { 
    var suggestions = Array.prototype.slice.call(arguments, 1);
    wrapper = $(".displaycontetnForThumbImages");
    items = wrapper.find(".video_block.col-lg-3.col-sm-4.col-xs-6");
    items.each(function(i,v){
        console.log($(v).find("input:checkbox").is(":checked")==false);
        if($(v).find("input:checkbox").is(":checked") == false)
            {
                $(v).remove();
            }
    });
    html ="";
    $.each(suggestions,function(index,item){
        //console.log(items.find(\'input:checkbox[value="\'+item.ImageID+\'"]\').length); 
        if(!items.find(\'input:checkbox[value="\'+item.ImageID+\'"]\').length){
            html ="<div class=\"video_block col-lg-3 col-sm-4 col-xs-6\"><input type=\"checkbox\" name=\"videothumbimages\" class=\"videothumbimagechkbox videothumbchkbox\" value=\""+item.ImageID+"\"><img class=\"thumbnail img-responsive\" src=\"'.S3_THUMB_CLOUDFRONT . '/' . THUMBNAILS . '/' . THUMBNAILS_THUMB . '/'.'"+item.ImageName+"\"><p> "+item.Title+"</p></div>";
            wrapper.append(html);
        }

    });

}');