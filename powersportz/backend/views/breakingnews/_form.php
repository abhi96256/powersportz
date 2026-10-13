<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Breakingnews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="breakingnews-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    $request = [
       //     "league"=>$listData,
            "field_name"=>['Title'],
            "from_table_name"=>'breakingnews',
            "from_table_id"=>$model->ID,
        ];

    $languageFields = \backend\models\Langauge::getLanguageFields($request);
    if(!empty($languageFields)){ ?>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#english">English</a></li>
            <?php foreach ($languageFields as $key => $value) { ?>
               <li><a data-toggle="tab" href="#<?= $key;?>"><?= $key; ?></a></li>
            <?php }?>
        </ul>

        <div class="tab-content">
             <div id="english" class="tab-pane fade in active">
                <?= $form->field($model, 'Title')->textArea(['maxlength' => true]) ?>
             </div>
             <?php foreach ($languageFields as $key => $value) { ?>
                <?php //print_r( $value);die; ?>
                <?= yii\helpers\Html::hiddenInput('languageFields[lang_id]',$value['lang_id']) ?>
                <?= yii\helpers\Html::hiddenInput('languageFields[from_table_name]', $request['from_table_name']) ?>
                <?= yii\helpers\Html::hiddenInput('languageFields[from_table_id]', $model->ID) ?>
                <div id="<?= $key;?>" class="tab-pane fade">
                    <div class="form-group field-video-title required">
                        <label class="control-label" for="video-title">Content</label>
                        <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][0][id]', $value['fields']['Title']['id']) ?>
                        <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][0][field_name]', "Title") ?>
                        <?= yii\helpers\Html::textarea('languageFields[LanguageFieldsArr][0][value]', $value['fields']['Title']['value'],["class"=>"form-control"])?>
                        <div class="help-block"></div>
                    </div>
               </div>
            <?php }?>
        </div>

   <?php }else{ ?>
        <?= $form->field($model, 'Title')->textArea(['maxlength' => true]) ?>
    <?php }    ?>
    <?php //$form->field($model, 'Title')->textArea(['maxlength' => true]) ?>
    <?= $form->field($model, 'LandingLink')->textInput(['maxlength' => true]) ?>
    <?php //$form->field($model, 'ScrollTime')->input('number') ?>
    <?= $form->field($model, 'Status')->dropDownList([ 1 => 'Active', 2 => 'Inactive'], ['prompt' => '--Select Status--']) ?>

    <div class="form-group">
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
<?php /*= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) */ ?>    
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div></div>
    <?php ActiveForm::end(); ?>

</div>
