<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Advertisemnts */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="advertisements-form">

    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>
    <?php
    /*echo '<div class="form-group"><label class="control-label">Images : <code>recommended image size:1128*68 </code></label>';
    echo FileInput::widget([
        'model' => $model,
        'attribute' => 'ImagePath',
        'options' => ['multiple' => false],
        'pluginOptions' => [
            'allowedFileExtensions' => ['jpg', 'png'],
            'showPreview' => true,
            'showRemove' => false,
            'showUpload' => false,
        ]
    ]);*/
    echo $form->field($model, 'ImagePath')->widget(
            FileInput::classname(),[
                'model' => $model,
                'attribute' => 'ImagePath',
                'options' => ['multiple' => false],
                'pluginOptions' => [
                    'allowedFileExtensions' => ['jpg', 'png'],
                    'showPreview' => true,
                    'showRemove' => false,
                    'showUpload' => false,
                ]
            ])->label('Images : <code>( Recommended video frame size : 900 X 70 ) </code>');      
    ?>
</div>
<?php
if (!$model->isNewRecord) {
    ?>
    <div class="imageGallery">
        <img src="<?php echo S3_THUMB_CLOUDFRONT . '/' . ADVERISEMENT .'/' . $model->ImagePath; ?>" class="img-responsive file-preview-image" />
        
    </div>
    <?php
}
?>
<?= $form->field($model, 'Content')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'LandingLink')->textInput(['maxlength' => true]) ?>

<?php //echo $form->field($model, 'ScrollTime')->input('number') ?>
<?php
echo $form->field($model, 'FromDate')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Enter From Date ...','readonly'=>'readonly'],
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'mm/dd/yyyy hh:i:s',
    ]
]);
?>
<?php
echo $form->field($model, 'ToDate')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Enter To Date ...','readonly'=>'readonly'],
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'mm/dd/yyyy hh:i:s',
]]);
?>
</div>
    <?= $form->field($model, 'Status')->dropDownList([1 => 'Active', 2 => 'Inactive'], ['prompt' => '--Select Status--']) ?>

<div class="form-group ">
           <?php
        if(!$model->isNewRecord)
        {
        echo  Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]); 
        }
        ?>
		<div class="pull-right">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div></div>

<?php ActiveForm::end(); ?>

</div>
