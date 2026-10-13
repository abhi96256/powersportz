<?php

use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\multiselect\MultiSelect;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

/*$this->title = $model->CategName;*/
$this->title ='Category Detail';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
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
      var rmvvideolnth = checkdbx.length;
      // if(rmvvideolnth=='1'){
      //   $('.rmvdvideo').html(' '+rmvvideolnth +' Video Removed.');
      // }
      // else{
      //   $('.rmvdvideo').html(' '+rmvvideolnth +' Videos Removed.');
      // }
    }
    else
    {
      $('.vdoslcterrshw').show();
      setTimeout(function(){
        $('.vdoslcterrshw').hide();
      }, 5000);
    }
    var box= $('#sortable2').find('.col-lg-3.col-sm-4.col-xs-6:not(.removable)');
      
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
       checkedbx.push(chekbxvlu);
       var image =$(this).closest('.video_block').find('.thumbnail.img-responsive').attr('src');
       var desc = $(this).closest('.video_block').find('p').text();

       $('#sortable2').append('<div class=\"col-lg-3 col-sm-4 col-xs-6 removable\" id=\"'+chekbxvlu+'\" sort=\"'+chekbxvlu+'\"><input type=\"checkbox\" name=\"imagethumb\" class=\"imagethumbchkbox\" value=\"'+chekbxvlu+'\" disabled><img class=\"thumbnail img-responsive\" src=\"'+image+'\"><p><a href=\"".Url::toRoute(['video/update'])."?id='+chekbxvlu+'\" target=\"_blank\">'+ desc +'</a></p></div>');
     }
   });

   if(checkedbx.length > 0)
   {
    $('.arrayvideoin').val(JSON.stringify(checkedbx));
    var videolnth = checkedbx.length;
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
    $('.addvdoslcterrshw').show();
    setTimeout(function(){
     $('.addvdoslcterrshw').hide();
   }, 5000);
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
       checkedbx.push(chekbxvlu);
       var image =$(this).closest('.video_block').find('.thumbnail.img-responsive').attr('src');
       var desc = $(this).closest('.video_block').find('p').text();

       $('#sortable2').append('<div class=\"col-lg-3 col-sm-4 col-xs-6  removable\" id=\"'+chekbxvlu+'\" sort=\"'+chekbxvlu+'\"><input type=\"checkbox\" name=\"imagethumb\" class=\"imagethumbchkbox\" value=\"'+chekbxvlu+'\" disabled><img class=\"thumbnail img-responsive\" src=\"'+image+'\"><p><a href=\"".Url::toRoute(['video/update'])."?id='+chekbxvlu+'\" target=\"_blank\">'+ desc +'</a></p></div>');
     }
   });

   if(checkedbx.length > 0)
   {
    $('.arrayvideoin').val(JSON.stringify(checkedbx));
    var videolnth = checkedbx.length;
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
    $('.addvdoslcterrshw').show();
    setTimeout(function(){
     $('.addvdoslcterrshw').hide();
   }, 5000);
 }

});
/*$('.videoname').keydown(function (event)
{
  if (event.keyCode == 13)
  {
    event.preventDefault(); 
    var categid=$(this).data('value');
    var videotitle=$(this).val();
    $.ajax({
     type: 'POST',
     data: {videotitle:videotitle,categid:categid},
     url: 'videosearch',
     success: function(msg){ 
       $('.displaycontetn').html(msg);
     }
   });
 }
});*/
",
yii\web\View::POS_END, 'category-view');
$selectedvideotitle = array('');
?>
<div class="category-view">
  <h1><?= Html::encode($this->title) ?></h1>
<!--    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
      </p>-->
      <p class="pull-right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
      </p>
      <?php $form = ActiveForm::begin( [
        'action' => ['category/update?id='.$model->ID]
        ]); ?> 
      <?php 
      echo Html::hiddenInput('arrayvideoin','',['class'=>'arrayvideoin']);
      echo Html::hiddenInput('arrayvideoout','',['class'=>'arrayvideoout']);
      ?>
      <div class="container">
        <div class="row">
          <div class="col-xs-4 col-sm-12">
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

        </div>
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
<hr>
<div class="col-xs-12">
 <div class="alert alert-danger vdoslcterrshw" style="display:none">
  Please Select Video
</div>
<?php
echo Html::label('Select Videos', ['id'=>$model->ID],['class'=>'btn btn-success blue pull-right','onclick'=>'viewMessage()']).'<span class="slctdvideo"></span><span class="rmvdvideo"></span>';             
?></div>
<?php
$content='';
$addvideobutton='';
if(!empty($videooutlist))
{
  foreach($videooutlist as $videolistsub)
  {
    $content.='<div class="video_block ol-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumb" class="videothumbchkbox" value="'.$videolistsub['ID'].'"><img class="thumbnail img-responsive" src="'. ImagesUrl($videolistsub).'"><p>'.$videolistsub['Title'].'</p></div>';    
    array_push($selectedvideotitle,$videolistsub['Title']);
  }
  $addvideobutton=Html::label('Add Selected  Videos', ['id'=>$model->ID],['class'=>'addvideolist btn btn-primary','id'=>$model->ID,'style'=>'cursor:pointer']);
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
        <div class="panel-heading clearfix"><h4 class="panel-title pull-left" style="padding-top: 7.5px;">Videos </h4><div class="pull-right">
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
    <div class="panel-body "><div class="alert alert-danger addvdoslcterrshw" style="display:none">
      Please Select Video
    </div><div class="displaycontetn"> <?php echo $content;?></div></div>
    <div class="panel-footer"><?php echo $addvideobutton;?> 
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div></div></div></div></div>
    <div class="row video_category_block " id="sortable2">
      <?php
      if(!empty($videoinlist))
      {
        foreach($videoinlist as $videolistinsub)
        {
          echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="imagethumb" class="imagethumbchkbox" value="'.$videolistinsub['ID'].'"><img class="thumbnail img-responsive" src="'.ImagesUrl($videolistinsub).'"><p>'.Html::a($videolistinsub['Title'],['video/update','id'=>$videolistinsub['ID']],['target'=>'_blank']).'</p></div>';    
        }
      }
      else
      {
       // echo '<div class="col-lg-3 col-sm-4 col-xs-6"><p> No Records Found </p></div>';
      }
      ?>
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