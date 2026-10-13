<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\multiselect\MultiSelect;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form yii\widgets\ActiveForm */
$records = array();
foreach($countrylist as $countrymainlist)
{
//var_dump($countrymainlist['ID']);
 $records[$countrymainlist['ID']] = $countrymainlist['Name'];
}


?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
        ]); ?>

        <?= $this->render('Langauge_translate_fields',compact(['form','model'])); ?>
        <?php 
//echo '<div class="form-group"><label class="control-label">Images</label>';
  //      echo FileInput::widget([
    //        'model' => $model,
      //      'attribute' => 'CategThumb',
        //    'options' => ['multiple' => false],
          //  'pluginOptions' => [
            //    'allowedFileExtensions'=>['jpg','png','jpeg'],
              //  'showPreview' => true,
                //'showRemove' => false,
               // 'showUpload' => false,
           // ]
        //]);
        echo $form->field($model, 'CategThumb')->widget(
            FileInput::classname(),[
                'model' => $model,
                'attribute' => 'CategThumb',
                'options' => ['multiple' => false],
                'pluginOptions' => [
                    'allowedFileExtensions' => ['jpg', 'png'],
                    'showPreview' => true,
                    'showRemove' => false,
                    'showUpload' => false,
                ]
            ])->label('Talking Turkey Image :');
            ?>
        </div>
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
                'enableCaseInsensitiveFiltering'=>true,
                'numberDisplayed' => 2
            ], 
        ]);
        ?>
        <!--<br><br>-->
        <?php //echo $form->field($model, 'LangID')->dropDownList(\backend\models\Langauge::getLanguageList()); ?>
        <?= $form->field($model, 'Status')->dropDownList([ 1 => 'Active', 2 => 'Inactive'], ['prompt' => '--Select Status--']) ?>
        <?php /*
        <fieldset>
          <hr/>


          <?= $form->field($model, 'MetaKeywords')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'MetaDescription')->textarea(['rows' => 2, 'cols' => 5]); ?>
          <?= $form->field($model, 'MetaRobots')->textInput(); ?>
          <hr/>
      </fieldset>
      */ ?>
      <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Cancel', ['/talking-points/index'], ['class'=>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php /*
$this->registerJsFile('@web/js/jquery.tagsinput.js', ['depends' => [
    'yii\web\YiiAsset',
    'yii\web\JqueryAsset',
    ]]); ?>
<?php $this->registerCss('
    <style type="text/css">
    hr{    border: 0.5px solid #ddd;}
    #talkingpoints-metakeywords_tagsinput {
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 12px;
    width: 100% !important;
}
</style>');?>
<?php $this->registerJs(" 
   $('#talkingpoints-metakeywords').tagsInput({
     'class':'form-controll',
     'interactive':true,
     'defaultText':'add a tag',
         //'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
     'removeWithBackspace' : true,
 });
 ");  
*/  ?>