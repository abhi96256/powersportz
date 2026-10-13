<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use dosamigos\multiselect\MultiSelect;
use yii\helpers\Url;
use kartik\spinner\Spinner;
use kartik\file\FileInput;
// FileInput inside a modal dialog
use yii\bootstrap\Modal;
use backend\models\Images;

$this->title = 'Add Banner';

$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="pull-right">
    <?= Html::a('Back', ['topsection'], ['class' => 'btn btn-primary']) ?>
</p>
<div class="banner-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php

    /* @var $this yii\web\View */
    /* @var $model backend\models\Homepage */
    /* @var $form yii\widgets\ActiveForm */

    $selectedvideotitle = array('');
    $selectedschedulevideotitle = array('');
    $selectedAccompnyVideoTitle = array('');
    $selectedAdvertisementVideoTitle = array('');
    $this->registerJs("
    var checkdbx=new Array();
    var checkedbx=new Array();
    $('.removeplyvideo').click(function(){
        var category=$(this).attr('id');
        $('input:checkbox[name=imagethumb]').each(function(){
            if($(this).is(':checked')) {
                var chkbxvlu=$(this).val();
                checkdbx.push(chkbxvlu);
                $(this).parent('div').hide();
            }
        });
        if(checkdbx.length > 0) {
            $('.arrayvideoout').val(JSON.stringify(checkdbx));
        }
    });
    //reorderAccompanyingVideosHtml();
    ", yii\web\View::POS_END, 'playlist-form');
    //$this->registerJsFile('/js/homepage.js',['position'=>yii\web\View::POS_END],'playlist-form');
    $this->registerJsFile(Yii::$app->request->baseUrl . '/js/common.js', ['depends' => [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);
    $this->registerJsFile(Yii::$app->request->baseUrl . '/js/homepage.js', ['depends' => [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ]]);
    ?>

    <div class="homepage-form">
        <?php
        $form = ActiveForm::begin(
            [
                'options' =>
                ['class' => 'twoColumnForm'],
                'id' => 'banner-homepage'
            ]
        );
        ?>
        <?= $form->errorSummary($model); ?>
        <div id="externalVideoURL">
            <?php echo $form->field($model, 'ExternalRedirectLink')->textInput(['maxlength' => true, 'placeholder' => 'Image Redirect Link', 'id' => 'external-image-redirection'])->error(false) ?>

            <div class="form-group">
                <?php
                echo Html::label('Banner Image <br/><code> ( Recommended image size : 1280 X 720 )</code>', 'external_link_thumb', ['class' => 'control-label']);
                ?>

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
        <?php echo $form->field($model, 'ImageID')->hiddenInput()->label(false)->error(false); ?>
        <?php $model->MainVideoType = 3; ?>
        <?php echo $form->field($model, 'MainVideoType')->hiddenInput()->label(false)->error(false); ?>
        <div class="form-group"><br><?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

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
        form = $('#banner-homepage');
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
                            $('[name="HomepageTopSection[ExternalVideoThumb]"]').val(filename);
                            $('[name="HomepageTopSection[ImageID]"]').val(response.id);
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

    function deleteLiveTvThumb(ele) {
        _ele = $(ele);
        src = _ele.data("src");
        $.ajax({
            type: 'POST',
            url: '<?php echo Url::to('delete-livetv-thumb') ?>',
            data: {
                filename: src,
                ImageID: _ele.data("id")
            },
            dataType: 'json',
            async: false,
            success: function(response) {
                if (response.status = '200') {
                    _ele.closest('.thumb_block').remove();
                }

            }
        });
        //   var bucket = new AWS.S3({params: {Bucket: '<?php echo S3BUCKET; ?>'}});
        //   var params = {Bucket: '<?php echo S3BUCKET; ?>',Key: '<?php echo THUMBNAILS ?>/'+src};
        //   bucket.deleteObjects(params, function(err, data) {
        //     if (err) console.log(err, err.stack); // an error occurred
        //     else     console.log(data);           // successful response
        // });
    }

    function selectLiveTvThumb(ele) {
        console.log(ele);
        if ($('.livetvcontainer').find('.live_thumb_checkbox:checked').length) {
            val = $('.livetvcontainer').find('.live_thumb_checkbox:checked').val();
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
            $('[name="HomepageTopSection[ImageID]"]').val(val);
        }
        $('#livetv-thumb-library').modal('hide');
    }
</script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<?php
$this->registerJsFile('@web/js/jquery.tagsinput.js', ['depends' => [
    'yii\web\YiiAsset',
    'yii\web\JqueryAsset',
]]);
