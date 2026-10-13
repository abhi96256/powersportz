<?php

use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\multiselect\MultiSelect;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

/*$this->title = $model->CategName;*/
$this->title ='Action Detail';
$this->params['breadcrumbs'][] = ['label' => 'Action', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/common.js',['depends'=>[
  'yii\web\JqueryAsset',
  'yii\web\YiiAsset',
]]);

$this->registerJs("
  $('.deletbutton').click(function(){
    var checkdbx=new Array();
    var category=$(this).attr('id');
    $('input:checkbox[name=imagethumb]').each(function(){
      if($(this).is(':checked'))
        {
          var chkbxvlu=$(this).val();
          checkdbx.push(chkbxvlu);
          $(this).parent('div').hide();
        }
      });
      if(checkdbx.length > 0)
      { 
        $('.arrayvideoout').val(JSON.stringify(checkdbx));
      }
      else
      {
        $('.vdoslcterrshw').show();
        setTimeout(function(){
          $('.vdoslcterrshw').hide();
        }, 5000);
      }
      var box = $('#sortable2').find('.col-lg-3.col-sm-4.col-xs-6.ui-sortable-handle:not(.removable)');
      if(box.is(':visible')==false){
        $('.deletbutton').hide();
      }else{
       $('.deletbutton').show();
     }

   });
   $('#myModal').on('hidden.bs.modal', function () {
    var checkedbx=new Array();
      // var categoryvideo=$(this).attr('id');
    $('#sortable2').find('.removable').remove();
    $('input:checkbox[name=videothumb]').each(function(){
      if($(this).is(':checked'))
       {
         var chekbxvlu=$(this).val();
         var image =$(this).closest('.video_block').find('.thumbnail.img-responsive').attr('src');
         var desc = $(this).closest('.video_block').find('p').text();

         checkedbx.push(chekbxvlu);
         $('#sortable2').append('<div class=\"col-lg-3 col-sm-4 col-xs-6 ui-sortable-handle removable\" id=\"'+chekbxvlu+'\" sort=\"'+chekbxvlu+'\"><input type=\"checkbox\" name=\"imagethumb\" class=\"imagethumbchkbox\" value=\"'+chekbxvlu+'\" disabled><img class=\"thumbnail img-responsive\" src=\"'+image+'\"><p><a href=\"".Url::toRoute(['video/update'])."?id='+chekbxvlu+'\" target=\"_blank\">'+ desc +'</a></p></div>');

       }
     });
     console.log(checkedbx);
     if(checkedbx.length > 0)
     {
      $('.arrayvideoin').val(JSON.stringify(checkedbx));
      var videolnth = checkedbx.length;
      $('.slctdvideo').html(' '+videolnth +' Videos Selected.');
        // $('#myModal').modal('hide'); 
    }
    else
    {
      $('.slctdvideo').html('');
    }
  });
  $('.addvideolist').click(function(){
    var checkedbx=new Array();
      // var categoryvideo=$(this).attr('id');
    $('#sortable2').find('.removable').remove();
    $('input:checkbox[name=videothumb]').each(function(){
      if($(this).is(':checked'))
       {
         var chekbxvlu=$(this).val();
         var image =$(this).closest('.video_block').find('.thumbnail.img-responsive').attr('src');
         var desc = $(this).closest('.video_block').find('p').text();

         checkedbx.push(chekbxvlu);

         $('#sortable2').append('<div class=\"col-lg-3 col-sm-4 col-xs-6 ui-sortable-handle removable\" id=\"'+chekbxvlu+'\" sort=\"'+chekbxvlu+'\"><input type=\"checkbox\" name=\"imagethumb\" class=\"imagethumbchkbox\" value=\"'+chekbxvlu+'\" disabled><img class=\"thumbnail img-responsive\" src=\"'+image+'\"><p><a href=\"".Url::toRoute(['video/update'])."?id='+chekbxvlu+'\" target=\"_blank\">'+ desc +'</a></p></div>');

       }
     });
     console.log(checkedbx);
     if(checkedbx.length > 0)
     {
      $('.arrayvideoin').val(JSON.stringify(checkedbx));
      var videolnth = checkedbx.length;
      $('.slctdvideo').html(' '+videolnth +' Videos Selected.');
      $('#myModal').modal('hide'); 
    }
    else
    {
      $('.slctdvideo').html('');
      $('.addvdoslcterrshw').show();
      setTimeout(function(){
        $('.addvdoslcterrshw').hide();
      }, 5000);
    }

  });


  $('#sortable').sortable();
  $('#sortable2').sortable({
    stop : function(event, ui){
      var sorted=$(this).sortable('toArray', { key:'sort' });
      $('.newarrayorder').val(JSON.stringify(sorted));
    }
  });
  ");
$selectedvideotitle = array('');
$videoorderlist = array('');
?>

<style>
#sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
#sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 250px; height: 90px;text-align: center; }
</style>
<div class="topics-view">
  <h1><?= Html::encode($this->title) ?></h1>
  <?php $form = ActiveForm::begin( [
    'action' => ['topics/update?id='.$model->ID],
    'options' => ['enctype'=>'multipart/form-data']


    ]); ?> 
  <?php 
  echo Html::hiddenInput('arrayvideoin','',['class'=>'arrayvideoin']);
  echo Html::hiddenInput('arrayvideoout','',['class'=>'arrayvideoout']);
  if(!$model->isNewRecord)
  {
    echo Html::hiddenInput('arrayvideoout','',['class'=>'arrayvideoout']);
    echo Html::hiddenInput('newarrayorder','',['class'=>'newarrayorder']);
  }

  ?>
  <div class="container">
    <div class="row">
      <div class="col-xs-4"> <?= $form->field($model, 'CategName')->textInput(['maxlength' => true]) ?></div>
      <div class="col-xs-2"><div class="form-group field-category-status"><label class="control-label" for="Country Restricted"> Country Restricted : </label><?php
      echo MultiSelect::widget([
        'id'=>"multiXX",
    "options" => ['multiple'=>"multiple"], // for the actual multiselect
    'data' => \backend\models\Country::getCountryList(), // data as array
    'value'=>$selectedcountry,
    'name' => 'Country', // name for the form
    "clientOptions" => 
    [
      "includeSelectAllOption" => true,
      'enableFiltering'=>true,
      'enableCaseInsensitiveFiltering'=>true,
      'numberDisplayed' => 2
    ], 
  ]);
  ?></div>
</div>
<div class="col-xs-4"><?= $form->field($model, 'Status')->dropDownList([ 1 => 'Active', 2 => 'Inactive'], ['prompt' => '--Select Status--']) ?></div>
</div>
</div> 
<fieldset>
  <hr/>
  <?= $form->field($model, 'MetaTitle')->textInput(['maxlength' => true]) ?> 
  <?= $form->field($model, 'MetaKeywords')->textInput(['maxlength' => true]) ?>
  <?= $form->field($model, 'MetaDescription')->textarea(['rows' => 2, 'cols' => 5]); ?>
  <?= $form->field($model, 'MetaRobots')->textInput(); ?>
  <hr/>
</fieldset>
<div class="col-xs-12">
 <div class="alert alert-danger vdoslcterrshw" style="display:none">
  Please Select Video
</div>
<?php
echo Html::label('Add Videos', ['id'=>$model->ID],['class'=>'btn btn-success blue pull-right','onclick'=>'viewMessage()']);             
?></div>
<?php
$content='';
$addvideobutton='';
if(!empty($videooutlist))
{
    //echo S3_VIDEO_BUCKETABSOLUTE_PATH;
  foreach($videooutlist as $videolistsub)
  {
    $content.='<div class="video_block col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumb" class="videothumbchkbox" value="'.$videolistsub['ID'].'"><img class="thumbnail img-responsive" src="'. ImagesUrl($videolistsub)/*S3_VIDEO_BUCKETABSOLUTE_PATH.$videolistsub['ImageName']*/.'"><p>'.$videolistsub['Title'].'</p></div>';    
    array_push($selectedvideotitle,$videolistsub['Title']);
  }
  $addvideobutton=Html::label('Add Videos', ['id'=>$model->ID],['class'=>'addvideolist btn btn-primary','id'=>$model->ID,'style'=>'cursor:pointer']);
}
else
{
  $content='No Records Found';
}
?>
<div class="modal fade bs-example-modal-lg filterPopupModel" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="panel panel-default">
       <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Add Videos </h4><div class="pull-right">
         <?php
         echo Typeahead::widget([
          'name' => 'state_10',
          'options' => ['placeholder' => 'Enter Video Title ...','id'=>'video_input','class'=>'videoname filterInput','style'=>'width:400px;background-color:none;','data-value'=>$model->ID],
          'pluginOptions' => ['highlight'=>true],
          'pluginEvents' => [
               // "typeahead:selected" => "function(obj, item) { selectThumbnailImages(item); return false;}",],
           "typeahead:selected" => "function(obj, item) { filterPopup($('#video_input'));return false; }",
         ],
         'dataset' => [
          [
            'local' => $selectedvideotitle,
            'limit' => 10
          ]
        ]
      ]);

      ?>
      <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick="$('#video_input').val('');filterPopup($('#video_input')); return false; ">
        <span class="close_icon glyphicon glyphicon-remove"></span>
      </a>
    </div></div>
    <div class="panel-body ">                     <div class="alert alert-danger addvdoslcterrshw" style="display:none">
      Please Select Video
    </div><div class="displaycontetn"> <?php echo $content;?></div></div>
    <div class="panel-footer"><?php echo $addvideobutton;?> 
     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div></div></div></div></div>
   <div class="row">
    <div id="sortable2">
      <?php
      if(!empty($videoinlist))
      {


        foreach($videoinlist as $videolistinsub)
        {  
          echo '<div class="col-lg-3 col-sm-4 col-xs-6" id="'.$videolistinsub['ID'].'" sort="'.$videolistinsub['ID'].'"><input type="checkbox" name="imagethumb" class="imagethumbchkbox" value="'.$videolistinsub['ID'].'"><img class="thumbnail img-responsive" src="'.ImagesUrl($videolistinsub)/*S3_VIDEO_BUCKETABSOLUTE_PATH.$videolistinsub['ImageName']*/.'"><p>'.Html::a($videolistinsub['Title'],['video/update','id'=>$videolistinsub['ID']],['target'=>'_blank']).'</p></div>';    
        }
      }
      else
      {
     // echo '<div class="col-lg-3 col-sm-4 col-xs-6"><p> No Records Found </p></div></div>';
      }
      ?>
    </div>  
  </div>
  <div class="col-xs-4"><?= Html::label('Remove Selected', ['id'=>$model->ID],['class'=>'deletbutton btn btn-danger','id'=>$model->ID,'style'=>'cursor:pointer;'.(empty($videoinlist)?'display:none':'')]) ?>
   <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?></div>
   <?php ActiveForm::end(); ?>
 </div>
 <script>
  function viewMessage()
  {
    $('#myModal').modal('show');
    
  }
</script>

<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<?php 

$this->registerJsFile('@web/js/jquery.tagsinput.js', ['depends' => [
  'yii\web\YiiAsset',
  'yii\web\JqueryAsset',
  ]]); ?>
<?php $this->registerCss('
  <style type="text/css">
  hr{    border: 0.5px solid #ddd;}
    #topics-metakeywords_tagsinput {
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
 $('#topics-metakeywords').tagsInput({
   'class':'form-controll',
   'interactive':true,
   'defaultText':'add a tag',
   /*'onAddTag':callback_function,
   'onRemoveTag':callback_function,
   'onChange' : callback_function,*/
         //'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
   'removeWithBackspace' : true,
 });
 "); 