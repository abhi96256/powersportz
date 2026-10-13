<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\multiselect\MultiSelect;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
     $request = [
           //     "league"=>$listData,
                "field_name"=>['CategName'],
                "from_table_name"=>'category',
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
                    <?= $form->field($model, 'CategName')->textInput(['maxlength' => true]) ?> 
                 </div>
                 <?php foreach ($languageFields as $key => $value) { ?>
                    <?php //print_r( $value);die; ?>
                    <?= yii\helpers\Html::hiddenInput('languageFields[lang_id]',$value['lang_id']) ?>
                    <?= yii\helpers\Html::hiddenInput('languageFields[from_table_name]', $request['from_table_name']) ?>
                    <?= yii\helpers\Html::hiddenInput('languageFields[from_table_id]', $model->ID) ?>
                    <div id="<?= $key;?>" class="tab-pane fade">
                        <div class="form-group field-video-title required">
                            <label class="control-label" for="video-title">Category Name</label>
                            <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][0][id]', $value['fields']['CategName']['id']) ?>
                            <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][0][field_name]', "CategName") ?>
                            <?= yii\helpers\Html::input('text','languageFields[LanguageFieldsArr][0][value]', $value['fields']['CategName']['value'],["class"=>"form-control"])?>
                            <div class="help-block"></div>
                        </div>
                   </div>
                <?php }?>
            </div>

       <?php }else{ ?>
            <?= $form->field($model, 'CategName')->textInput(['maxlength' => true]) ?> 
        <?php }    ?>
   
   <?php 
        echo '<label class="control-label">Country Restrictions</label><br>';
        echo MultiSelect::widget([
            'id'=>"video-countryrestrictions",
            "options" => ['multiple'=>"multiple"], 
            'data' => \backend\models\Country::getCountryList(),
            'name' => 'Country', 
            "clientOptions" => 
                [
                    "includeSelectAllOption" => true,
                    'enableFiltering'=>true,
                    'numberDisplayed' => 2
                ], 
        ]);
    ?>
    
    <!-- <br><br>-->
      <?php //echo $form->field($model, 'LangID')->dropDownList(\backend\models\Langauge::getLanguageList()); ?>
    
    <?= $form->field($model, 'Status')->dropDownList([ 1 => 'Active', 2 => 'Inactive'], ['prompt' => '--Select Status--']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::a('Cancel', ['/category/index'], ['class'=>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
