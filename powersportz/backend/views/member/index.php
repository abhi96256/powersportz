<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Members';
$this->params['breadcrumbs'][] = $this->title;


?>
<style>
  .error {
        color: red;font-weight: bold;
    }
</style>
<div class="member-index">

    <p> 
        <?php
        //$modelsystemconfig = new backend\models\Subscribervideosetting();
         $modelsystemconfig = \backend\models\Subscribervideosetting::find()->orderBy(['SID'=>SORT_DESC])->one();
        $form = ActiveForm::begin(['method' => 'post',]);
        ?>

        <?php
        /*  echo $form->field($modelsystemconfig, 'FromDate')->widget(DatePicker::classname(), [
          'options' => ['placeholder' => 'Search Date ...', 'readonly' => 'readonly', 'class' => '',],
          'removeButton' => false,
          'pluginOptions' => [
          'autoclose' => true,
          'format' => 'dd-M-yyyy',
          'todayHighlight' => true,
          ]
          ]); */
        ?>
        <div class="col-lg-12">
             <div class="col-lg-3">
                 <h4>Enable subscribers to upload video from: </h4>
            </div>
            <div class="col-lg-3">
                <?php
                echo $form->field($modelsystemconfig, 'FromDate')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Enter Start Date ...', 'readonly' => 'readonly','value'=> date('d-M-Y g:i A',strtotime(ConvertDateTolocaltime($modelsystemconfig['FromDate']))),],
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                       //'format' => 'yyyy-m-d hh:ii:ss',
                        'format' => 'dd-M-yyyy HH:ii P',
                    ]
                ]);
                ?>
                <span id="formdateerror"  class="error" ></span>
            </div>
            
            <div class="col-lg-3">
                <?php
                echo $form->field($modelsystemconfig, 'ToDate')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Enter End Date ...', 'readonly' => 'readonly','value'=> date('d-M-Y g:i A',strtotime(ConvertDateTolocaltime($modelsystemconfig['ToDate']))),],
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                          'format' => 'dd-M-yyyy HH:ii P',
                    ]
                ]);
                ?>
                <span id="todateerror"  class="error" ></span>
            </div>
            
            <div class="col-lg-2">
                <label> </label>
                <div class="form-group">
                    <input type="button" name="enableupload" class="btn btn-primary" value="Save" onclick="return setEnableupload();"/>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>     
   </p>
   
<h1>Subscribers </h1>
<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <!--<p>
<?= Html::a('Create Member', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

<?=
GridView::widget([
    'dataProvider' => $model->search(),
    'filterModel' => $model,
    'columns' => [
       // ['class' => 'yii\grid\SerialColumn'],
        //'MemberID',
        // 'FirstName',
        // 'LastName',
        [
            'header' => 'Name',
            'attribute' => 'FirstName',
            'filterInputOptions' => [
                        'class'=>'form-control',
                        'placeholder'=>'Enter Name',
                    ],
            'value' => function ($data) {
                // return $data['FirstName'].' '.$data['LastName'];
                return Html::a(Html::encode($data['FirstName'] . '' . $data['LastName']), 'view?id=' . $data['MemberID']);
            },
            'format' => 'html',
        ],
        [
            'attribute' => 'Email',
            'value' => function ($data) {
                return $data['Email'];
            },
            'format' => 'html',
            'filter' => false,
        ],
        //'Email:email',
        /* [
          'header' => 'Gender',
          'attribute' => 'Gender',
          ], */
        // 'ProfileThumb',
        // 'Email:email',
        // 'Password:ntext',
        // 'MobileNo',
        // 'DOB',
        //'Gender',
        [
            'header' => 'Gender',
            'attribute' => 'Gender',
            'filter' => Html::activeDropDownList($model, 'Gender', array("" => "All", "1" => "Male", "2" => "Female", "3" => "Not Specified"), ['class' => 'form-control', 'options' => [ "" => ['selected ' => true]]]),
        ],
        'Age',
        //  'SignupType',
        [
            'header' => 'Registered Plt',
            'attribute' => 'SignupType',
            'filter' => Html::activeDropDownList($model, 'SignupType', array("" => "All", "1" => "Website", "2" => "Facebook", "3" => "Google"), ['class' => 'form-control', 'options' => [ "" => ['selected ' => true]]]),
        ],
    // 'DeviceType',
    // 'DeviceToken',
    // 'SignupType',
    // 'Status',
    // 'UserID',
    // 'ActivationCode',
    // 'ActivatedOn',
    // 'Created',
    // 'Updated',
    // 'CreatedBy',
    // 'UpdatedBy',
    //  ['class' => 'yii\grid\ActionColumn'],
    ],
]);
?>

</div>
<script>
 function setEnableupload(){
  //  alert("hello"); return false;
  $("#spinnerLoader").show();
  var fromdate= $('#subscribervideosetting-fromdate').val();
  var todate = $('#subscribervideosetting-todate').val();
  
   if (fromdate == '') {
            $("#formdateerror").html('Please Select From Date');
            $("#spinnerLoader").hide();
            return false;
        } else {
           $("#formdateerror").html('');
            
        }
     if (todate == '') {
            $("#todateerror").html('Please Select To Date');
            $("#spinnerLoader").hide();
            return false;
        } else {
            $("#todateerror").html('');
           
        }
  
     var type='';
     var datastring = 'FromDate='+fromdate+'&ToDate='+todate;
         $.ajax({
                type: 'POST',
                url: 'setvideouploadenable',
                data: datastring,
                success: function (msg) {
                        //alert(msg);return false;
                        if(msg=='success'){
                                $("#spinnerLoader").hide();
                                window.location.href = '<?php echo Url::to(['/member/index']) ?>' ;
                            }else{
                                    $("#spinnerLoader").hide();
                                  window.location.href = '<?php echo Url::to(['/member/index']) ?>' ;
                                 }
                             }
                        });
		    
    
}
</script>
