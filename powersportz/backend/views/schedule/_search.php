<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\ScheduleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-search">
    <div class="row">
        <div class="col-lg-12">

            <?php
            $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'post',
            ]);
            ?>

            <?php //$form->field($model, 'ScheduleID') ?>

            <?php //$form->field($model, 'VideoID') ?>

            <?php
            //$form->field($model, 'ProgramTitle') 
            // usage without model

            /* echo DatePicker::widget([
              'name' => 'check_issue_date',
              'value' => date('d-M-Y', strtotime('+2 days')),
              'options' => ['placeholder' => 'Select issue date ...'],
              'pluginOptions' => [
              'format' => 'dd-M-yyyy',
              'todayHighlight' => true
              ]
              ]); */
            ?>


            <div class="col-lg-3">
                <?php
                if (isset($_POST['ScheduleSearch']['ScheduleDate'])) {

                    $date = $_POST['ScheduleSearch']['ScheduleDate'];
                } else {

                    //$date = date('d-M-Y');
                }
                ?>
                <?=
                $form->field($model, 'ScheduleDate')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Search Date ...', 'readonly' => 'readonly', 'class' => '', 'value' => '',],
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-M-yyyy',
                        'todayHighlight' => true,
                    ]
                ]);
                ?>
            </div>
            <div class="col-lg-4">
                <label> </label>
<?php //$form->field($model, 'ScheduleTime')   ?>

                <?php // echo $form->field($model, 'Status')   ?>

                <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                    <!--  <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>-->
                    <input type="button" value="Reset" name="yt1" class="btn btn-success " onclick="document.location.href = '<?php echo Url::to(['/schedule/index']); ?>'" >
                </div>
            </div>
            <!-- <div class="col-lg-3"></div> -->
            <!-- <div class="col-lg-2"></div> -->
            <div class="col-lg-2 add_schedule"> 
                <label> </label>
                <div class="form-group">
<?= Html::a('Add Schedule', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
                    <?php ActiveForm::end(); ?>


        </div></div>

</div>

<script>


</script>