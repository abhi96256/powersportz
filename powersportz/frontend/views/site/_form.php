<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;
use dosamigos\multiselect\MultiSelect;

//require_once( dirname(__FILE__) . '/../components/twitteroauth.php');

/* @var $this yii\web\View */
/* @var $model backend\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1.24.min.js"></script>

<?php

/*$.oauthpopup({
            path: 'http://52.74.119.196/sharetwitter/share/connect.php',
            callback: function(){
                var session_twitter = '<?= (!empty($_SESSION["twitter"])) ? 'Yes' : 'No'; ?>';
                console.log(session_twitter);
            }
        });*/
$this->registerJs("
   function twitterOauthPopup(){

    }
    $('#video-metakeywords').tagsInput({
         'class':'form-controll',
         'interactive':true,
         'defaultText':'add a tag',
         /*'onAddTag':callback_function,
         'onRemoveTag':callback_function,
         'onChange' : callback_function,*/
         //'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
         'removeWithBackspace' : true,
      });
     ",yii\web\View::POS_END,'playlist-form');
?>
<script type="text/javascript">
    var  clientId = '<?= GooglePlusClientID;?>'; //Google Plus clientId
     var apiKey = '<?= GooglePlusApiKey; ?>'; //Google Plus api key
    var scopes = '<?= GooglePlusScope; ?>'; // Google plus

    var website_url = '<?= Yii::$app->urlmanager->createUrl(""); ?>';
    AWS.config.update({
        accessKeyId : '<?php echo AWSACCESSKEY; ?>',
        secretAccessKey : '<?php echo AWSSECRETKEY; ?>',
        region: '<?php echo AWSREGION; ?>',
        signatureVersion: 'v4'
    });
</script>
 <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<link href="https://vjs.zencdn.net/8.6.0/video-js.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/videojs-ima@2.2.0/dist/videojs.ima.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/8.6.0/video.min.js"></script>
<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-ads@7.3.2/dist/videojs.contrib.ads.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-ima@2.2.0/dist/videojs.ima.min.js"></script>
<?php 
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.tagsinput.js', ['depends' => [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ]]);
 $this->registerJsFile(Yii::$app->request->baseUrl.'/js/common.js',['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/video.js', ['depends' => [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ]]); 

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.oauthpopup.js', ['depends' => [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ]]);

    ?>

<div class="video-form">
    <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data','id'=>'video-post-form',
                ]
            ]); ?>
    <?php echo $form->errorSummary($model); 
   $request = [
                    //     "league"=>$listData,
                    "field_name" => ['Title','Description'],
                    "from_table_name" => 'video',
                    "from_table_id" => $model->ID,
                ];
    $languageFields = \backend\models\Langauge::getLanguageFields($request);

                    if(!empty($languageFields)){ ?>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#english">English</a></li>
                            <?php foreach ($languageFields as $key => $value) { ?>
                               <li><a data-toggle="tab" href="#<?= $key;?>"><?= $key; ?></a></li>
                            <?php }?>
                        </ul>
                    <?php } ?>
    <div id="share-button"></div>
    <?php 
      if (!empty($_GET['svid'])) {
            echo '<label class="control-label">Video</label>';
            echo $form->field($model,'VideoURL')->hiddenInput()->label(false);;
         //   echo $model->VideoURL;
            echo '<video id="containerForShortVideo" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="640" height="360" playsinline></video>';
            $this->registerJs('
                    var vmapXML = \'<vmap:VMAP xmlns:vmap="http://www.iab.net/videosuite/vmap" version="1.0">\' +
                        \'<vmap:AdBreak timeOffset="start" breakType="linear" breakId="pre">\' +
                            \'<vmap:AdSource id="pre-ad" allowMultipleAds="false" followRedirects="true">\' +
                                \'<vmap:AdTagURI templateType="vast3"><![CDATA[\' + "' . $model->PreAdvertisementTagURL . '" + \']]></vmap:AdTagURI>\' +
                            \'</vmap:AdSource>\' +
                        \'</vmap:AdBreak>\' +
                        \'<vmap:AdBreak timeOffset="\' + "' . $model->StartMidAdvertisementTime . '" + \'" breakType="linear" breakId="mid">\' +
                            \'<vmap:AdSource id="mid-ad" allowMultipleAds="false" followRedirects="true">\' +
                                \'<vmap:AdTagURI templateType="vast3"><![CDATA[\' + "' . $model->MidAdvertisementTagURL . '" + \']]></vmap:AdTagURI>\' +
                            \'</vmap:AdSource>\' +
                        \'</vmap:AdBreak>\' +
                        \'<vmap:AdBreak timeOffset="end" breakType="linear" breakId="post">\' +
                            \'<vmap:AdSource id="post-ad" allowMultipleAds="false" followRedirects="true">\' +
                                \'<vmap:AdTagURI templateType="vast3"><![CDATA[\' + "' . $model->PostAdvertisementTagURL . '" + \']]></vmap:AdTagURI>\' +
                            \'</vmap:AdSource>\' +
                        \'</vmap:AdBreak>\' +
                    \'</vmap:VMAP>\';

                    var playerInstance = videojs("containerForShortVideo", {
                        controls: true,
                        autoplay: false,
                        preload: "auto",
                        width: 640,
                        height: 360,
                        sources: [{
                            src: "' . $model->VideoURL . '",
                            type: "video/mp4"
                        }]
                    });

                    var imaOptions = {
                        id: "containerForShortVideo",
                        adsResponse: vmapXML
                    };
                    playerInstance.ima(imaOptions);
                    ');
      }else{ 
            echo '<label class="control-label">Video <code>( Recommended video frame size : 1920 X 1080 ) </code></label>';
                echo FileInput::widget([
                    'model' => $model,
                    'attribute' => 'VideoURL',
                    'options' => ['multiple' => false],
                    'pluginOptions' => [
                        'allowedFileExtensions'=>['mp4'],
                        'showPreview' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'minFileCount' => $model->isNewRecord ? 1 : 0
                    ],
            ]);
            if(isset($model->VideoStreamURL) && $model->VideoStreamURL!='') {  ?>
            <video id="containerForShortVideo" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="640" height="360" playsinline></video>
            <?php 
                    $this->registerJs('
                    var vmapXML = \'<vmap:VMAP xmlns:vmap="http://www.iab.net/videosuite/vmap" version="1.0">\' +
                        \'<vmap:AdBreak timeOffset="start" breakType="linear" breakId="pre">\' +
                            \'<vmap:AdSource id="pre-ad" allowMultipleAds="false" followRedirects="true">\' +
                                \'<vmap:AdTagURI templateType="vast3"><![CDATA[\' + "' . $model->PreAdvertisementTagURL . '" + \']]></vmap:AdTagURI>\' +
                            \'</vmap:AdSource>\' +
                        \'</vmap:AdBreak>\' +
                        \'<vmap:AdBreak timeOffset="\' + "' . $model->StartMidAdvertisementTime . '" + \'" breakType="linear" breakId="mid">\' +
                            \'<vmap:AdSource id="mid-ad" allowMultipleAds="false" followRedirects="true">\' +
                                \'<vmap:AdTagURI templateType="vast3"><![CDATA[\' + "' . $model->MidAdvertisementTagURL . '" + \']]></vmap:AdTagURI>\' +
                            \'</vmap:AdSource>\' +
                        \'</vmap:AdBreak>\' +
                        \'<vmap:AdBreak timeOffset="end" breakType="linear" breakId="post">\' +
                            \'<vmap:AdSource id="post-ad" allowMultipleAds="false" followRedirects="true">\' +
                                \'<vmap:AdTagURI templateType="vast3"><![CDATA[\' + "' . $model->PostAdvertisementTagURL . '" + \']]></vmap:AdTagURI>\' +
                            \'</vmap:AdSource>\' +
                        \'</vmap:AdBreak>\' +
                    \'</vmap:VMAP>\';

                    var playerInstance = videojs("containerForShortVideo", {
                        controls: true,
                        autoplay: false,
                        preload: "auto",
                        width: 640,
                        height: 360,
                        poster: "' . ImagesUrl($images[0]) . '",
                        sources: [{
                            src: "' . S3_VIDEO_BUCKETABSOLUTE_PATH.$model->VideoStreamURL . '",
                            type: "video/mp4"
                        }]
                    });

                    var imaOptions = {
                        id: "containerForShortVideo",
                        adsResponse: vmapXML
                    };
                    playerInstance.ima(imaOptions);
                    ');
                    //'.$model->AdvertisementTagRL.'
                }    
            ?>
            
            <div class="progress" id="progressForShortVideo" style="display: none;">
                <div class="progress-bar progress-bar-striped active" id="progress-barForShortVideo" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                progress    
                </div>
            </div>
      <?php } ?>
     <div class="form-group">
     </div>
     <?php 
     if(!$model->isNewRecord && $model->VideoStreamURL == ''){ ?>
     <div>Transcoding is in progress. Once transcoding is completed, you can select thumbnail images.</div>       
     <?php } ?>       
     <?php if(!$model->isNewRecord && $model->VideoStreamURL!=''){ ?>
        <div class="form-group">
            <label>Video URL</label>
            <label><a target="_blanck" href="<?= S3_VIDEO_BUCKETABSOLUTE_PATH.$model->VideoStreamURL; ?>"><?= S3_VIDEO_BUCKETABSOLUTE_PATH.$model->VideoStreamURL; ?></a></label>
            <!-- <button class="relatedVideosPopup">+</button> -->
        </div>

        <?php echo $form->field($model,'IsDefaultthumbnailVideoId')->hiddenInput()->label(false); ?>
         <div class="col-md-6 form-group">
            <label>Select Default Thumbnail</label>
            <?= Html::button($content = '+',['class'=>'defaultthumbnailVideoPopup']);?>
            <span class="count_default_thumbnail_images"><?= ($model->IsDefaultthumbnailVideoId) ? count(explode(",", $model->IsDefaultthumbnailVideoId)).'  generated thumbnail selected.' : '0 generated thumbnail selected.'?></span>
        </div>
        <?= $this->render('default_video_thumbnail_images',compact('DefaultGeneratedImages')); ?>
    <?php } ?>
     <div class="col-md-6 form-group">
          <label>Select Video Thumbnail</label>
        <?= Html::button($content = '+',['class'=>'thumbnailVideoPopup']);?>
        <span class="count_thumbnail_images"><?= ($model->IsthumbnailVideoId) ? count(explode(",", $model->IsthumbnailVideoId)).'  thumbnail selected.' : '0 thumbnail selected.'?></span>
        <!-- <button class="relatedVideosPopup">+</button> -->
     </div>
    <?php // $form->field($model, 'VideoStreamURL')->textInput(['maxlength' => true,'value'=>S3_VIDEO_BUCKETABSOLUTE_PATH.$model->FullVideoStreamURL,'readonly'=>'readonly']); ?>
    <?php echo $form->field($model,'IsthumbnailVideoId')->hiddenInput()->label(false); ?>
    <div class="col-md-6 form-group">
           <?= $form->field($model, 'GeneratedThumbnailTime')->dropDownList(backend\models\Video::generatedThumbnailTime(),['prompt'=>'--Select Time--']) ?>
    </div>
     <div class="col-md-6 form-group">
             <?= $form->field($model, 'ChangeThumbnailTime')->dropDownList(backend\models\Video::changeThumbnailTime(),['prompt'=>'--Select Time--']) ?>
     </div>
    <?= $this->render('video_thumbnail_images',compact('VideoThumbImageList')); ?>
    <?php //echo  $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>
    <?php //echo  $form->field($model, 'Description')->textarea(['rows' => 6]) ?>
    
<?php  if(!empty($languageFields)){ ?>
        <div class="tab-content">
                 <div id="english" class="tab-pane fade in active">
                    <?php 
                     echo $form->field($model, 'Title')->textInput(['maxlength' => true]);
                      echo  $form->field($model, 'Description')->textarea(['rows' => 6]);?> 
                 </div>
                 <?php 
                    foreach ($languageFields as $key => $value) { ?>
                    <?php //print_r( $value);die; ?>
                    <?= yii\helpers\Html::hiddenInput('languageFields[lang_id]',$value['lang_id']) ?>
                    <?= yii\helpers\Html::hiddenInput('languageFields[from_table_name]', $request['from_table_name']) ?>
                    <?= yii\helpers\Html::hiddenInput('languageFields[from_table_id]', $model->ID) ?>
                    <div id="<?= $key;?>" class="tab-pane fade">
                       
                        <div class="form-group field-video-title required">
                            <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][0][id]', $value['fields']['Title']['id']) ?>
                            <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][0][field_name]', "Title") ?>
                              <label class="control-label" for="video-title">Title</label>
                            <?= yii\helpers\Html::input('text','languageFields[LanguageFieldsArr][0][value]', $value['fields']['Title']['value'],["class"=>"form-control"])?>
                            <div class="help-block"></div>
                        </div>
                      
                      
                        <div class="form-group field-video-description required">
                             <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][1][id]', $value['fields']['Description']['id']) ?>
                            <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][1][field_name]', "Description") ?>
                              <label class="control-label" for="video-title">Description</label>
                              <?= yii\helpers\Html::textarea('languageFields[LanguageFieldsArr][1][value]', $value['fields']['Description']['value'],["class"=>"form-control","rows" => 5])?>
                            <div class="help-block"></div>
                        </div>
                        
                   </div>
                <?php  }?>
            </div>
   <?php }
    else
    {
       echo  $form->field($model, 'Description')->textarea(['rows' => 6]);  
       echo $form->field($model, 'Title')->textInput(['maxlength' => true]); 

    } ?>
    
    <?= $form->field($model, 'MetaKeywords')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'PreAdvertisementTagURL')->textInput(['maxlength' => true, 'placeholder' => 'URL Video Extension Should be MP4 only']) ?>
    <?= $form->field($model, 'MidAdvertisementTagURL')->textInput(['maxlength' => true, 'placeholder' => 'URL Video Extension Should be MP4 only']) ?>
    <?= $form->field($model, 'StartMidAdvertisementTime')->dropDownList(backend\models\Video::midAdvertisementTime(),['prompt'=>'--Select Time--']) ?>
    <?= $form->field($model, 'PostAdvertisementTagURL')->textInput(['maxlength' => true, 'placeholder' => 'URL Video Extension Should be MP4 only']) ?>
      <div class="col-md-6 form-group">
        <?= $form->field($model, 'is_skip_adv')->checkbox(array('1'=>'IsSkip'))->label(false); ?>
        <div <?php if($model->is_skip_adv =='') { ?> style="display:none;" <?php } ?> id="showSkipTime" >
            <?= $form->field($model, 'skip_adv_time')->dropDownList(\backend\models\Customadvertisement::changeThumbnailTime()) //['prompt'=>'--Select Time--'] ?>
        </div>
      </div>
    <?php //echo $form->field($model, 'DisplayIndex')->textInput(['maxlength' => true]) ?>
    <div class="col-md-6 form-group">
     <?php 
            echo $form->field($model, 'PublishDate')->widget(DateTimePicker::classname(), [
                       'options' => ['placeholder' => 'Select Publish Date ...','readonly'=>'readonly'],
                        'convertFormat' => true,
                        'value' => $model->PublishDate,
                        'pluginOptions' => [
                            'format' => 'yyyy-M-dd h:i P',
                            //'startDate' => '01-Mar-2014 12:00 AM',
                            'todayHighlight' => true,
                            'autoclose' => true,
                        ]
                ]);
           /* echo DateTimePicker::widget([
                'name' => 'Video[PublishDate]',
                'attribute'=>'PublishDate',
                'options' => ['placeholder' => 'Select Publish Date ...','readonly'=>'readonly'],
                'convertFormat' => true,
                'value' => $model->PublishDate,
                'pluginOptions' => [
                    'format' => 'yyyy-M-dd h:i:s P',
                    //'startDate' => '01-Mar-2014 12:00 AM',
                    'todayHighlight' => true,
                    'autoclose' => true,
                ]
            ]);*/
            ?></div>
    <?php echo $form->field($model,'IsRelatedVideoId')->hiddenInput()->label(false); ?>
    <?php echo $form->field($model,'ID')->hiddenInput()->label(false); ?>
    
    <div class="col-md-6 form-group">
        <label>Related Video</label>
        <?= Html::button($content = '+',['class'=>'relatedVideosPopup']);?>
        <span class="count_related_video"><?= ($model->IsRelatedVideoId) ? count(explode(",", $model->IsRelatedVideoId)).'  video selected.' : '0 video selected.'?></span>
        <!-- <button class="relatedVideosPopup">+</button> -->
        <?= $this->render('related_videos',compact('videosList')); ?>
    </div>
    <?php echo $form->field($model,'FullVideoId')->hiddenInput()->label(false); ?>
    <div class="col-md-6 form-group">
        <label>Select Full Video</label>
        <?= Html::button($content = ' + ',['class'=>'full_video_popup']);?>
        <span class="full_video_name"><?= (!empty($model->fullVideo->Title)) ? '<b>'.$model->fullVideo->Title.'</b> Video selected.' : 'No Full Video selected.'?> </span>
        <!-- <button class="relatedVideosPopup">+</button> -->
        <?= $this->render('full_videos',compact('videosList')); ?>
    </div>
    <?php /*echo '<label class="control-label">Full Video</label>';
        echo FileInput::widget([
            'model' => $model,
            'attribute' => 'FullVideoURL',
            'options' => ['multiple' => false],
            'pluginOptions' => [
                'allowedFileExtensions'=>['mp4'],
                'showPreview' => false,
                'showRemove' => false,
                'showUpload' => false,
                //'minFileCount' => 1
            ],
    ]); 
    if(isset($model->FullVideoStreamURL) && $model->FullVideoStreamURL!='') {  
       // echo $images[1]->ImageName;
    ?>
    <div id="containerForFullVideo">Loading the player...</div>
    <?php 
            $this->registerJs('
                var playerInstance = jwplayer("containerForFullVideo");
                playerInstance.setup({
                    file: "'.S3_VIDEO_BUCKETABSOLUTE_PATH.$model->FullVideoStreamURL.'",
                    image: "'.S3_VIDEO_BUCKETABSOLUTE_PATH.$images[1]->ImageName.'", 
                    primary: "flash",
                    type: "mp4",
                    height: 360,
                    width: 640,
                    advertising: {
                          client: "vast",
                          schedule: {
                                    adbreak1: {
                                            offset: "pre",
                                            tag: "'.$model->PreAdvertisementTagURL.'", 
                                    },
                            }
                    }
                });
            ');
            //'.$model->AdvertisementTagRL.'
        }  */
    ?>
    
    <div class="progress" id="progressForFullVideo" style="display: none;">
        <div class="progress-bar progress-bar-striped active" id="progress-barForFullVideo" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
        progress
        </div>
    </div>
      <div class="col-md-6 form-group">
    <?php
     $playlist = backend\models\Playlist::getPlayList();
         if(!empty($playlist)){
        echo '<label class="control-label">Throwback</label><br>';
        echo MultiSelect::widget([
            'id'=>"video-playlist",
            "options" => ['multiple'=>"multiple"], 
            'data' => backend\models\Playlist::getPlayList(),
            'name' => 'Video[Playlist]', 
            'value' => $playlistData,
            "clientOptions" => 
                [
                    "includeSelectAllOption" => true,
                    'enableFiltering'=>true,
                    'enableCaseInsensitiveFiltering'=>true,
                    'numberDisplayed' => 2
                ], 
        ]);
         }
        ?><br></div>
      <div class="col-md-6 form-group">
    <?php
    $categorylist = backend\models\Category::getCategoryList(2);
        if(!empty($categorylist)){
        echo '<label class="control-label">Action</label><br>';
        echo MultiSelect::widget([
            'id'=>"video-topics",
            "options" => ['multiple'=>"multiple"], 
            'data' => backend\models\Category::getCategoryList(2),
            'name' => 'Video[Topics]', 
            'value' => $topicsData,
            "clientOptions" => 
                [
                    "includeSelectAllOption" => true,
                    'enableFiltering'=>true,
                    'enableCaseInsensitiveFiltering'=>true,
                    'numberDisplayed' => 2
                ], 
        ]);
        }
        ?><br></div>
     <div class="col-md-12 "></div>
      <div class="col-md-6 form-group">
    <?php
     $categorylist = backend\models\Category::getCategoryList(1);
        if(!empty($categorylist)){
        echo '<label class="control-label">Category</label><br>';
        echo MultiSelect::widget([
            'id'=>"video-category",
            "options" => ['multiple'=>"multiple"], 
            'data' => backend\models\Category::getCategoryList(1),
            'name' => 'Video[Category]', 
            'value' => $topicsData,
            "clientOptions" => 
                [
                    "includeSelectAllOption" => true,
                    'enableFiltering'=>true,
                    'enableCaseInsensitiveFiltering'=>true,
                    'numberDisplayed' => 2
                ], 
        ]);
        }
        ?><br></div>
      <div class="col-md-6 form-group">
    <?php 
        echo '<label class="control-label">Country Restrictions</label><br>';
        echo MultiSelect::widget([
            'id'=>"video-countryrestrictions",
            "options" => ['multiple'=>"multiple"], 
            'data' => \backend\models\Country::getCountryList(),
            'name' => 'Video[CountryRestrictions]', 
            'value' => $countryData,
            "clientOptions" => 
                [
                    "includeSelectAllOption" => true,
                    'enableFiltering'=>true,
                    'numberDisplayed' => 2,
                    'enableCaseInsensitiveFiltering'=>true,
                ], 
        ]);
        ?></div>
    <?php
        $getSharedIcon = \backend\models\Video::getSharedVideoIcon();
        
        ?><div class="col-md-12"></div>
     <div class="form-group">
        <label>Shared On : </label>
       
        <?php 
        
            if($model->shared_on != ''  && count($model->shared_on) == 1 ){
                // if there is only one selection 
                // then the append ',' semicolon code goes here
                $model->shared_on = $model->shared_on.",";
            }
        
        $shared_video_on = empty($model->shared_on) ? [] : explode(",",$model->shared_on); 
        $changedValue = [];
        $k = 0; 
        foreach ( $shared_video_on as $val ){
            if($val == ''){
                unset($shared_video_on[$k]);
            }
            $k++;
        }
        $_SESSION['checkedValue'] =  $shared_video_on;
        
        ?>
        <?php  if(!empty($shared_video_on)){
                array_walk($shared_video_on, function($value) use($getSharedIcon){
                     echo '<img src='.$getSharedIcon[$value].'>   ';
                }); 
            }else{
                echo "<label> None </label>";
            }
          
        ?>
     </div>
     <?=
  
    $form->field($model, 'shared_on')->checkboxList($getSharedIcon, [
       'item' =>
            function ($index, $label, $name, $checked, $value) {
                $checked = (in_array($value,$_SESSION['checkedValue'])) ? 1 : 0;
                
                return Html::checkbox($name, $checked, [
                 'value' => $value,
                 'label' => '<img src="' . $label . '">',
                 'labelOptions' => [
                    'class' => 'ckbox ckbox-primary checkbox-inline',
                 ],
                'id' => $label,
                'class' => 'shared_video',
           ]);
       }
  ]);
?>
    <div class="col-md-6">
        <?= $form->field($model, 'AllowDownload')->dropDownList([ 1 => 'Yes', 2 => 'No', ]) ?>
    </div>
    <?php //echo $form->field($model, 'LangID')->dropDownList(\backend\models\Langauge::getLanguageList()); ?>
    <div class="col-md-6">
     <?php if($isShowStatus == true){ ?>
        <?php if($model->Status == 4 || $model->Status == 5){
            $arr = [ 1 =>'Approved', 5=>'Rejected'];
        }else{
            $arr = [ 1 =>'Active', 2 => 'Inactive'];
        }?>
        <?= $form->field($model, 'Status')->dropDownList($arr) ?>
    <?php }else{
         echo $form->field($model,'Status')->hiddenInput()->label(false);
    } ?>
    </div>
    <?php
        if (!empty($_GET['svid'])) {
            echo $form->field($model, 'CreatedBy')->textInput(['readonly'=>true]);
        }else if(!$model->isNewRecord){
            echo ' <div class="form-group">
                    <label>Publisher Name : </label>';
            $publisher_name = (!empty($model->userName->UserName)) ? $model->userName->UserName : "-";
            echo "<input type='text' class='form-control' readonly=true name='Publisher_user' value='".$publisher_name."'>";
            echo "</div>";
            // echo $form->field($model, 'CreatedBy')->textInput(['readonly'=>true,'value'=>])->label('Publisher Name');
        }
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'uploadvideo']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php 
/*\Yii::$app->view->on(yii\web\View::EVENT_END_BODY, function () {
   echo "test etst";
    echo date('Y-m-d');
});*/
?>
<script type="text/javascript">

 function selectRelatedVideo(item){
        $("#spinnerLoaderForRelatedVideo").show();  
        var VideoId=$("#video-id").val();
        var content = item;
        $.ajax({
            type: 'POST',
            data: {content:content,videoId:VideoId},
            url: '<?php echo Url::toRoute('playlist/videosearchforrelatedvideo'); ?>',
            success: function(msg){ 
                $('.displaycontetnForRelatedVideo').html(msg);
                $("#spinnerLoaderForRelatedVideo").hide();  
            }
        });
    }
function  selectThumbnailImages(item){
    $("#spinnerLoaderForThumbImages").show();  
        var VideoId=$("#video-id").val();
        var content = item;
        $.ajax({
            type: 'POST',
            data: {content:content},
            url: '<?php echo Url::toRoute('playlist/videosearchforthumbimages'); ?>',
            success: function(msg){ 
                $('.displaycontetnForThumbImages').html(msg);
                $("#spinnerLoaderForThumbImages").hide();  
            }
        });
    }
function selectFullVideo(item){
    $("#spinnerLoaderForFullVideo").show();  
    var VideoId=$("#video-id").val();
    var content = item;
    $.ajax({
        type: 'POST',
        data: {content:content,videoId:VideoId},
        url: '<?php echo Url::toRoute('playlist/videosearchforfullvideo'); ?>',
        success: function(msg){ 
            $('.displaycontetnForFullVideo').html(msg);
            $("#spinnerLoaderForFullVideo").hide();  
        }
    });
}
</script>