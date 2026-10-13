<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
?> 
<div class="row schedule">
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
  <div class="col-md-1">
    <?php /*<div class="col-md-4">
      <?=
      $form->field($model, 'ScheduleFromTime[]')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Select From Date & time', 'readonly' => 'readonly', 'class' => 'datetime'],
        'pluginOptions' => [
          'autoclose' => true,
          'format' => 'dd M yyyy HH:ii P',
          'startDate' => date('d M Y'),
          'todayHighlight' => true,
          'todayHighlight' => true,
          'minuteStep'=>2
        ],

      ])->label('From Date & time');
      ?>
    </div>
    <div class="col-md-4">
      <?=
      $form->field($model, 'ScheduleTime[]')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Select From Date & time', 'readonly' => 'readonly', 'class' => 'datetime'],
        'pluginOptions' => [
         'autoclose' => true,
         'format' => 'dd M yyyy HH:ii P',
         'startDate' => date('d M Y'),
         'todayHighlight' => true,
         'todayHighlight' => true,
         'minuteStep'=>2
       ],

     ])->label('To Date & time');
     ?>
   </div> */?>
   <div class="col-md-4 pull-right" style="margin-top: 22px">
    <div class="form-group pull-right">
      <button type="button"   class="btn btn-danger removeButton">X</button>    
    </div>
  </div>
</div>
</div>
