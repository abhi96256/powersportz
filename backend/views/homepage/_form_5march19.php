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
                  ['options' =>
                      ['class' => 'twoColumnForm'],
                      'id' => 'update-homepage'
                  ]
  );
  ?>
  <?= $form->errorSummary($model); ?>
  <?php
  if (!empty($recordedVideoImage['ImageName'])) {
    //$videothumbpage = '<img class="thumbnail img-responsive" src="' . ImagesUrl($recordedVideoImage) . '">';
    $videothumbpage = '<img class="thumbnail img-responsive" src="' . Main_VideoUrl(ImagesUrl($mainVideoInfo[0])) . '">';
  } else {
    $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
  }
  ?>
  <?= $this->render('@app/views/layouts/snippet.php'); ?>

  <?php $IsShowMainVideo = ($model->MainVideoType != '1') ? "style='display:none;'" : "" ?>
  <?= $form->field($model, 'MainVideoType', ['template' => '{label}{input}<div class="show_recorded_video extra-form-control" ' . $IsShowMainVideo . '><br><a class="btn btn-success" href="javascript:showVideoList();">Select Video</a><br>
</div><div class="show_recorded_video show_main_video_image extra-form-control" ' . $IsShowMainVideo . '>' . $videothumbpage . '</div>'])->dropDownList([1 => 'Video', 2 => 'Streaming Link'], ['onchange' => 'showVideoList();'/* ,'prompt'=>'Select Main video' */]); ?>


  <div id="externalVideoURL" <?php if ($model->MainVideoType != '2') { ?> style="display:none;" <?php } ?> >
    <?php echo $form->field($model, 'ExternalVideoURL')->textInput(['maxlength' => true, 'placeholder' => 'External video  links goes here'])->error(false) ?>
    <div class="form-group">
      <?php
      echo Html::label('External Video Thumb <br/><code> ( Recommended image size : 1280 X 720 )</code>', 'external_link_thumb', ['class' => 'control-label']);
      ?> 

      <?php
      $pluginOptions = [
          'allowedFileExtensions' => ['jpg', 'png'],
          'showPreview' => true,
          'showRemove' => false,
          'showUpload' => false,
          'showCaption' => false,
      ];

      if (!empty(trim($model->ExternalVideoThumb))) {

        $pluginOptions['overwriteInitial'] = true;

        $pluginOptions['initialPreview'] = [
            "<img src='" . S3_THUMB_CLOUDFRONT . '/' . THUMBNAILS . '/' . $model->ExternalVideoThumb . "' class='file-preview-image' alt='" . $model->ExternalVideoThumb . "'  title='" . $model->ExternalVideoThumb . "'/>"];
      }
      echo FileInput::widget(
              [
                  'name' => 'external_link_thumb',
                  'options' => ['multiple' => false],
                  'pluginOptions' => $pluginOptions
              ]
      );
      ?>  &nbsp;&nbsp;
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
        $images = Images::find()->where(['imageType' => '4'])->orderBy('Created DESC')->All();
        foreach ($images as $image) {
          if ($image['ImageName']) {
            ?>
            <div class="thumb_block col-lg-3 col-sm-4 col-xs-6">
              <input type="radio" name="external_link_thumb_checkbox" class="live_thumb_checkbox " value="<?= $image['ImageID'] ?>" <?php
              echo
              $image['ImageName'] == $model->ExternalVideoThumb ? 'checked=checked' : ''
              ?>>
              <button type="button"   class="pull-right btn btn-danger removeButton" data-id="<?= $image['ImageID']; ?>" data-src="<?= $image['ImageName']; ?>" onclick="javascript:deleteLiveTvThumb(this);">X</button>    
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
      
      
  <div class="form-group">
      <?php
      echo Html::label('External Video Fire TV Thumb <br/><code> ( Recommended image size : 1280 X 720 )</code>', 'external_link_thumb_tv', ['class' => 'control-label']);
      ?> 

      <?php
      $pluginOptions = [
          'allowedFileExtensions' => ['jpg', 'png'],
          'showPreview' => true,
          'showRemove' => false,
          'showUpload' => false,
          'showCaption' => false,
      ];

      if (!empty(trim($model->ExternalVideoThumbFireTv))) {

        $pluginOptions['overwriteInitial'] = true;

        $pluginOptions['initialPreview'] = [
            "<img src='" . S3_THUMB_CLOUDFRONT . '/' . THUMBNAILS . '/' . $model->ExternalVideoThumbFireTv . "' class='file-preview-image' alt='" . $model->ExternalVideoThumbFireTv . "'  title='" . $model->ExternalVideoThumbFireTv . "'/>"];
      }
      echo FileInput::widget(
              [
                  'name' => 'external_link_thumb_tv',
                  'options' => ['multiple' => false],
                  'pluginOptions' => $pluginOptions
              ]
      );
      ?>  &nbsp;&nbsp;
   
    
     
    </div>
      
    <div class="form-group">
      <?php
      echo '<label class="control-label">Country Restrictions</label>';
      echo MultiSelect::widget([
          'id' => "video-countryrestrictions",
          "options" => ['multiple' => "multiple"],
          'data' => \backend\models\Country::getCountryList(),
          'name' => 'Homepage[CountryRestrictions]',
          'value' => $countryData,
          "clientOptions" =>
          [
              "includeSelectAllOption" => true,
              'enableFiltering' => true,
              'numberDisplayed' => 2,
              'enableCaseInsensitiveFiltering' => true,
          ],
      ]);
      ?>
    </div>
  </div>

  <?php echo $form->field($model, 'VideoID')->hiddenInput()->label(false)->error(false); ?>
  <?php echo $form->field($model, 'AccompanyingID')->hiddenInput()->label(false); ?>
  <?php echo $form->field($model, 'AdvertisementID')->hiddenInput()->label(false); ?>
  <?php echo $form->field($model, 'ScheduleVideoID')->hiddenInput()->label(false)->error(false); ?>
  <?php echo $form->field($model, 'ExternalVideoThumb')->hiddenInput()->label(false)->error(false); ?>
     <?php echo $form->field($model, 'ExternalVideoThumbFireTv')->hiddenInput()->label(false)->error(false); ?>

  <!--    <div class="form-group">
          <label class="control-label">Accompanying Videos</label>
  <?php // Html::button($content = 'Select Accompanying Videos',['onclick'=>'showAccompanyingVideos();']);    ?>
  <?php // Html::button($content = 'Reorder Accompanying Videos',['class'=>'reorderAccompanyingVideo','onclick'=>'reorderAccompanyingVideos();','disabled'=>(empty($model->AccompanyingID)) ? true : false]);       ?>
</div> -->

  <?php $IsShowAdvertisementVideo = ($model->NewsOrAdd != '2') ? "style='display:none;'" : "" ?>
  <?= $form->field($model, 'NewsOrAdd', ['template' => '{label}{input}<div class="show_advertisement_video extra-form-control" ' . $IsShowAdvertisementVideo . '>
  <br>  <a class="btn btn-success" href="javascript:showAdvertismentList();">Select Advertisement</a>
</div>{error}'])->dropDownList([1 => 'Breaking News', 2 => 'Advertisements',], ['onchange' => 'showAdvertismentList();'/* ,'prompt'=>'Select Breaking News/Advs' */]) ?>

  <?= $form->field($model, 'scroll_time')->dropDownList(SecondConvert(1, 11), ['prompt' => '--Select Time--']) ?>
  <div class="form-group">
    <?php
    echo '<label class="control-label">Category Videos</label>';
    echo MultiSelect::widget([
        'id' => "homepage-categoryid",
        "options" => ['multiple' => "multiple", 'class' => 'form-control'],
        'data' => backend\models\Category::getCategoryList('1'),
        'name' => 'Homepage[CategoryID]',
        'value' => $categoryData,
        "clientOptions" =>
        [
            "includeSelectAllOption" => false,
            'enableFiltering' => true,
            'numberDisplayed' => 2,
            'enableClickableOptGroups' => true,
            'enableCaseInsensitiveFiltering' => true,
        ],
    ]);
    ?>

    <div class="extra-form-control">
      Maximum of 4 Categories can be selected.
    </div>
    <?php echo Html::hiddenInput('arrayvideoin', '', ['class' => 'arrayvideoin']); ?>
  </div>
  <?php
  $schedulevideothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);

  if (!empty($recordedScheduleVideoImage['ImageName'])) {
    //$schedulevideothumbpage = '<img class="thumbnail img-responsive" src="' . ImagesUrl($recordedScheduleVideoImage) . '">';
    $schedulevideothumbpage = '<img class="thumbnail img-responsive" src="' . Main_VideoUrl(ImagesUrl($scheduleVideoInfo[0])) . '">';
  }
  ?>
  <?= $form->field($model, 'ScheduleVideoID', ['template' => '{label}<div class="show_recorded_schedule_video extra-form-control"><br><a class="btn btn-success" href="javascript:showScheduleVideoList();">Select Video</a><br>
</div><div class="show_recorded_schedule_video show_recorded__video_image extra-form-control">' . $schedulevideothumbpage . '</div>']); ?>

  <?php echo $form->field($model, 'googleAnalyticsEventsSeconds')->dropDownList(SecondConvert(1, 60), ['prompt' => '--Select Second--'])->label('Google Analytics Events Seconds For Live Tv'); ?>

  <?php echo $form->field($model, 'googleAnalyticsEventsSecondsLiveTvEmbed')->dropDownList(SecondConvert(1, 60), ['prompt' => '--Select Second--'])->label('Google Analytics Events Seconds For Live Tv Embed'); ?>
  <?php echo $form->field($model, 'googleAnalyticsEventsSecondsVideo')->dropDownList(SecondConvert(1, 60), ['prompt' => '--Select Second--'])->label('Google Analytics Events Seconds For Video'); ?>
  <?php echo $form->field($model, 'googleAnalyticsEventsSecondsVideoEmbed')->dropDownList(SecondConvert(1, 60), ['prompt' => '--Select Second--'])->label('Google Analytics Events Seconds For Video Embed'); ?>

  <fieldset>
    <hr/>
    <?= $form->field($model, 'homePageTitle')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'homePageMetaKeyword')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'homePageMetaDescription')->textarea(['rows' => 2, 'cols' => 5]); ?>
    <?= $form->field($model, 'homePageMetaRobots')->textInput(); ?>
    <hr/>
    <?= $form->field($model, 'schedulePageTitle')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'schedulePageMetaKeyword')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'schedulePageMetaDescription')->textarea(['rows' => 2, 'cols' => 5]); ?>
    <?= $form->field($model, 'schedulePageMetaRobots')->textInput(); ?>
    <hr/>
    <?= $form->field($model, 'actionPageTitle')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'actionPageMetaKeyword')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'actionPageMetaDescription')->textarea(['rows' => 2, 'cols' => 5]); ?>
    <?= $form->field($model, 'actionPageMetaRobots')->textInput(); ?>
    <hr/>
    <?= $form->field($model, 'throwbackPageTitle')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'throwbackPageMetaKeyword')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'throwbackPageMetaDescription')->textarea(['rows' => 2, 'cols' => 5]); ?>
    <?= $form->field($model, 'throwbackPageMetaRobots')->textInput(); ?>
    <hr/>
    <?= $form->field($model, 'talkingTurkeyTitle')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'talkingTurkeyMetaKeyword')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'talkingTurkeyMetaDescription')->textarea(['rows' => 2, 'cols' => 5]); ?>
    <?= $form->field($model, 'talkingTurkeyMetaRobots')->textInput(); ?> 
  </fieldset>
  <div class="form-group"><br><?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?></div>
  <?php ActiveForm::end(); ?>
</div>


<?php
/* * ************************************ For Main Video ********************************* */
$content = '';
$addvideobutton = '';
if (!empty($videooutlist)) {
  foreach ($videooutlist as $videolistsub) {
    $videothumb = $videolistsub['ImageName'];
    if ($videothumb != '') {
      $videothumbpage = '<img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub) . '">';
    } else {
      $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
    }
    $content .= '<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="radio" name="videothumb" class="videothumbchkbox" value="' . $videolistsub['ID'] . '">' . $videothumbpage . '<p>' . $videolistsub['Title'] . '</p></div>';
    array_push($selectedvideotitle, $videolistsub['Title']);
  }
  $addvideobutton = Html::label('Add Selected Video', '', ['class' => 'addvideolist btn btn-primary', 'style' => 'cursor:pointer']);
} else {
  $content = 'No Records Found';
}

/* * ************************************ For Schedule Video ********************************* */
$contentForSchedule = '';
$addScheduleVideoButton = '';
if (!empty($videooutlist)) {
  foreach ($videooutlist as $videolistsub) {
    $videothumb = $videolistsub['ImageName'];
    if ($videothumb != '') {
      $schedulevideothumbpage = '<img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub) . '">';
    } else {
      $schedulevideothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
    }
    $contentForSchedule .= '<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="radio" name="schedulevideothumb" class="videothumbchkbox" value="' . $videolistsub['ID'] . '">' . $schedulevideothumbpage . '<p>' . $videolistsub['Title'] . '</p></div>';
    array_push($selectedschedulevideotitle, $videolistsub['Title']);
  }
  $addScheduleVideoButton = Html::label('Add Selected Video', '', ['class' => 'addschedulevideolist btn btn-primary', 'style' => 'cursor:pointer']);
} else {
  $contentForSchedule = 'No Records Found';
}

/* * ************************************** For Accompanying Videos **************************** */
$contentForAccompanying = '';
$addvideobuttonForAccompanying = '';
if (!empty($videooutlist)) {
  foreach ($videooutlist as $videolistsub) {
    $videothumb = $videolistsub['ImageName'];
    if ($videothumb != '') {
      $videothumbpage = '<img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub) . '">';
    } else {
      $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
    }
    $contentForAccompanying .= '<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videoaccompanying" class="videothumbchkbox" value="' . $videolistsub['ID'] . '">' . $videothumbpage . '<p>' . $videolistsub['Title'] . '</p></div>';
    array_push($selectedAccompnyVideoTitle, $videolistsub['Title']);
  }
  $addvideobuttonForAccompanying = Html::label('Add Accompanying Videos', '', ['class' => 'addAccompnyvideolist btn btn-primary', 'style' => 'cursor:pointer']);
} else {
  $contentForAccompanying = 'No Records Found';
}


/* * ************************************** For Advertisements **************************** */
$contentForAdvertisements = '';
$addvideobuttonForAdvertisements = '';
if (!empty($advertisementData)) {
  foreach ($advertisementData as $videolistsub) {
    $videothumb = $videolistsub['ImagePath'];
    if ($videothumb != '') {
      $videothumbpage = '<img class="thumbnail img-responsive" src="' . S3_THUMB_CLOUDFRONT . '/' . ADVERISEMENT . '/' . $videothumb . '">';
    } else {
      $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
    }
    $contentForAdvertisements .= '<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videoadvertisement" class="advertisementVideo" value="' . $videolistsub['ID'] . '">' . $videothumbpage . '<p>' . $videolistsub['Content'] . '</p></div>';
    array_push($selectedAdvertisementVideoTitle, $videolistsub['Content']);
  }
  $addvideobuttonForAdvertisements = Html::label('Add Advertisements', '', ['class' => 'addadvertisementsvideolist btn btn-primary', 'style' => 'cursor:pointer']);
} else {
  $contentForAdvertisements = 'No Records Found';
}
?>

<!-- For Main Video -->

<div class="modal fade bs-example-modal-lg filterPopupModel" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="panel panel-default">

        <input type="hidden" id="recording_video_hidden" value="" >
        <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;">Videos </h4>
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
            <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick="$('#main_video_input').val(''); filterPopup($('#main_video_input')); return false;">
              <span class="close_icon glyphicon glyphicon-remove"></span>
            </a>
          </div>
        </div>
        <div class="panel-body">
          <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
          <div class="displaycontetn"><?php echo $content; ?></div>
        </div>
        <div class="panel-footer"><?php echo $addvideobutton; ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div id="spinnerLoaderForPopup"  class="spinner_div" style="display:none;">
    <?php
    echo Spinner::widget([
        'preset' => Spinner::LARGE,
        'color' => 'blue',
        'align' => 'center'
    ]);
    ?>
  </div>
</div>

<!-- For Accompanying Video -->

<div class="modal fade bs-example-modal-lg filterPopupModel" id="myModalAccompanying" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="panel panel-default">
        <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Accompanying Videos </h4>
          <div class="pull-right">
            <?php
            echo Typeahead::widget([
                'name' => 'videolist',
                'options' => ['placeholder' => 'Enter Video Title ...',
                    'class' => 'videoname filterInput',
                    'style' => 'width:400px;background-color:none;',
                    'id' => 'accompnying_input',
                ],
                'pluginOptions' => ['highlight' => true],
                'pluginEvents' => [
//                                                    "typeahead:selected" => "function(obj, item) { selectVideoForAccompanying(item); return false;}",
                    "typeahead:selected" => "function(obj, item) { filterPopup($('#accompnying_input'));return false; }",
                ],
                'dataset' => [
                    [
                        'local' => $selectedAccompnyVideoTitle,
                        'limit' => 10
                    ]
                ]
            ]);
            ?>
            <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick="$('#accompnying_input').val(''); filterPopup($('#accompnying_input')); return false;">
              <span class="close_icon glyphicon glyphicon-remove"></span>
            </a>
          </div>
        </div>
        <div class="panel-body">
          <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
          <div class="displaycontetnForAccompanying"><?php echo $contentForAccompanying; ?></div>
        </div>
        <div class="panel-footer"><?php echo $addvideobuttonForAccompanying; ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div id="spinnerLoaderForAccompnyPopup" class="spinner_div" style="display:none;">
    <?php
    echo Spinner::widget([
        'preset' => Spinner::LARGE,
        'color' => 'blue',
        'align' => 'center'
    ]);
    ?>
  </div>
</div>

<!-- For Advertisements Video -->

<div class="modal fade bs-example-modal-lg filterPopupModel" id="myModalAdvertisements" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="panel panel-default">
        <input type="hidden" id="advertisement_video_hidden" value="">
        <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Advertisements </h4>
          <div class="pull-right">
            <?php
            echo Typeahead::widget([
                'name' => 'videolist',
                'options' => ['placeholder' => 'Enter Title ...',
                    'class' => 'videoname filterInput',
                    'style' => 'width:400px;background-color:none;',
                    'id' => 'advertisement_input',
                ],
                'pluginOptions' => ['highlight' => true],
                'pluginEvents' => [
                    // "typeahead:selected" => "function(obj, item) { $('#advertisement_input').val(item);selectVideoForAdvertisement(item); return false;}",
                    "typeahead:selected" => "function(obj, item) { filterPopup($('#advertisement_input'));return false; }",
                ],
                'dataset' => [
                    [
                        'local' => $selectedAdvertisementVideoTitle,
                        'limit' => 10
                    ]
                ]
            ]);
            ?>
            <a title="Clear text"  class="clear_text"href="javascript:void(0);" onclick="$('#advertisement_input').val(''); filterPopup($('#advertisement_input')); return false;">
              <span class="close_icon glyphicon glyphicon-remove"></span>
            </a>
          </div>
        </div>
        <div class="panel-body">
          <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
          <div class="displaycontetnForAdvertisement"><?php echo $contentForAdvertisements; ?></div>
        </div>
        <div class="panel-footer"><?php echo $addvideobuttonForAdvertisements; ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div id="spinnerLoaderForAdvertisementPopup" class="spinner_div" style="display:none;">
    <?php
    echo Spinner::widget([
        'preset' => Spinner::LARGE,
        'color' => 'blue',
        'align' => 'center'
    ]);
    ?>
  </div>
</div>

<!-- For Schedule Video -->

<div class="modal fade bs-example-modal-lg filterPopupModel" id="myModalSchedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="panel panel-default">

        <input type="hidden" id="schedule_video_hidden" value="" >
        <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Videos </h4>
          <div class="pull-right">
            <?php
            echo Typeahead::widget([
                'name' => 'videolist',
                'options' => [
                    'placeholder' => 'Enter Video Title ...',
                    'class' => 'videoname filterInput',
                    'style' => 'width:400px;background-color:none;',
                    'id' => 'schedule_video_input',
                ],
                //'pluginOptions' => ['highlight' => true],
                'pluginOptions' => ['highlight' => true, 'minLength' => 0],
                //'pluginEvents' => ["typeahead:selected" => "function(obj, item) { selectVideo(item); return false;}"],
                'pluginEvents' => [
                    "typeahead:selected" => "function(obj, item) { filterPopup($('#schedule_video_input'));return false; }",
                ],
                'dataset' => [
                    [
                        'local' => $selectedschedulevideotitle,
                        'limit' => 10
                    ]
                ]
            ]);
            ?>
            <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick="$('#schedule_video_input').val(''); filterPopup($('#schedule_video_input')); return false;">
              <span class="close_icon glyphicon glyphicon-remove"></span>
            </a>
          </div>
        </div>
        <div class="panel-body">
          <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
          <div class="displaycontetn"><?php echo $contentForSchedule; ?></div>
        </div>
        <div class="panel-footer"><?php echo $addScheduleVideoButton; ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div id="spinnerLoaderForPopup"  class="spinner_div" style="display:none;">
    <?php
    echo Spinner::widget([
        'preset' => Spinner::LARGE,
        'color' => 'blue',
        'align' => 'center'
    ]);
    ?>
  </div>
</div>


<div class="modal fade bs-example-modal-lg" id="reorderModalAccompanying" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
    form = $('#update-homepage');
    var fileChooser = $('[name="external_link_thumb"]');
    if (fileChooser[0].files.length > 0) {
      [].forEach.call(fileChooser[0].files, function (file) {
        var filename = 'livetv_' + (new Date).getTime() + '.' + file['name'].split('.').pop();
        var bucket = new AWS.S3({params: {Bucket: '<?php echo S3BUCKET; ?>'}});
        var params = {Key: '<?php echo THUMBNAILS ?>/' + filename, ContentType: file.type, Body: file};

        $(".kv-upload-progress").removeClass('hide');
        bucket.upload(params).on('httpUploadProgress', function (evt) {
          var percentage = parseInt((evt.loaded * 100) / evt.total);
          $(".kv-upload-progress").find('.progress-bar')
                  .css("width", percentage + "%")
                  .attr("aria-valuenow", percentage)
                  .text(percentage + "%");
        }).send(function (err, data) {
          $.ajax({
            type: 'POST',
            url: '<?php echo Url::to('save-file') ?>',
            data: {filename: filename},
            dataType: 'json',
            async: false,
            success: function (response) {
              console.log(response);
              $('[name="Homepage[ExternalVideoThumb]"]').val(filename);
              $('#update-homepage').submit();
            }
          });
        });
      });
    } else {
      console.log(form);
      $('#update-homepage').submit();
    }
    
    
     var fileChoosertv = $('[name="external_link_thumb_tv"]');
    if (fileChoosertv[0].files.length > 0) {
      [].forEach.call(fileChoosertv[0].files, function (file) {
        var filename = 'livefiretv_' + (new Date).getTime() + '.' + file['name'].split('.').pop();
        var bucket = new AWS.S3({params: {Bucket: '<?php echo S3BUCKET; ?>'}});
        var params = {Key: '<?php echo THUMBNAILS ?>/' + filename, ContentType: file.type, Body: file};

        $(".kv-upload-progress").removeClass('hide');
        bucket.upload(params).on('httpUploadProgress', function (evt) {
          var percentage = parseInt((evt.loaded * 100) / evt.total);
          $(".kv-upload-progress").find('.progress-bar')
                  .css("width", percentage + "%")
                  .attr("aria-valuenow", percentage)
                  .text(percentage + "%");
        }).send(function (err, data) {
          $.ajax({
            type: 'POST',
            url: '<?php echo Url::to('save-file') ?>',
            data: {filename: filename},
            dataType: 'json',
            async: false,
            success: function (response) {
              console.log(response);
              $('[name="Homepage[ExternalVideoThumbFireTv]"]').val(filename);
              $('#update-homepage').submit();
            }
          });
        });
      });
    } else {
      console.log(form);
      $('#update-homepage').submit();
    }
    
  }

  function deleteLiveTvThumb(ele) {
    _ele = $(ele);
    src = _ele.data("src");
    $.ajax({
      type: 'POST',
      url: '<?php echo Url::to('delete-livetv-thumb') ?>',
      data: {filename: src, ImageID: _ele.data("id")},
      dataType: 'json',
      async: false,
      success: function (response) {
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
      $('[name="Homepage[ExternalVideoThumb]"]').val(alt);
    }
    $('#livetv-thumb-library').modal('hide');
  }
  function showAccompanyingVideos() {
    //if($("#showAccompanying").is(':checked')) {
    if ($('#accompnying_input').val() != '') {
      $('#accompnying_input').val('');
      filterPopup($('#accompnying_input'));
    }
    setCheckedValue($("#myModalAccompanying input[name='videoaccompanying']"), $("#homepage-accompanyingid").val());
    $("#myModalAccompanying").modal('show');
    /*} else {
     $("#myModalAccompanying").modal('hide');
     }*/
  }
  function showVideoList()
  {
    var videoType = $("#homepage-mainvideotype").val();
    if (videoType == '1') {
      $(".show_recorded_video").show();
      if ($('#main_video_input').val() != '') {
        $('#main_video_input').val('');
        filterPopup($('#main_video_input'));
      }

      $('#myModal').modal('show');
      setCheckedValue($("#myModal input[name='videothumb']"), $("#homepage-videoid").val());
      //$("#myModal input[name='videothumb'][value='"+$("#homepage-videoid").val()+"']").prop("checked",true);
      $("#externalVideoURL").hide();
    } else if (videoType == '2') {
      $(".show_recorded_video").hide();
      $("#externalVideoURL").show();
      $('#myModal').modal('hide');
    }
  }
  function showScheduleVideoList()
  {
    $(".show_recorded_schedule_video").show();
    if ($('#schedule_video_input').val() != '') {
      $('#schedule_video_input').val('');
      filterPopup($('#schedule_video_input'));
    }
    $('#myModalSchedule').modal('show');
    setCheckedValue($("#myModalSchedule input[name='schedulevideothumb']"), $("#homepage-schedulevideoid").val());
  }
  function showAdvertismentList() {
    if ($("#homepage-newsoradd").val() == 2) {
      $(".show_advertisement_video").show();
      if ($('#advertisement_input').val() != '') {
        $('#advertisement_input').val('');
        filterPopup($('#advertisement_input'));
      }
      setCheckedValue($("#myModalAdvertisements input[name='videoadvertisement']"), $("#homepage-advertisementid").val());
      $("#myModalAdvertisements").modal('show');
    } else {
      $(".show_advertisement_video").hide();
      $("#myModalAdvertisements").modal('hide');
    }
  }
  function selectVideo(item) {
    $("#spinnerLoaderForPopup").show();
    var categid = '';
    var videotitle = item;
    $.ajax({
      type: 'POST',
      data: {videotitle: videotitle, categid: categid},
      url: '<?php echo Url::toRoute('playlist/videosearch'); ?>',
      success: function (msg) {
        $('.displaycontetn').html(msg);
        $("#spinnerLoaderForPopup").hide();
      }
    });
  }
  function selectVideoForAccompanying(item) {
    $("#spinnerLoaderForAccompnyPopup").show();
    var categid = '';
    var videotitle = item;
    $.ajax({
      type: 'POST',
      data: {videotitle: videotitle, categid: categid},
      url: '<?php echo Url::toRoute('playlist/videosearchforaccompanying'); ?>',
      success: function (msg) {
        $('.displaycontetnForAccompanying').html(msg);
        $("#spinnerLoaderForAccompnyPopup").hide();
      }
    });
  }
  function selectVideoForAdvertisement(item) {
    $("#spinnerLoaderForAdvertisementPopup").show();
    var categid = '';
    var content = item;
    $.ajax({
      type: 'POST',
      data: {content: content, categid: categid},
      url: '<?php echo Url::toRoute('playlist/videosearchforadvertisement'); ?>',
      success: function (msg) {
        $('.displaycontetnForAdvertisement').html(msg);
        $("#spinnerLoaderForAdvertisementPopup").hide();
      }
    });
  }

</script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<?php
$this->registerJsFile('@web/js/jquery.tagsinput.js', ['depends' => [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
]]);
$this->registerJs("
 $('#homepage-homepagemetakeyword,#homepage-schedulepagemetakeyword,#homepage-actionpagemetakeyword,#homepage-talkingturkeymetakeyword,#homepage-throwbackpagemetakeyword').tagsInput({
   'class':'form-controll',
   'interactive':true,
   'defaultText':'add a tag',
   /*'onAddTag':callback_function,
   'onRemoveTag':callback_function,
   'onChange' : callback_function,*/
         //'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
   'removeWithBackspace' : true,
});
");
$this->registerCss("
#homepage-homepagemetakeyword_tag ,
#homepage-schedulepagemetakeyword_tag,
#homepage-actionpagemetakeyword_tag ,
#homepage-throwbackpagemetakeyword_tag ,
#homepage-talkingturkeymetakeyword_tag  {
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 12px;
    width: 100% !important;
} 
hr{    border: 0.5px solid #ddd;}
div#homepage-homepagemetakeyword_tagsinput ,
div#homepage-schedulepagemetakeyword_tagsinput,
div#homepage-actionpagemetakeyword_tagsinput ,
div#homepage-throwbackpagemetakeyword_tagsinput ,
div#homepage-talkingturkeymetakeyword_tagsinput{
    width: 25% !important;
    float: left;
    background: #fff;
    padding: 10px 10px;
    border: 1px solid #ccc;
}
.twoColumnForm .form-group .control-label {
    width: 30% !important;
}
.twoColumnForm .form-group .extra-form-control {
    width: 30% !important;
}
img.thumbnail.img-responsive {
margin-left: 55% !important;
}
#externalVideoURL .file-input .btn-primary {
margin-left: 290px;
}
");
?>
