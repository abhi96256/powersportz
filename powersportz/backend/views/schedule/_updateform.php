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
            <div class="col-md-12">
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ProgramTitle')->textInput()->label('Title');
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'VideoURL')->textInput();
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'ScheduleFromTime')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Select From Date & Time', 'readonly' => 'readonly', 'class' => 'datetime'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd M yyyy HH:ii P',
                            'startDate' => date('d M Y'),
                            'todayHighlight' => true,
                            'minuteStep'=>2  
                        ],

                    ])->label('From Date & Time');
                    ?>
                </div>
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'ScheduleTime')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Select From Date & Time', 'readonly' => 'readonly', 'class' => 'datetime'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd M yyyy HH:ii P',
                            'startDate' => date('d M Y'),
                            'todayHighlight' => true,
                            'minuteStep'=>2
                        ],

                    ])->label('To Date & Time');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
 
<?php $this->registerJs(' 
'); ?>
