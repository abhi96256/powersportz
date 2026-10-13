<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\file\FileInput;
use dosamigos\multiselect\MultiSelect;
use kartik\typeahead\Typeahead;

/* @var $this yii\web\View */
/* @var $model backend\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/common.js',['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);
	
$this->registerJs("
  $('.addvideolist').click(function(){

var categoryvideo=$(this).attr('id');

var radiovalue= $('input:radio[name=videothumb]:checked').val();
var selvideotitle= $('input:radio[name=videothumb]:checked').data('videoname');

     


 //$('input:radio[name=videothumb]:checked').parent('div').hide();
 
$('.arrayvideoin').val(radiovalue);

  if (typeof radiovalue === 'undefined') {
    $('.slctdvideo').html('Please select video');
    return false;
 }else{
 
 $('.slctdvideo').html('<b>'+selvideotitle +'</b>' + ' Video Selected.');
  
 }

$('#myModal').modal('hide');  

});
/*
$('.videoname').keydown(function (event)
{
    if (event.keyCode == 13)
    {
    event.preventDefault(); 
    var categid='';
    var videotitle=$(this).val();
   $.ajax({
   type: 'POST',
   data: {videotitle:videotitle,categid:categid},
   url: 'videosearchplaylist',
   success: function(msg){
   $('.displaycontetn').html(msg);
}
});
    }
	});*/
    
", yii\web\View::POS_END, 'schedule-form');
$selectedvideotitle = array('');
$videoorderlist = array('');
?>
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 250px; height: 90px;text-align: center; }
</style>

<div class="schedule-form">
    <div class="row">
<?php
$form = ActiveForm::begin([
            'options' => ['id' => 'schedule-post-form'],
        ]);
?>
        <?php //echo Html::hiddenInput('arrayvideoin','',['class'=>'arrayvideoin']);
        ?>

        <?php // $form->field($model, 'VideoID')->textInput() ?>

        <?php // $form->field($model, 'ProgramTitle')->textInput(['maxlength' => true]) ?>

        <?php // $form->field($model, 'ScheduleDate')->textInput() ?>

        <?php // $form->field($model, 'ScheduleTime')->textInput() ?>

        <?php // $form->field($model, 'Status')->dropDownList([ 1 => '1', 2 => '2', ], ['prompt' => '']) ?>

        <div class="col-lg-12">
            <div class="col-lg-3">
                <label>Schedule Date : <?php //echo date('d-M-Y', strtotime($model->ScheduleDate));
               echo $date= $model->ScheduleDate;
                $time = date("H:i:s",strtotime($model->ScheduleTime)); 
                $sdatetime= $date.' '.$time;
                $convertlocaldatetime=  ConvertDateTolocaltime($sdatetime);
                $spitdatetime = explode(" ", $convertlocaldatetime);
                /*-------------- DISPLAY ONLY DATE --------------------*/
                   $convertdate =  date('d-M-Y', strtotime($spitdatetime[0]));
                   $converttime = $spitdatetime[1].' '.$spitdatetime[2];
				   
				    $ftime = date("H:i:s",strtotime($model->ScheduleFromTime)); 
                $fsdatetime= $date.' '.$ftime;
                $fconvertlocaldatetime=  ConvertDateTolocaltime($fsdatetime);
                $fspitdatetime = explode(" ", $fconvertlocaldatetime);
                /*-------------- DISPLAY ONLY DATE --------------------*/
                   $fconvertdate =  date('d-M-Y', strtotime($fspitdatetime[0]));
                   $fconverttime = $fspitdatetime[1].' '.$fspitdatetime[2];
               ?></label>

            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-3">
                <?php echo $form->field($model, 'ProgramTitle')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-lg-3">
                <?php
                /* echo TimePicker::widget([
                  'name' => 'start_time',
                  'value' => '11:24 AM',
                  'pluginOptions' => [
                  'showSeconds' => false
                  ]
                  ]); */
                
                $model->ScheduleFromTime = $fconverttime;
                echo $form->field($model, 'ScheduleFromTime')->widget(TimePicker::classname(), []);
                ?>
            </div>
 <div class="col-lg-3">
                <?php
                /* echo TimePicker::widget([
                  'name' => 'start_time',
                  'value' => '11:24 AM',
                  'pluginOptions' => [
                  'showSeconds' => false
                  ]
                  ]); */
                
                $model->ScheduleTime = $converttime;
                echo $form->field($model, 'ScheduleTime')->widget(TimePicker::classname(), []);
                ?>
            </div>
            <!--<div class="col-lg-3">
            <?php //echo $form->field($model, 'ScheduleTime')->textInput(['maxlength' => true])  ?>
            </div>
            -->
            <div class="col-lg-3">
                <?php echo $form->field($model, 'VideoURL')->textInput(['maxlength' => true]) ?>
            </div>
            <?php if($model->VideoID > 0){  ?>
            <!--<div class="col-lg-3">
                <?php 
                
               $modelimage = \backend\models\Images::find()->where(['VideoID' => $model->VideoID])->one();
                echo '<img class="thumbnail img-responsive" src="' . ImagesUrl($modelimage)/*S3_VIDEO_BUCKETABSOLUTE_PATH . $modelimage->ImageName*/ . '" width="100" height="100">';
                
               /* $modelvideo = \backend\models\Video::find()->where(['ID' => $model->VideoID])->one();
                echo $modelvideo->Title ;*/
                
                ?>
            </div>-->
                <?php } ?>
            <!-- <div class="col-lg-3">
                <div class="form-group"><br/>
                    <?php
                    echo Html::label('Update Video', ['id' => $model->VideoID], ['class' => 'btn btn-success', 'onclick' => 'viewMessage()']) .'</br>'.'<span class="slctdvideo"></span>';
                    ?></div>
                <input type="hidden" id="arrayvideoin" name="arrayvideoin" value="<?php echo $model->VideoID; ?>" class="arrayvideoin"/>
            </div>-->
        </div>

 <div class="col-lg-12">
        <div class="form-group">

            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
      </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>

<?php
$content = '';
$addvideobutton = '';

if (!empty($videooutlist)) {
    foreach ($videooutlist as $videolistsub) {
        $videothumb = $videolistsub['ImageName'];
        if ($videothumb != '') {
            $videothumbpage = '<img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub)/*S3_VIDEO_BUCKETABSOLUTE_PATH . $videothumb*/ . '">';
        } else {
            $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
        }
        if($videolistsub['ID']== $model->VideoID){
            
            $content.='<div class="video_block col-lg-3 col-sm-4 col-xs-6" id="sort_' . $videolistsub['ID'] . '" sort="' . $videolistsub['ID'] . '"> <input type="radio" id="videothumb" name="videothumb" data-videoname="'.$videolistsub['Title'].'"  class="videothumbchkbox" value="' . $videolistsub['ID'] . '"  checked="checked"  >' . $videothumbpage . '<p>' . $videolistsub['Title'] . '</p></div>';
       
        }else{
           $content.='<div class="video_block col-lg-3 col-sm-4 col-xs-6" id="sort_' . $videolistsub['ID'] . '" sort="' . $videolistsub['ID'] . '"> <input type="radio" id="videothumb" name="videothumb" data-videoname="'.$videolistsub['Title'].'"  class="videothumbchkbox" value="' . $videolistsub['ID'] . '"   >' . $videothumbpage . '<p>' . $videolistsub['Title'] . '</p></div>';
       
        }
        
         array_push($selectedvideotitle, $videolistsub['Title']);
    }
    $addvideobutton = Html::label('Update Videos', ['id' => $model->ScheduleID], ['class' => 'addvideolist btn btn-primary', 'id' => $model->ScheduleID, 'style' => 'cursor:pointer']);
} else {
    $content = 'No Records Found';
}
?>
<div class="modal fade bs-example-modal-lg filterPopupModel" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Update Videos </h4><div class="pull-right">
<?php
echo Typeahead::widget([
    'name' => 'videolist',
    'options' => ['placeholder' => 'Enter Video Title ...','id'=>'videoinput', 'class' => 'videoname', 'style' => 'width:400px;background-color:none;', 'data-value' => $model->VideoID],
    'pluginOptions' => ['highlight' => true],
	'pluginEvents' => [
					"typeahead:selected" => "function(obj, item) { filterPopup($('#videoinput'));return false; }",
                                    ],
    'dataset' => [
        [
            'local' => $selectedvideotitle,
            'limit' => 10
        ]
    ]
]);
?>		<a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick=" $('#videoinput').val('');filterPopup($('#videoinput')); return false;">
                                <span class="close_icon glyphicon glyphicon-remove"></span>
</a>
                    </div></div>
                <div class="panel-body"><div class="alert alert-danger addvdoslcterrshw" style="display:none">
                        Please Select Video
                    </div><div class="displaycontetn" id="sortable"><?php echo $content; ?></div></div>
                <div class="panel-footer"><?php echo $addvideobutton; ?>&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div></div>
<script>
    function viewMessage()
    {
        $('#myModal').modal('show');
    }

    function validate()
    {
        var title = $('#schedule-programtitle').val();
        var time = $('#schedule-scheduletime').val();
		 var ftime = $('#schedule-schedulefromtime').val();
        var videoid = $('#schedule-videourl').val();

        //if(title==''){
        // alert("Please Enter Program Title.");
        // return false;
        // }

        if (time == '') {
            alert("Please Select Time.");
            return false;
        }
if (ftime == '') {
            alert("Please Select From Time.");
            return false;
        }
        if (videoid == '') {
            alert("Please Enter Video");
            return false;
        }
    }


</script>
