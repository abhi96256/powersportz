<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\file\FileInput;
use dosamigos\multiselect\MultiSelect;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/common.js',['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);
	

$this->registerJs('
    var checkdbx=new Array();
  $(".addvideolist").click(function(){

var categoryvideo=$(this).attr("id");
 


var radiovalue= $("input:radio[name=videothumb]:checked").val();
var selvideotitle= $("input:radio[name=videothumb]:checked").data("videoname");

 
 $("input:radio[name=videothumb]:checked").parent("div").hide();
 
 
checkdbx.push(radiovalue);


$(".arrayvideoin").val(JSON.stringify(checkdbx));

   if (typeof radiovalue === "undefined") {
    $(".slctdvideo").html("Please select video");
    return false;
 }else{
    // $(".slctdvideo").html(radiovalue + " Video Selected.");
      var imageID = $("#imageID").val();
     
     //var ProgramTitle = $("#schedule-programtitle"+imageID).val();
     $("#slctdvideo"+imageID).html("<b>"+selvideotitle +"</b>"  + " Video Selected.");
 }
 

$("#myModal").modal("hide");  

});
/*
$(".videoname").keydown(function (event)
{
    if (event.keyCode == 13)
    {
    event.preventDefault(); 
    var categid="";
    var videotitle=$(this).val();
   $.ajax({
   type: "POST",
   data: {videotitle:videotitle,categid:categid},
   url: "videosearchplaylist",
   success: function(msg){
   $(".displaycontetn").html(msg);
}
});
    }
	});*/
    
 $("#schedule-post-form").on("beforeSubmit", function (e) {

                $("#spinnerLoader").show();  
            
         });

    
', yii\web\View::POS_END, 'schedule-form');
$selectedvideotitle = array('');
$videoorderlist = array('');
?>
<style>

   .applist1 {
    border: 1px solid grey;
    padding: 50px;
}  


    #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 250px; height: 90px;text-align: center; }

    .error {
        color: red;font-weight: bold;
    }
</style>

<div class="schedule-form">
    <div class="row">
        <?php
        $form = ActiveForm::begin([
                    'options' => ['id' => 'schedule-post-form'],
        ]);
        ?>
        <?php //echo Html::hiddenInput('arrayvideoin', '', ['class' => 'arrayvideoin']);
        ?>

        <?php // $form->field($model, 'VideoID')->textInput()  ?>

        <?php // $form->field($model, 'ProgramTitle')->textInput(['maxlength' => true])  ?>

        <?php // $form->field($model, 'ScheduleDate')->textInput() ?>

        <?php // $form->field($model, 'ScheduleTime')->textInput()  ?>

        <?php // $form->field($model, 'Status')->dropDownList([ 1 => '1', 2 => '2', ], ['prompt' => ''])   ?>

        <div class="col-lg-12">
            <div class="col-lg-3">
                <?=
                $form->field($model, 'ScheduleDate')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Select Date ...', 'readonly' => 'readonly', 'class' => ''],
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'd-M-yyyy',
                       // 'endDate' => date('d-M-yyyy'),
					   'startDate' => date('d-M-yyyy'),
                        'todayHighlight' => true,
                    ],
                   
                ]);
                ?>

            </div>
			 <div class="col-lg-3">
                    <label class="control-label">Schedule From Time</label>
                     <span id="hourerror1"  class="error" ></span><br/>
                   
                    <div class="col-lg-3" >

                        <select class="dropdown-toggle btn btn-default" id="hour1" name="hour[]">
                            <option >Hour</option>
                            <?php
                            for ($i = 1; $i <= 23; $i++) {

                                echo "<option value=" . $i . ">" . $i . "</option>";
                            }
                            ?> 

                        </select>
                 
               
                    </div>
                     
                   
                    <div class="col-lg-3">

                        <select class="dropdown-toggle btn btn-default" id="minute1" name="minute[]">
                            <option >Min</option>

                            <?php
                            for ($i = 00; $i <= 59; $i++) {

                                echo "<option value=" . $i . ">" . $i . "</option>";
                            }
                            ?> 

                        </select> 
                        <span id="minerror1"  class="error" ></span>
                    </div>
                   <!-- <div class="col-lg-2">

                        <select class="dropdown-toggle btn btn-default" id="stime1" name="stime[]">
                            <option >Sec</option>
                            <?php
                            for ($i = 00; $i <= 59; $i++) {

                                echo "<option value=" . $i . ">" . $i . "</option>";
                            }
                            ?> 



                        </select> 
                        <span id="secerror1"  class="error" ></span>
                    </div>
                        -->
                </div>
			  <div class="col-lg-3">
                    <label class="control-label">Schedule To Time</label>
                     <span id="thourerror1"  class="error" ></span><br/>
                   
                    <div class="col-lg-3" >

                        <select class="dropdown-toggle btn btn-default" id="thour1" name="thour[]">
                            <option >Hour</option>
                            <?php
                            for ($i = 1; $i <= 23; $i++) {

                                echo "<option value=" . $i . ">" . $i . "</option>";
                            }
                            ?> 

                        </select>
                 
               
                    </div>
                     
                   
                    <div class="col-lg-3">

                        <select class="dropdown-toggle btn btn-default" id="tminute1" name="tminute[]">
                            <option >Min</option>

                            <?php
                            for ($i = 00; $i <= 59; $i++) {

                                echo "<option value=" . $i . ">" . $i . "</option>";
                            }
                            ?> 

                        </select> 
                        <span id="tminerror1"  class="error" ></span>
                    </div>
                   <!-- <div class="col-lg-2">

                        <select class="dropdown-toggle btn btn-default" id="tstime1" name="tstime[]">
                            <option >Sec</option>
                            <?php
                            for ($i = 00; $i <= 59; $i++) {

                                echo "<option value=" . $i . ">" . $i . "</option>";
                            }
                            ?> 



                        </select> 
                        <span id="tsecerror1"  class="error" ></span>
                    </div>-->
                        
                </div>
        </div>
        
        <div id="addmore"  >

            <div  class="col-lg-12" id="applist1"  >

                <div class="col-lg-3">
                    <div class="form-group">
                        <?php //echo $form->field($model, 'ProgramTitle')->textInput(['maxlength' => true]);  ?>
                        <label for="schedule-programtitle" class="control-label">Program Title</label>
                        <input type="text" name="ProgramTitle[]" class="form-control" id="schedule-programtitle1"  />
                        <span id="titleerror1"  class="error" ></span>
                    </div>
                </div>

               

 <div class="col-lg-3">
                    <div class="form-group"><label class="control-label">Video :</label><br/>

                       <input type="text" name="arrayvideoin[]" id="arrayvideoin1" class="form-control arrayvideoin" value="<?php echo $model->VideoURL; ?>">
                       
                    </div>

                  
                    <span id="videoerror1"  class="error" ></span>
                </div>
               <!-- <div class="col-lg-3">
                    <div class="form-group"><label class="control-label">Select Video :</label><br/>

                        <a id="<?php echo $model->VideoID; ?>" class="btn btn-success"  onclick="viewMessage();">Add</a>
                        
                        <span id="slctdvideo1" class="slctdvideo"></span>
                       
                    </div>

                    <input type="hidden" name="arrayvideoin[]" id="arrayvideoin1" class="arrayvideoin"/>
                    <span id="videoerror1"  class="error" ></span>
                </div>-->
            </div>

        </div>
  

        <div  class="col-lg-12" >
            <div class="col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="imageID" id="imageID" value="1">
                     <!-- <input type="hidden" name="hiddenID" id="hiddenID" value="<?php //echo $model->VideoID;        ?>">-->
                    <?php if ($model->isNewRecord) { ?>
                        <button type="button" class="btn btn-primary" onclick="addApp();">Add More</button>
                    <?php } ?>

                </div>
            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3"></div>
        </div>

        <div  class="col-lg-12" >
            <div class="col-lg-3">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'onclick' => 'return validate()']) ?>
                </div>
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
            $videothumbpage = '<img class="thumbnail img-responsive" src="' .ImagesUrl($videolistsub)/*S3_VIDEO_BUCKETABSOLUTE_PATH . $videothumb */. '">';
        } else {
            $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
        }
        $content.='<div class="video_block col-lg-3 col-sm-4 col-xs-6" id="sort_' . $videolistsub['ID'] . '" sort="' . $videolistsub['ID'] . '"> <input type="radio" id="videothumb" name="videothumb" data-videoname="'.$videolistsub['Title'].'"  class="videothumbchkbox" value="' . $videolistsub['ID'] . '">' . $videothumbpage . '<p>' . $videolistsub['Title'] . '</p></div>';
        array_push($selectedvideotitle, $videolistsub['Title']);
    }
    $addvideobutton = Html::label('Add Video', ['id' => $model->ScheduleID], ['class' => 'addvideolist btn btn-primary', 'id' => $model->ScheduleID, 'style' => 'cursor:pointer']);
} else {
    $content = 'No Records Found';
}
?>
<div class="modal fade bs-example-modal-lg filterPopupModel" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Add Videos </h4><div class="pull-right">
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
                        ?>
						<a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick=" $('#videoinput').val('');filterPopup($('#videoinput')); return false;">
                                <span class="close_icon glyphicon glyphicon-remove"></span>
</a>
                    </div></div>
                <div class="panel-body">
				<div class="alert alert-danger addvdoslcterrshw" style="display:none">
                        Please Select Video
                    </div><div class="displaycontetn" id="sortable"><?php echo $content; ?></div></div>
                <div class="panel-footer"><?php echo $addvideobutton; ?>&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div></div>

<script>
    function viewMessage()
    {
        $('#myModal').modal('show');
    }

    function addApp() {

        var imageID = $("#imageID").val();

        var ProgramTitle = $("#schedule-programtitle" + imageID).val();
        var hour = $("#hour" + imageID).val();
        var minute = $("#minute" + imageID).val();
        var stime = $("#stime" + imageID).val();
        var videoid = $("#arrayvideoin" + imageID).val();

 var thour = $("#thour" + imageID).val();
        var tminute = $("#tminute" + imageID).val();
        var tstime = $("#tstime" + imageID).val();
        
        if (hour == '' || hour == 'Hours' || minute == '' || minute == 'Min') {
            $("#hourerror" + imageID).html('Please Select From Schedule Time' );
            return false;
        } else {
            $("#hourerror" + imageID).html('');
        }
		if (thour == '' || thour == 'Hours' || tminute == '' || tminute == 'Min') {
            $("#thourerror" + imageID).html('Please Select To Schedule Time' );
            return false;
        } else {
            $("#thourerror" + imageID).html('');
        }
if (ProgramTitle == '') {
            $("#titleerror" + imageID).html('Please Enter Program Title' );
            return false;
        } else {
            $("#titleerror" + imageID).html('');
        }
        /* if (hour == '' || hour == 'Hours') {
         $("#hourerror" + imageID).html('Please Select Hours' + imageID);
         return false;
         } else {
         $("#hourerror" + imageID).html('');
         }
         
         if (minute == '' || minute == 'Min') {
         $("#minerror" + imageID).html('Please  Select Minute ' + imageID);
         return false;
         } else {
         $("#minerror" + imageID).html('');
         }
         
         if (stime == '' || stime == 'Sec') {
         $("#secerror" + imageID).html('Please Select Second' + imageID);
         return false;
         } else {
         $("#secerror" + imageID).html('');
         }*/
        /*if (videoid == '') {
            $("#videoerror" + imageID).html('Please Select Video' );
            return false;
        } else {
            $("#videoerror" + imageID).html('');
        }*/

        var addAppID = parseInt(imageID) + parseInt(1);
        $("#imageID").val(addAppID);
        //$("#spinnerLoader").show();  

        var title = '<div class="form-group"><label for="schedule-programtitle" class="control-label">Program Title</label> <input type="text" name="ProgramTitle[]" class="form-control" id="schedule-programtitle' + addAppID + '"  /><span id="titleerror' + addAppID + '"  class="error" ></span></div>';
        var hour = '<span id="hourerror' + addAppID + '"  class="error" ></span><div class="col-lg-2"><select class="dropdown-toggle btn btn-default" id="hour' + addAppID + '" name="hour[]"><option >Hour</option><?php
                        for ($i = 1; $i <= 23; $i++) {
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?></select></div>';
        var min = '<div class="col-lg-2"><select class="dropdown-toggle btn btn-default" id="minute' + addAppID + '"  name="minute[]"><option >Min</option> <?php
                        for ($i = 00; $i <= 60; $i++) {
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?> </select><span id="minerror' + addAppID + '"  class="error" ></span></div>';
        var stime = '<div class="col-lg-2"><select class="dropdown-toggle btn btn-default"  id="stime' + addAppID + '"  name="stime[]"><option >Sec</option><?php
                        for ($i = 00; $i <= 60; $i++) {
                            echo "<option value=" . $i . ">" . $i . "</option>";
                        }
                        ?></select><span id="secerror' + addAppID + '"  class="error" ></span></div>';

        var programtime = '<div class="col-lg-6"><label class="control-label">Schedule Time</label><br/>' + hour + min + stime + '</div>';
        var selvideomsg= '<span id="slctdvideo'+addAppID+'" class="slctdvideo"></span>';
        var selvideo = '<div class="form-group"><label class="control-label">Video :</label><br/> <input type="text" name="arrayvideoin[]" id="arrayvideoin' + addAppID + '" class="form-control arrayvideoin" value="<?php echo $model->VideoURL; ?>"><span id="videoerror' + addAppID + '" class="error" ></span></div>';
       
        var finalAppString = '<div id="applist'+addAppID+'" class="col-lg-12"><hr style=" border: 1px solid grey;"/><div class="col-lg-3">' + title + '</div>' + '<div class="col-lg-3">' + selvideo + '</div><div class="row" class="pull-right"><span class="glyphicon glyphicon-remove" style="cursor:pointer;" aria-hidden="true" onclick="removeApp('+addAppID+');" ></div>  ';
        $("#addmore").append(finalAppString);
      
        
    }
    function removeApp(id) {
        //alert(id);return false;
        $("#applist" + id).remove();
        var imageID = $("#imageID").val();
        var addAppID = parseInt(imageID) - parseInt(1);
        $("#imageID").val(addAppID);
    }


    function validate() {
        var numberOfApps = $("#imageID").val();
        //var numberOfApps = document.getElementsByName("ProgramTitle[]");
        for (var n = 0; n < numberOfApps; n++) {
            // alert(numberOfApps.length); return false;

            var addID = parseInt(n) + parseInt(1);
            // alert(addID); return false;
            var ProgramTitle = $("#schedule-programtitle" + addID).val();
            var hour = $("#hour" + addID).val();
            var minute = $("#minute" + addID).val();
            var stime = $("#stime" + addID).val();
            var videoid = $("#arrayvideoin" + addID).val();

 var thour = $("#thour" + imageID).val();
        var tminute = $("#tminute" + imageID).val();
        var tstime = $("#tstime" + imageID).val();
            if (ProgramTitle == '') {
                $("#titleerror" + addID).html('Please Enter Program Title' );
                return false;
            } else {
                $("#titleerror" + addID).html('');
            }
            if (hour == '' || hour == 'Hour' || minute == '' || minute == 'Min' ) {
                $("#hourerror" + addID).html('Please Select From Schedule Time' );
                return false;
            } else {
                $("#hourerror" + addID).html('');
            }
 if (thour == '' || thour == 'Hour' || tminute == '' || tminute == 'Min' ) {
                $("#thourerror" + addID).html('Please Select To Schedule Time' );
                return false;
            } else {
                $("#thourerror" + addID).html('');
            }
            /*if (hour == '' || hour == 'Hours') {
             $("#hourerror" + addID).html('Please Select Hours' + addID);
             return false;
             } else {
             $("#hourerror" + addID).html('');
             }
             
             if (minute == '' || minute == 'Min') {
             $("#minerror" + addID).html('Please  Select Minute ' + addID);
             return false;
             } else {
             $("#minerror" + addID).html('');
             }
             
             if (stime == '' || stime == 'Sec') {
             $("#secerror" + addID).html('Please Select Second' + addID);
             return false;
             } else {
             $("#secerror" + addID).html('');
             }*/
            /*if (videoid == '') {
                $("#videoerror" + addID).html('Please Select Video' );
                return false;
            } else {
                $("#videoerror" + addID).html('');
            }*/
        }
    }
</script>
