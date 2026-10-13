<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use backend\models\Images;
use kartik\file\FileInput;
use kartik\spinner\Spinner;
use yii\widgets\ActiveForm;
// FileInput inside a modal dialog
use kartik\typeahead\Typeahead;
use dosamigos\multiselect\MultiSelect;


/* @var $this yii\web\View */
/* @var $model backend\models\Category */

/*$this->title = $model->CategName;*/

$this->title = 'Top Home Section Config';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

$this->registerJsFile(Yii::$app->request->baseUrl . '/js/common.js', [
    'depends' => [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset'
    ],
    'position' => \yii\web\View::POS_HEAD
]);

$selectedvideotitle = array('');
?>
<style>
    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        min-width: 200px;
        padding: .5rem 0;
        margin: .125rem 0 0;
        font-size: 1rem;
        color: #212529;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, .15);
        border-radius: .25rem;
    }

    .dropdown-item {
        display: block;
        width: 100%;
        padding: .25rem 1.5rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        font-size:large
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #16181b;
    }
</style>
<div class="category-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-xs-12">
        <!-- <p>
            <?= Html::a('Add', ['javascript:void(0)'], ['class' => 'btn btn-success', 'id' => 'add-button']) ?>
        </p>  -->

        <div class="dropdown" style="float:right; text-align:right;">
            <?= Html::button('+ CREATE', [
                'class' => 'btn btn-success dropdown-toggle', // custom class for pink color
                'id' => 'create-button',
                'data-toggle' => 'dropdown',
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false'
            ]) ?>

            <div class="dropdown-menu" aria-labelledby="create-button">
                <?= Html::a('Image', 'javascript:void(0)', ['class' => 'dropdown-item option_button', 'data-type' => 'image', 'data-href' => Url::toRoute('homepage/add-banner')]) ?>
                <?= Html::a('Video', 'javascript:void(0)', ['class' => 'dropdown-item option_button', 'data-type' => 'video']) ?>
                <?= Html::a('Live Streaming', 'javascript:void(0)', ['class' => 'dropdown-item option_button', 'data-type' => 'stream', 'data-href' => Url::toRoute('homepage/add-stream')]) ?>
            </div>
        </div>
    </div>
    <?php
    $content = '';
    $addvideobutton = '';
    $valueforloop = 0;
    if (!empty($videooutlist)) {
        foreach ($videooutlist as $videolistsub) {
            $videothumb = $videolistsub['ImageName'];
            if ($videothumb != '') {
                $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
                //  $videothumbpage = '<img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub) . '">';
            } else {
                $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
            }
            $content .= '<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="radio" name="videothumb" class="videothumbchkbox" value="' . $videolistsub['ID'] . '">' . $videothumbpage . '<p>' . $videolistsub['Title'] . '</p></div>';
            array_push($selectedvideotitle, $videolistsub['Title']);
            if ($valueforloop++ == 3) break;
        }
        $addvideobutton = Html::label('Add Selected Video', '', ['class' => 'addvideolist btn btn-primary', 'style' => 'cursor:pointer']);
    } else {
        $content = 'No Records Found';
    }
    ?>
</div>

<div class="modal fade bs-example-modal-lg filterPopupModel" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">

                <input type="hidden" id="recording_video_hidden" value="">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;">Videos </h4>
                    <div class="pull-right">
                        <?php
                        echo Typeahead::widget([
                            'name' => 'videolist',
                            'options' => [
                                'placeholder' => 'Enter Video Title ...',
                                'class' => 'videoname filterInput',
                                'style' => 'width:400px;background-color:none;',
                                'id' => 'main_video_input',
                            ],
                            //'pluginOptions' => ['highlight' => true],
                            'pluginOptions' => ['highlight' => true, 'minLength' => 0],
                            //'pluginEvents' => ["typeahead:selected" => "function(obj, item) { selectVideo(item); return false;}"],
                            'pluginEvents' => [
                                "typeahead:selected" => "function(obj, item) { filterPopup($('#main_video_input'));return false; }",
                            ],
                            'dataset' => [
                                [
                                    'local' => $selectedvideotitle,
                                    'limit' => 10
                                ]
                            ]
                        ]);
                        ?>
                        <a title="Clear text" class="clear_text" href="javascript:void(0);" onclick="$('#main_video_input').val(''); filterPopup($('#main_video_input')); return false;">
                            <span class="close_icon glyphicon glyphicon-remove"></span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
                    <?php
                    $form = ActiveForm::begin(
                        [
                            'options' =>
                            ['class' => 'twoColumnForm'],
                            'id' => 'homepage-topsection'
                        ]
                    );
                    ?>
                    <div class="displaycontetn"><?php echo $content; ?></div>
                    <?php echo $form->field($model, 'VideoID')->hiddenInput()->label(false)->error(false); ?>
                    <?php echo $form->field($model, 'MainVideoType')->hiddenInput()->label(false)->error(false); ?>
                </div>
                <div class="panel-footer"><?php echo $addvideobutton; ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div id="spinnerLoaderForPopup" class="spinner_div" style="display:none;">
        <?php
        echo Spinner::widget([
            'preset' => Spinner::LARGE,
            'color' => 'blue',
            'align' => 'center'
        ]);
        ?>
    </div>
</div>

<div class="row video_category_block " id="sortable2">
    <?php
    if (!empty($videoinlist)) {
        $iml = 0;
        foreach ($videoinlist as $videolistinsub) {
            if ($videolistinsub['MainVideoType'] == 1) {
                $new_path = CDN_VIDEO_URL . $videolistinsub['ExternalVideoThumb'];
            } else {
                $new_path = S3_THUMB_CLOUDFRONT . '/Thumbnails/' . $videolistinsub['ExternalVideoThumb'];
            }
            echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="imagethumb" class="imagethumbchkbox" value="' . $videolistinsub['HomeID'] . '"><img class="thumbnail img-responsive" src="' . $new_path . '"></div>';
            if ($iml++ == 10) break;
        }
    } else {
        echo '<div class="col-lg-3 col-sm-4 col-xs-6"><p> No Records Found </p></div>';
    }
    ?>
</div>
<?php echo Html::hiddenInput('arrayvideoout', '', ['class' => 'arrayvideoout']); ?>
<div class="col-xs-4"><?= Html::label(
                            'Remove Selected',
                            null,
                            [
                                'class' => 'deletbutton btn btn-danger',
                                'style' => 'cursor:pointer;' . (empty($videoinlist) ? 'display:none;' : '')
                            ]
                        ) ?>
    <?= Html::button('Update', ['class' => 'btn btn-primary removeItems', 'style' => 'cursor:pointer;' . (empty($videoinlist) ? 'display:none;' : '')]) ?></div>



<div id="externalVideoURL" style="display:none" class="externalSection">
    <div class="homepage-form">
        <h4 class="panel-title pull-left" style="padding-top: 7.5px;">Add Live Stream </h4>
        <div class="homepage-form">
            <?php
            $form = ActiveForm::begin(
                [
                    'options' =>
                    ['class' => 'twoColumnForm'],
                    'id' => 'homepage-topsection2'
                ]
            );
            $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive', 'style' => 'width:25% !important']);
            ?>
            <div class="show_recorded_video show_main_video_image extra-form-control" style="display:none;"><?= $videothumbpage; ?><br><a class="btn btn-success" href="javascript:showVideoList();">Select Video</a></div>


            <div class="stream_section" style="display:none;">
                <?php echo $form->field($model, 'ExternalVideoURL')->textInput(['maxlength' => true, 'placeholder' => 'External video  links goes here', 'id' => 'external-video-url'])->error(false) ?>
            </div>
            <div class="image_section" style="display:none;">
                <?php echo $form->field($model, 'ExternalRedirectLink')->textInput(['maxlength' => true, 'placeholder' => 'Image Redirect Link', 'id' => 'external-image-redirection'])->error(false) ?>
            </div>


            <div class="form-group">
                <div class="stream_section" style="display:none;">
                    <?php
                    echo Html::label('External Video Thumb <br/><code> ( Recommended image size : 1280 X 720 )</code>', 'external_link_thumb', ['class' => 'control-label']);
                    ?>
                </div>

                <div class="image_section" style="display:none;">
                    <?php
                    echo Html::label('Image Thumb <br/><code> ( Recommended image size : 1280 X 720 )</code>', 'external_link_thumb', ['class' => 'control-label']);
                    ?>
                </div>

                <div class="upload_section" style="display: none;">
                    <?php
                    $pluginOptions = [
                        'allowedFileExtensions' => ['jpg', 'png'],
                        'showPreview' => true,
                        'showRemove' => false,
                        'showUpload' => false,
                        'showCaption' => false,
                    ];


                    echo FileInput::widget(
                        [
                            'name' => 'external_link_thumb',
                            'options' => ['multiple' => false],
                            'pluginOptions' => $pluginOptions
                        ]
                    );
                    ?> &nbsp;&nbsp;
                    <?php
                    Modal::begin([
                        'header' => 'Library',
                        'id' => 'livetv-thumb-library',
                        'size' => 'modal-lg',
                        'footer' => Html::button('Apply', ['class' => 'select-thumb btn btn-primary']),
                        'toggleButton' => [
                            'label' => 'Select From Library',
                            'class' => 'btn btn-primary btn btn-info',
                            'style' => 'color: #fff;
            background-color: #5bc0de;
            border-color: #46b8da;'
                        ],
                    ]);
                    ?>
                    <div class="livetvcontainer">
                        <?php
                        $images = Images::find()->where(['imageType' => '4'])->orderBy('Created DESC')->limit(20)->All();
                        //   $images = Images::find()->where(['imageType' => '4'])->groupBy('minute(Created)')->orderBy('Created DESC')->All();

                        foreach ($images as $image) {
                            if ($image['ImageName']) {
                        ?>
                                <div class="thumb_block col-lg-3 col-sm-4 col-xs-6">
                                    <input type="radio" name="external_link_thumb_checkbox" class="live_thumb_checkbox " value="<?= $image['ImageID'] ?>" <?php
                                                                                                                                                            echo
                                                                                                                                                            $image['ImageName'] == $model->ExternalVideoThumb ? 'checked=checked' : ''
                                                                                                                                                            ?>>
                                    <button type="button" class="pull-right btn btn-danger removeButton" data-id="<?= $image['ImageID']; ?>" data-src="<?= $image['ImageName']; ?>" onclick="javascript:deleteLiveTvThumb(this);">X</button>
                                    <img class="thumbnail img-responsive" src="<?= S3_THUMB_CLOUDFRONT . '/' . THUMBNAILS . '/' . $image['ImageName']; ?>" alt="<?= $image['ImageName']; ?>">


                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                    Modal::end();
                    ?>
                </div>
            </div>
            <?php echo $form->field($model, 'ExternalVideoThumb')->hiddenInput()->label(false)->error(false); ?>
            <?php echo $form->field($model, 'MainVideoType')->hiddenInput()->label(false)->error(false); ?>
            <div class="form-group"><br><?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success submitbutton' : 'btn btn-primary']) ?></div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>


<div id="spinnerLoaderForPopup" class="spinner_div" style="display:none;">
    <?php
    echo Spinner::widget([
        'preset' => Spinner::LARGE,
        'color' => 'blue',
        'align' => 'center'
    ]);
    ?>
</div>
</div>

<script>
    $('.option_button').click(function(event) {
        event.preventDefault();
        let type = $(this).data('type');
        let redirectUrl = $(this).data('href');
        if (type == 'video') {
            $(".upload_section").hide();
            $('#myModal').modal('show');
            $('.externalSection').hide();
            $("#homepagetopsection-mainvideotype").val(1);
            // } else if (type == 'stream') {
            //     $(".upload_section").show();
            //     $('.externalSection').show();
            //     $('.stream_section').show();
            //     $('.image_section').hide();
            //     $('.show_main_video_image').hide();
            //     $("#homepagetopsection-mainvideotype").val(2);
        } else {
            // $(".upload_section").show();
            // $('.externalSection').show();
            // $('.image_section').show();
            // $('.stream_section').hide();
            // $('.show_main_video_image').hide();
            // $("#homepagetopsection-mainvideotype").val(3);
            window.location.href = redirectUrl;
        }
        console.log('Add button clicked!');

        // Add more functionality as needed
    });
</script>

<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1.24.min.js"></script>
<script type="text/javascript">
    AWS.config.update({
        accessKeyId: '<?php echo AWSACCESSKEY; ?>',
        secretAccessKey: '<?php echo AWSSECRETKEY; ?>'
    });
    AWS.config.region = '<?php echo AWSREGION; ?>';
</script>
<?php $this->registerJs('$(".select-thumb").on(\'click\', function () {
    selectLiveTvThumb($(this));
});'); ?>
<?php $this->registerJs('$(".removeItems").on(\'click\', function () {
    removeItems();
});'); ?>
<?php $this->registerJs(" $('.livetvcontainer').on('click','img.thumbnail.img-responsive',function(){
    var _ele = $(this);
    _ele.siblings('.live_thumb_checkbox').prop('checked', true);
});
$('[type=\"submit\"]').click(function(e){
    e.preventDefault();
    submitForm(this);
    return false;
});

"); ?>

<script>
    function submitForm() {
        form = $('#homepage-topsection');
        var fileChooser = $('[name="external_link_thumb"]');
        if (fileChooser[0].files.length > 0) {
            [].forEach.call(fileChooser[0].files, function(file) {
                var filename = 'livetv_' + (new Date).getTime() + '.' + file['name'].split('.').pop();
                var bucket = new AWS.S3({
                    params: {
                        Bucket: '<?php echo S3BUCKET; ?>'
                    }
                });
                var params = {
                    Key: '<?php echo BUCKET_FOLDER ?>/<?php echo THUMBNAILS ?>/' + filename,
                    ContentType: file.type,
                    Body: file
                };

                $(".kv-upload-progress").removeClass('hide');
                bucket.upload(params).on('httpUploadProgress', function(evt) {
                    var percentage = parseInt((evt.loaded * 100) / evt.total);
                    $(".kv-upload-progress").find('.progress-bar')
                        .css("width", percentage + "%")
                        .attr("aria-valuenow", percentage)
                        .text(percentage + "%");
                }).send(function(err, data) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Url::to('save-file') ?>',
                        data: {
                            filename: filename
                        },
                        dataType: 'json',
                        async: false,
                        success: function(response) {
                            console.log(response);
                            form.submit();
                        }
                    });
                });
            });
        } else {
            console.log(form);
            form.submit();
        }
    }

    function selectLiveTvThumb(ele) {
        if ($('.livetvcontainer').find('.live_thumb_checkbox:checked').length) {
            $('[name="external_link_thumb"]').fileinput('clear');
            src = $('.livetvcontainer').find('.live_thumb_checkbox:checked').siblings('img.thumbnail.img-responsive').attr('src');
            alt = $('.livetvcontainer').find('.live_thumb_checkbox:checked').siblings('img.thumbnail.img-responsive').attr('alt');
            target = $('.file-preview-thumbnails');

            template = '<div class="file-preview-frame" id="preview-1527763921521-0" data-fileindex="0">' +
                '<img src="' + src + '" class="file-preview-image" title="' + alt + '" alt="' + alt + '" style="width:auto;height:160px;">' +
                '<div class="file-thumbnail-footer">' +
                '<div class="file-footer-caption" title="' + src + '">' + alt + '</div>' +
                '</div>' +
                '</div>';
            target.html(template);
            target.closest('.file-preview').closest('.file-input').removeClass('file-input-new');
            $('[name="HomepageTopSection[ExternalVideoThumb]"]').val(alt);
        }
        $('#livetv-thumb-library').modal('hide');
    }

    function removeItems() {
        if ($('.video_category_block').find('.imagethumbchkbox:checked').length) {
            var arrayvideoout = $('[name="arrayvideoout"]').val();
            var currentUrl = '<?= Url::to('topsection') ?>';

            $.ajax({
                type: 'POST',
                url: '<?php echo Url::to('remove-items') ?>',
                data: {
                    arrayvideoout: arrayvideoout
                },
                dataType: 'json',
                async: false,
                success: function(response) {
                    console.log(currentUrl);
                    window.location.href = currentUrl;
                }
            });
        }
    }

    $(".addvideolist").click(function() {
        var form = $('#homepage-topsection');
        //Check validation
        var error = "Please select recorded video.";
        checkedVideo = $("#myModal input[name='videothumb']:checked");
        //Store video id in form
        if (RequiredValidation(checkedVideo, error, "myModal")) {
            $("#homepagetopsection-videoid").val(checkedVideo.val());
            $(".show_main_video_image").find('img').attr('src', $(checkedVideo).next('img').attr('src'))
            $(".show_main_video_image").show();
            $(".externalSection").show();
            $(".image_section").hide();
            $(".stream_section").hide();
            $('#myModal').modal('hide');
            form.submit();
        }

    });

    function showVideoList() {
        $(".show_recorded_video").show();
        $('#myModal').modal('show');

    }
</script>

<?php
$this->registerJs(
    "
  $('.deletbutton').click(function(){
    var checkdbx=new Array();
    var category=$(this).attr('id');
    $('input:checkbox[name=imagethumb]').each(function(){
      if($(this).is(':checked'))
       {
         var chkbxvlu=$(this).val();
         checkdbx.push(chkbxvlu);
         $(this).parent('div').hide();
       }
     });
     if(checkdbx.length > 0)
     {
      $('.arrayvideoout').val(JSON.stringify(checkdbx));
      var rmvvideolnth = checkdbx.length;
    }
    else
    {
      $('.vdoslcterrshw').show();
      setTimeout(function(){
        $('.vdoslcterrshw').hide();
      }, 5000);
    }
    var box= $('#sortable2').find('.col-lg-3.col-sm-4.col-xs-6:not(.removable)');
      
      if(box.is(':visible')==false){
        $('.deletbutton').hide();
      }else{
       $('.deletbutton').show();
     }
  });
",
    yii\web\View::POS_END,
    'category-view'
);
?>