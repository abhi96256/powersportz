<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use dosamigos\multiselect\MultiSelect;
use kartik\typeahead\Typeahead;
use kartik\spinner\Spinner;
use yii\helpers\Url;    
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model backend\models\Customadvertisement */
/* @var $form yii\widgets\ActiveForm */
$selectedAccompnyVideoTitle = array('');
 
 
?>
<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1.24.min.js"></script>

<style>
.customvideo {
    border:1px solid grey;margin:5px;padding: 10px;
}    
.field-customadvertisement-type label.control-label {
    float: left;
    margin-right: 20px;
}
</style>    
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
<div class="customadvertisement-form">
    <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data','id'=>'customad-post-form'
                ]
            ]); ?>
    <?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>
    
     <?= $form->field($model, 'IsExternal')->radioList(array('0'=>'Upload Video',1=>'External Url'), ['itemOptions'=>['class' => 'customadvertisement_isexternal']])->label(false); ?>
     <div <?php if($model->IsExternal ==0) { ?> style="display:none;" <?php } ?> id="showUrl" >
      <?= $form->field($model, 'URL')->textInput(['maxlength' => true]) ?>
</div>
 <div <?php if($model->IsExternal ==1) { ?> style="display:none;" <?php } ?> id="showVideo" >
      

    <?php 
      
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
                        'minFileCount' => 1
                    ],
            ]); 
            if(isset($model->VideoURL) && $model->VideoURL!='') {
                echo $form->field($model,'VideoURL')->hiddenInput()->label(false);
                ?>
            <video id="containerForShortVideo" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="640" height="360" playsinline></video>
            <?php 
                    $this->registerJs('
                        var playerInstance = videojs("containerForShortVideo", {
                            controls: true,
                            autoplay: false,
                            preload: "auto",
                            width: 640,
                            height: 360,
                            sources: [{
                                src: "'.S3_THUMB_CLOUDFRONT.'/'.$model->VideoURL.'",
                                type: "video/mp4"
                            }]
                        });
                    ');
                    //'.$model->AdvertisementTagRL.'
                   
            ?>
            
            <div class="progress" id="progressForShortVideo" style="display: none;">
                <div class="progress-bar progress-bar-striped active" id="progress-barForShortVideo" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                progress    
                </div>
            </div>
            <div class="form-group">
            <label>Video URL</label>
            <label><a target="_blanck" href="<?= S3_THUMB_CLOUDFRONT.'/'.$model->VideoURL; ?>"><?= S3_THUMB_CLOUDFRONT.'/'.$model->VideoURL; ?></a></label>
            <!-- <button class="relatedVideosPopup">+</button> -->
        </div>
      <?php } ?>
      </div>
    <?= $form->field($model, 'LandingLink')->textInput(['maxlength' => true]) ?>
    <?php 
        if($model->Type == 0 && $model->Type !='') 
             $model->Type =[1,2,3];
         else
            $model->Type = explode(',', $model->Type);
    ?>      
    <?= $form->field($model, 'Type')->checkBoxList(array('1'=>'Pre Roll','2'=>'Mid Roll','3'=>'Post Roll'), ['itemOptions'=>['class' => 'customadvertisement_type']]); ?>
    <div <?php if($model->Type !='2' && $model->Type !='0') { ?> style="display:none;" <?php } ?> id="showMidTime" >
        <?= $form->field($model, 'MidTime')->dropDownList(backend\models\Video::changeThumbnailTimeAd()) //['prompt'=>'--Select Time--'] ?>
    </div>    
    <?= $form->field($model, 'IsSkip')->checkbox(array('1'=>'IsSkip'))->label(false); ?>
    <div <?php if($model->IsSkip =='') { ?> style="display:none;" <?php } ?> id="showSkipTime" >
        <?= $form->field($model, 'SkipTime')->dropDownList(backend\models\Customadvertisement::changeThumbnailTime()) //['prompt'=>'--Select Time--'] ?>
    </div>
    <?php 
            echo $form->field($model, 'FromDate')->widget(DateTimePicker::classname(),[
                    'options' => ['placeholder' => 'Select From Date ...','readonly'=>'readonly'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-M-dd h:i P',
                        'todayHighlight' => true,
                        'autoclose' => true,
                    ]
                ]);
    ?>
    <?php 
            echo $form->field($model, 'ToDate')->widget(DateTimePicker::classname(),[
                'options' => ['placeholder' => 'Select To Date ...','readonly'=>'readonly'],
                'convertFormat' => true,
                'pluginOptions' => [
                    'format' => 'yyyy-M-dd h:i P',
                    'todayHighlight' => true,
                    'autoclose' => true,
                ]
            ]);
    ?>
    <?= $form->field($model, 'IsAll')->radioList(array('1'=>'Select All',2=>'Custom'))->label(false);
   // print_r(backend\models\Category::getCategoryList(2));exit;
    ?>
    <div id='customOptions' <?php if($model->IsAll == '1') { ?> style='display:none;' <?php } ?> class="customvideo">
       <?= $form->field($model, 'IsHomePage')->checkbox()->label(false); ?>
        <?php
        $categorylist = backend\models\Category::getCategoryList(2);
        if(!empty($categorylist)){
            echo '<label class="control-label">Action</label><br>';
            echo MultiSelect::widget([
                'id'=>"video-topics",
                "options" => ['multiple'=>"multiple"], 
                'data' => backend\models\Category::getCategoryList(2),
                'name' => 'Customadvertisement[CustomTopics]', 
                'value' => $topicsData,
                "clientOptions" => 
                    [
                        "includeSelectAllOption" => true,
                        'enableFiltering'=>true,
                        'numberDisplayed' => 2,
                        'showDropdowns'=>true
                    ], 
            ]);
        }
        ?><br>
        <?php
        $playlist = backend\models\Playlist::getPlayList();
         if(!empty($playlist)){
            echo '<label class="control-label">Throwback</label><br>';
            echo MultiSelect::widget([
                'id'=>"video-playlist",
                "options" => ['multiple'=>"multiple"], 
                'data' => backend\models\Playlist::getPlayList(),
                'name' => 'Customadvertisement[CustomPlaylist]', 
                'value' => $playlistData,
                "clientOptions" => 
                    [
                        "includeSelectAllOption" => true,
                        'enableFiltering'=>true,
                        'numberDisplayed' => 2,
                        'showDropdowns'=>true
                    ], 
            ]);
         }
        ?><br>
        <label class="control-label">Individual Videos</label><br>
        <?= Html::button($content = 'Select Individual Videos',['onclick'=>'showAccompanyingVideos();']);?> <b id="individualVideosNumber"><?php echo count($customVideo); ?></b> video selected.
    </div>
    <?= $form->field($model, 'Status')->dropDownList([ 1 => 'Active', 2 => 'Inactive', ]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php echo $form->field($model,'VideosID')->hiddenInput()->label(false); ?>
    <?php ActiveForm::end(); ?>
</div>

<?php

/**************************************** For Accompanying Videos *****************************/
$contentForAccompanying = '';
$addvideobuttonForAccompanying = '';
if (!empty($videooutlist)) {
    $n = 0;
    foreach ($videooutlist as $videolistsub) {
        $videothumb = $videolistsub['ImageName'];
        if ($videothumb != '') {
            $videothumbpage =
                    '<img class="thumbnail img-responsive" src="' . S3_VIDEO_BUCKETABSOLUTE_PATH . $videothumb . '">';
        } else {
            $videothumbpage =
                    Html::img('@web/images/thumbnail-default.jpg',
                            ['class' => 'thumbnail img-responsive']);
        }
        $checked = '';
        if(in_array($videolistsub['ID'],$customVideo)) {
            $checked  = "checked=''";
        }
        $contentForAccompanying.='<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" '.$checked.' id="video'.$n.'" name="videoaccompanying[]" class="videothumbchkbox" value="' . $videolistsub['ID'] . '">' . $videothumbpage . '<p>' . $videolistsub['Title'] . '</p></div>';
        array_push($selectedAccompnyVideoTitle,$videolistsub['Title']);
        $n++;
    }
    $addvideobuttonForAccompanying = Html::label('Add Videos','',['class' => 'addAccompnyvideolist btn btn-primary','style' => 'cursor:pointer','onclick'=>'individualVideos();']);
} else {
    $contentForAccompanying = 'No Records Found';
}

$this->registerJs('
            // if($("#customadvertisement-isexternal").find("input.customadvertisement_isexternal[value=\'1\']").is(":checked")){
            //     $("#showUrl").show();
            //     $("#showVideo").hide();
            // }else{
            //     $("#showVideo").show();
            //     $("#showUrl").hide();
            // }

            if($("#customadvertisement-type").find("input.customadvertisement_type[value=\'2\']").is(":checked")){
                $("#showMidTime").show();
            }else{
                $("#showMidTime").hide();
            }
        $("#customadvertisement-isall").click(function() {
        
                var id = $("#customadvertisement-isall input[type=radio]:checked").val();
                
                if(id == "1") {
                    $("#customOptions").hide();
                } else if(id == "2") {
                    $("#customOptions").show();
                }
        });
        $("#customadvertisement-isexternal").find("input.customadvertisement_isexternal").change(function(){
            if($(this).val()== 1){
               $("#showUrl").show();
                $("#showVideo").hide();
            }else{
                $("#showVideo").show();
                $("#showUrl").hide();
            }
        });

        $("#customadvertisement-type").find("input.customadvertisement_type[value=\'2\']").change(function(){
            if($(this).is(":checked")){
                $("#showMidTime").show();
            }else{
                $("#showMidTime").hide();
            }
        });
        
        $("#customadvertisement-isskip").click(function() {
            if($("#customadvertisement-isskip").is(":checked")) {
                $("#showSkipTime").show();
            } else {
                $("#showSkipTime").hide();
            }    
        });
'); 

?>

<script>
function showAccompanyingVideos() {
    $("#myModalAccompanying").modal('show');
}    
function selectVideoForAccompanying(item) {
        $("#spinnerLoaderForAccompnyPopup").show();  
        var categid='';
        var videotitle = item;
        $.ajax({
            type: 'POST',
            data: {videotitle:videotitle,categid:categid},
            url: '<?php echo Url::toRoute('playlist/videosearchforaccompanying'); ?>',
            success: function(msg){ 
                $('.displaycontetnForAccompanying').html(msg);
                $("#spinnerLoaderForAccompnyPopup").hide();  
            }
        });
}
function individualVideos() {
        var videosList = document.getElementsByName('videoaccompanying[]');
        var videoString = '';
        var countChecked = 0;
        for(var i=0; i<videosList.length;i++) {
            if($("#video"+i).is(':checked')) {
                videoString+=','+videosList[i].value;
                countChecked++;
            }
        }
        var individulaString = videoString.substring(1);
        $("#customadvertisement-videosid").val(individulaString);
        $("#individualVideosNumber").html(countChecked);
        $("#myModalAccompanying").modal('hide');
}
</script>


<!-- For Accompanying Video -->

<div class="modal fade bs-example-modal-lg filterPopupModel" id="myModalAccompanying" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Select Videos </h4>
                    <div class="pull-right">
                        <?php
                        echo Typeahead::widget([
                            'name' => 'videolist',
                            'options' => ['placeholder' => 'Enter Video Title ...',
                                            'class' => 'videoname',
                                            'style'=>'width:400px;background-color:none;',
                                            'id'=>'indivisual_video_input'
                                         ],
                                    'pluginOptions' => ['highlight' => true],
                                    'pluginEvents' => [
                                            //"typeahead:selected" => "function(obj, item) { selectVideoForAccompanying(item); return false;}",
                                             "typeahead:selected" => "function(obj, item) { filterPopup($('#indivisual_video_input'));return false; }",
                                        ],
                                    'dataset' => [
                                    [
                                        'local' => $selectedAccompnyVideoTitle,
                                        'limit' => 10
                                    ]
                            ]
                        ]);
                        ?>
                         <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick="if($('#indivisual_video_input').val() != ''){  $('#indivisual_video_input').val('');filterPopup($('#indivisual_video_input')); return false; } ">
                                <span class="close_icon glyphicon glyphicon-remove"></span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
                    <div class="displaycontetnForAccompanying"><?php echo $contentForAccompanying; ?></div>
                </div>
                <div class="panel-footer"><?php echo $addvideobuttonForAccompanying;?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="spinnerLoaderForAccompnyPopup" style="display:none;">
    <?php echo Spinner::widget([
                    'preset' => Spinner::LARGE,
                    'color' => 'blue',
                    'align' => 'center'
            ]);
    ?>
    </div>
</div>