<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;
use kartik\file\FileInput;
use dosamigos\multiselect\MultiSelect;
use kartik\typeahead\Typeahead;

/* @var $this yii\web\View */
/* @var $model backend\models\Playlist */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/common.js',['depends'=>[
  'yii\web\JqueryAsset',
  'yii\web\YiiAsset',
]]);
$this->registerJs("
 $('.removeplyvideo').click(function(){
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
    var rmvvideolnth = checkdbx.length;
    if(rmvvideolnth=='1'){
      $('.rmvdvideo').html(' '+rmvvideolnth +' Video Removed.');
    }
    else{
      $('.rmvdvideo').html(' '+rmvvideolnth +' Videos Removed.');
    }
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
  var categoryvideo=$(this).attr('id');
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
    if(checkedbx.length > 0)
    {
      $('.arrayvideoin').val(JSON.stringify(checkedbx));
      var videolnth = checkedbx.length;
      // if(videolnth=='1'){
      //   $('.slctdvideo').html(' '+videolnth +' Video Selected.');
      // }
      // else{
      //   $('.slctdvideo').html(' '+videolnth +' Videos Selected.');
      // }
      $('#myModal').modal('hide');  
    }
    else
    {
      $('.slctdvideo').html('');
    }
    });


$('.addvideolist').click(function(){
  var checkedbx=new Array();
  var categoryvideo=$(this).attr('id'); 
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
    if(checkedbx.length > 0)
    {
      $('.arrayvideoin').val(JSON.stringify(checkedbx));
      var videolnth = checkedbx.length;
      // if(videolnth=='1'){
      //   $('.slctdvideo').html(' '+videolnth +' Video Selected.');
      // }
      // else{
      //   $('.slctdvideo').html(' '+videolnth +' Videos Selected.');
      // }
      $('#myModal').modal('hide');  
    }
    else
    {
      $('.slctdvideo').html('');
    }
  });
  /*$('.videoname').keydown(function (event)
  {
    if (event.keyCode == 13)
    {
      event.preventDefault(); 
      var categid='';
      var videotitle=$(this).val();
      $.ajax({
       type: 'POST',
       data: {videotitle:videotitle,categid:categid},
       url: 'videosearchplaylist',
       success: function(msg){
         $('.displaycontetn').html(msg);
       }
     });
   }
 });*/
 $('#sortable').sortable();
 $('#sortable2').sortable({
  stop : function(event, ui){
   var sorted=$(this).sortable('toArray', { key:'sort' });
   $('.newarrayorder').val(JSON.stringify(sorted));
 }
});",
yii\web\View::POS_END, 'playlist-form');
$selectedvideotitle = array('');
$videoorderlist = array('');
?>
<style>
#sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
#sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 250px; height: 90px;text-align: center; }
</style>
<div class="playlist-form">

  <?php $form = ActiveForm::begin([
    'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
  <?php echo Html::hiddenInput('arrayvideoin','',['class'=>'arrayvideoin']);
  echo Html::hiddenInput('videoorder','',['class'=>'videoorder']);
  if(!$model->isNewRecord)
  {
    echo Html::hiddenInput('arrayvideoout','',['class'=>'arrayvideoout']);
    echo Html::hiddenInput('newarrayorder','',['class'=>'newarrayorder']);
  }
  ?>
  <?php
  $request = [
       //     "league"=>$listData,
    "field_name"=>['Title'],
    "from_table_name"=>'playlist',
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
    <?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>
  </div>
  <?php foreach ($languageFields as $key => $value) { ?>
  <?php //print_r( $value);die; ?>
  <?= yii\helpers\Html::hiddenInput('languageFields[lang_id]',$value['lang_id']) ?>
  <?= yii\helpers\Html::hiddenInput('languageFields[from_table_name]', $request['from_table_name']) ?>
  <?= yii\helpers\Html::hiddenInput('languageFields[from_table_id]', $model->ID) ?>
  <div id="<?= $key;?>" class="tab-pane fade">
    <div class="form-group field-video-title required">
      <label class="control-label" for="video-title">Throwback Title</label>
      <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][0][id]', $value['fields']['Title']['id']) ?>
      <?= yii\helpers\Html::hiddenInput('languageFields[LanguageFieldsArr][0][field_name]', "Title") ?>
      <?= yii\helpers\Html::input('text','languageFields[LanguageFieldsArr][0][value]', $value['fields']['Title']['value'],["class"=>"form-control"])?>
      <div class="help-block"></div>
    </div>
  </div>
  <?php }?>
</div>

<?php }else{ ?>
<?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>
<?php }    ?>

<?php 
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/common.js',['depends'=>[
  'yii\web\JqueryAsset',
  'yii\web\YiiAsset',
]]);
/*echo '<div class="form-group"><label class="control-label">Playlist Image: <code>recommended image size:540*335 </code></label>';
        echo FileInput::widget([
            'model' => $model,
            'attribute' => 'VideoThumb',
            'options' => ['multiple' => false],
            'pluginOptions' => [
                'allowedFileExtensions'=>['jpg','png','jpeg'],
                'showPreview' => true,
                'showRemove' => false,
                'showUpload' => false,
            ]
          ]);*/ 
          echo $form->field($model, 'VideoThumb')->widget(
            FileInput::classname(),[
              'model' => $model,
              'attribute' => 'VideoThumb',
              'options' => ['multiple' => false],
              'pluginOptions' => [
                'allowedFileExtensions' => ['jpg', 'png'],
                'showPreview' => true,
                'showRemove' => false,
                'showUpload' => false,
              ]
            ])->label('Throwback Image : <code>( Recommended image size : 640 X 360 )</code>');
            ?>
          </div>
          <?php
          if(!$model->isNewRecord)
          {
            ?>
            <div class="imageGallery">
             <img src="<?php echo S3_THUMB_CLOUDFRONT.'/'.PLAYLIST.'/Thumb/'.$model->VideoThumb; ?>" class="img-responsive file-preview-image" />
           </div>
           <?php
         }
         ?>
         <?php

         echo $form->field($model, 'ScheduledRelease')->widget(DateTimePicker::classname(), [
           'options' => ['placeholder' => 'Select Publish Date ...','readonly'=>'readonly'],
           'convertFormat' => true,
           'value' => $model->ScheduledRelease,
           'pluginOptions' => [
            'format' => 'yyyy-M-dd h:i:s P',
                            //'startDate' => '01-Mar-2014 12:00 AM',
            'todayHighlight' => true,
            'autoclose' => true,
          ]
        ]);
        ?>
        <?php 
        echo '<label class="control-label">Country Restrictions</label><br>';
        echo MultiSelect::widget([
          'id'=>"video-countryrestrictions",
          "options" => ['multiple'=>"multiple"], 
          'data' => \backend\models\Country::getCountryList(),
          'name' => 'Country', 
          'value' => $countryData,
          "clientOptions" => 
          [
            "includeSelectAllOption" => true,
            'enableFiltering'=>true,
            'enableCaseInsensitiveFiltering'=>true,
            'numberDisplayed' => 2
          ], 
        ]);
        ?>
        <br><br>
        <?php //echo $form->field($model, 'LangID')->dropDownList(\backend\models\Langauge::getLanguageList()); ?>
        <?= $form->field($model, 'Status')->dropDownList([ 1 => 'Active', 2 => 'Inactive'], ['prompt' => '--Select Status--']) ?>
          <?php  /*
          <fieldset>
          <hr/>

          <?= $form->field($model, 'MetaKeywords')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'MetaDescription')->textarea(['rows' => 2, 'cols' => 5]); ?>
          <?= $form->field($model, 'MetaRobots')->textInput(); ?>
          <hr/>
      </fieldset>
      */ ?>
        <div class="form-group"><label class="control-label" style="display: none;">Select Videos :</label>
         <?php
         echo Html::label('Add', ['id'=>$model->ID],['class'=>'btn btn-success pull-right','onclick'=>'viewMessage()']).'<span class="slctdvideo"></span>';             
         ?></div>
         <?php
         if(!$model->isNewRecord)
         {
          echo '<div class="row" id="sortable2">';
          if(!empty($videoinlist))
          {
            foreach($videoinlist as $videolistinsub)
            {
              $videothumb=$videolistinsub['ImageName'];
              if($videothumb!='')
              {
                $videothumbpage='<img class="thumbnail img-responsive" src="'.ImagesUrl($videolistinsub)/*S3_VIDEO_BUCKETABSOLUTE_PATH.$videothumb*/.'">';
              }
              else 
              {
               $videothumbpage=Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
             }
             $videoorderlist[$videolistinsub['ID']]=$videolistinsub['Title'];
             echo '<div class="col-lg-3 col-sm-4 col-xs-6" id="'.$videolistinsub['ID'].'" sort="'.$videolistinsub['ID'].'"><input type="checkbox" name="imagethumb" class="imagethumbchkbox" value="'.$videolistinsub['ID'].'" data-status="'.$videolistinsub['Status'].'">'.$videothumbpage.'<p>'.Html::a($videolistinsub['Title'],['video/update','id'=>$videolistinsub['ID']],['target'=>'_blank']).'</p></div>';    
           }
         }
         else
         {
        //   echo '<div class="col-lg-3 col-sm-4 col-xs-6"><p> No Records Found </p></div>';
        }
        echo '</div>';
        echo '<div class="form-group pull-left" style="margin-right: 10px">';
          echo  Html::label('Remove', ['id'=>$model->ID],['class'=>'btn btn-danger removeplyvideo','style'=>empty($videoinlist)?'display:none;':'' ]).'<span class="rmvdvideo"></span></div>';     
      }
      ?>

      <div class="form-group pull-left" style="margin-right: 10px">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-primary']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
    <?php
    $content='';
    $addvideobutton='';
    if(!empty($videooutlist))
    {
      foreach($videooutlist as $videolistsub)
      {
        $videothumb=$videolistsub['ImageName'];
        if($videothumb!='')
        {
         $videothumbpage='<img class="thumbnail img-responsive" src="'.ImagesUrl($videolistsub).'">';
       }
       else 
       {
         $videothumbpage=Html::img('@web/images/thumbnail-default.jpg', ['class' => 'thumbnail img-responsive']);
       }
       $content.='<div class="video_block col-lg-3 col-sm-4 col-xs-6" id="sort_'.$videolistsub['ID'].'" sort="'.$videolistsub['ID'].'"> <input type="checkbox" name="videothumb" class="videothumbchkbox" value="'.$videolistsub['ID'].'">'.$videothumbpage.'<p>'.$videolistsub['Title'].'</p></div>';    
       array_push($selectedvideotitle,$videolistsub['Title']);
     }
     $addvideobutton=Html::label('Add Videos', ['id'=>$model->ID],['class'=>'addvideolist btn btn-primary','id'=>$model->ID,'style'=>'cursor:pointer;margin-right:7px']);
   }
   else
   {
   // $content='No Records Found';
  }
  ?>
  <div class="modal fade bs-example-modal-lg filterPopupModel" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="panel panel-default">
         <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Add Videos </h4><div class="pull-right">
           <?php
           echo Typeahead::widget([
            'name' => 'videolist',
            'options' => ['placeholder' => 'Enter Video Title ...','id'=>'videoinput','class'=>'videoname filterInput','style'=>'width:400px;background-color:none;','data-value'=>$model->ID],
            'pluginOptions' => ['highlight'=>true],
            'pluginEvents' => [
              "typeahead:selected" => "function(obj, item) { filterPopup($('#videoinput'));return false; }",
            ],
            'dataset' => [
              [
                'local' => $selectedvideotitle,
                'limit' => 10
              ]
            ]
          ]);
          ?>
          <a title="Clear text"  class="clear_text" href="javascript:void(0);" onclick=" $('#videoinput').val('');filterPopup($('#videoinput')); return false;">
            <span class="close_icon glyphicon glyphicon-remove"></span>
          </a>
        </div></div>
        <div class="panel-body"><div class="alert alert-danger addvdoslcterrshw" style="display:none">
          Please Select Video
        </div><div class="displaycontetn" id="sortable"><?php echo $content;?></div></div>
        <div class="panel-footer"><?php echo $addvideobutton;?><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div></div>
        <script>
          function viewMessage()
          {
            $('#myModal').modal('show');    
          }
        </script>
        
        

<?php /*
$this->registerJsFile('@web/js/jquery.tagsinput.js', ['depends' => [
    'yii\web\YiiAsset',
    'yii\web\JqueryAsset',
    ]]); ?>
<?php $this->registerCss('
    <style type="text/css">
    hr{    border: 0.5px solid #ddd;}
    #playlist-metakeywords_tagsinput {
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
   $('#playlist-metakeywords').tagsInput({
     'class':'form-controll',
     'interactive':true,
     'defaultText':'add a tag',
         //'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
     'removeWithBackspace' : true,
 });
 "); 
 */ ?>