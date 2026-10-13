<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\academy\models\ImportForm */
/* @var $school backend\modules\academy\models\School|null */

$this->title = 'Import Teachers';
?>

<div class="academy-teacher-upload">

    <style>
        .academy-teacher-upload h1 {
            float: none;
            margin-bottom: 20px;
        }
    </style>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!-- <li>Excel columns supported: Teacher_Name, Email, School_Name, Levels_Covered, CPD_hours, Programme_Name, Academic_Year, Date_of_Completion, Certificate_ID (header row required).</li> -->
    <li>Download the sample excel sheet <?= Html::a('Download', Yii::getAlias('@web') . '/files/Teacher-sample.csv', ['class' => 'btn btn-info btn-sm', 'download' => 'Teacher-sample.csv']) ?></li>

    <?= $form->field($model, 'file')->fileInput(['accept' => '.xlsx, .csv']) ?>

    <div class="form-group">
        <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

