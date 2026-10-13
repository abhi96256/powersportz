<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
?>

<div class="video-form">
    <?php
    $form = ActiveForm::begin([
        'options' => [
            'id' => 'schedule-post-form',
        ],
        'enableClientValidation' => true,
    ]);
    ?>
    <div class="schedule-rows">
        <div class="row schedule schedule-0" data-index="0">
             <div class="col-md-11">
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ScheduleFromTime[]')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Select From Date & Time', 'readonly' => 'readonly', 'class' => 'datetime'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-m-yyyy HH:ii P',
                            'startDate' => date('d M Y'),
                            'todayHighlight' => true, 
                            'minuteStep'=>2, 
                        ],

                    ])->label('From Date & Time');
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ScheduleTime[]')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Select From Date & Time', 'readonly' => 'readonly', 'class' => 'datetime'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-m-yyyy HH:ii P',
                            'startDate' => date('d M Y'),
                            'todayHighlight' => true, 
                            'minuteStep'=>2,
                        ],

                    ])->label('To Date & Time');
                    ?>
                </div>
            </div>
            <div class="col-md-11">
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ProgramTitle[]')->textInput()->label('Title');
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'VideoURL[]')->textInput();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4 pull-right">
                <div class="form-group pull-right">
                    <button type="button" id="add-more" class="btn btn-primary">Add More</button>    
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-4 pull-left">
                <div class="form-group">
                    <button type="submit" id="schedule-create-video" class="btn btn-success">Create</button>    
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div style="display: none;" id="hidden-content">
    <?php echo $this->render('//schedule/form-row',array('model'=>new \backend\models\Schedule(),'form'=> $form)); ?>
</div>
<?php $this->registerJs('
    // jQuery("#schedule-schedulefromtime-datetime").datetimepicker(\'remove\');
    // jQuery("#schedule-scheduletime-datetime").datetimepicker(\'remove\');
    function syncEle(){
        $(\'.row.schedule\').each(function(index,ele){
            $(this).find(\'[name="Schedule[ProgramTitle][]"]\').attr(\'id\',\'schedule-programtitle-\'+index).closest(\'.form-group \').addClass(\'required\');
            $(this).find(\'[name="Schedule[VideoURL][]"]\').attr(\'id\',\'schedule-videourl-\'+index);
        //     $(this).find(\'[name="Schedule[ScheduleFromTime][]"]\').attr(\'id\',\'schedule-schedulefromtime-\'+index).closest(\'.form-group \').addClass(\'required\');
        //     $(this).find(\'[name="Schedule[ScheduleTime][]"]\').attr(\'id\',\'schedule-scheduletime-\'+index).closest(\'.form-group \').addClass(\'required\');
        //     $(\'.datetime\').datetimepicker(\'remove\');
        //     $(\'.datetime\').each(function(){
        //         _ele = $(this);
        //         _ele.datetimepicker({
        //             autoclose:true,
        //             "startDate":"'.date('d M Y').'",
        //             "todayHighlight":true,
        //             "minuteStep":2,
        //             format:"dd M yyyy HH:ii P",
        //         });
        // });
    });
}
  
syncEle();
var i= 1;
$(\'#add-more\').click(function(){
    $(\'.schedule-rows\').append($(\'#hidden-content\').html());  
    syncEle();
    i++;
});
$(document).on(\'click\',\'.removeButton\',function(){
    $(this).closest(\'.row.schedule\').remove();
    syncEle();
});  

$(document).on(\'click\',\'span.input-group-addon\',function(){
    var _ele = $(this);    
    if(_ele.find(\'.glyphicon.glyphicon-remove\').length){
        _ele.siblings(\'input.datetime\').val(\'\');
    }else
    _ele.siblings(\'input.datetime\').focus();
});  

$(\'#schedule-post-form\').on(\'click\',\'#schedule-create-video\', function (event) {
    event.preventDefault()
    var $yiiform = $(\'#schedule-post-form\');
    $yiiform.find(\'input\').closest(\'.form-group\').removeClass(\'has-error\');
    $yiiform.find(\'input\').closest(\'.form-group\').find(\'.help-block\').text("");
    $yiiform.find(\'input\').each(function(){
       label = $(this).closest(\'.form-group\').find(\'label\').text();
       if($(this).closest(\'.form-group\').hasClass(\'required\') && $(this).val()==\'\'){
        $(this).closest(\'.form-group\').addClass(\'has-error\');
        $(this).closest(\'.form-group\').find(\'.help-block\').text(label+\' is required field\');
    }else if($(this).attr(\'name\')== "Schedule[ScheduleTime][]"){

        var from_name =$(this).closest(\'.row.schedule\').find(\'[name="Schedule[ScheduleFromTime][]"]\');
        var to_name =  $(this);
        var start = from_name.val();
        var end = to_name.val();
        console.log(start);
        console.log(end);
        if(start!="" && end!=""){ 
                    // end - start returns difference in milliseconds 
            var diff = (new Date(end).getTime()) - (new Date(start).getTime());
            
            if(diff <= 0){
              $(this).closest(\'.form-group\').addClass(\'has-error\');
              to_name.closest(\'.form-group\').find(\'.help-block\').text(\'"\'+label+\'" must be after "From Date & time"\');
          }
      }

  }
}); 
if($yiiform.find(\'.has-error\').length == 0){
    $.ajax({
        type: $yiiform.attr(\'method\'),
        url: $yiiform.attr(\'action\'),
        data: $yiiform.serializeArray(),
        success:function(response){
            if(response.status==200){
                location.href = "'.Url::to(['/schedule/index']).'";
            }
        }
    }
);
} 
return false; // prevent default form submission
})
'); ?>
