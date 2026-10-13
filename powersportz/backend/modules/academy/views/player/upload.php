<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\academy\models\ImportForm */
/* @var $school backend\modules\academy\models\School|null */

$this->title = 'Import Players';
?>

<div class="academy-player-upload">

    <style>
        .academy-player-upload h1 {
            float: none;
            margin-bottom: 20px;
        }
    </style>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!-- <li>Excel columns supported: Student_Name, Email, Class, Section, School_Name, Level_Completed, Programme_Name, Academic_Year, Date_of_Completion, Certificate_ID (header row required).</li> -->
    <li>Download the sample excel sheet <?= Html::a('Download', '@web/backend/web/files/Student-sample.csv', ['class' => 'btn btn-info btn-sm', 'download' => 'Student-sample.csv']) ?></li> 

    <?= $form->field($model, 'file')->fileInput(['accept' => '.xlsx, .csv']) ?>

    <div class="form-group">
        <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
