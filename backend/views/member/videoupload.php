<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Members';
//$this->params['breadcrumbs'][] = $this->title;
$this->title = 'Likes';
$this->params['breadcrumbs'][] = $this->title;
$id = $_GET['id'];
if (isset($id) && $id != '') {
    include 'tabs.php';
}
?>

 <div class="clearfix">&nbsp;</div>
<div class="member-index">
    

    

    <?= GridView::widget([
        'dataProvider' => $model->uploadvideo(),
        'filterModel' => $model,
        'columns' => [
           
           
              
             [
                'header' => '',
                //'attribute' => 'ImageName',
                'value' => function ($data) {
                       // return $data['FirstName'].' '.$data['LastName'];
                          // return Html::a(Html::encode($data['FirstName'].''.$data['LastName']),'view?id='.$data['MemberID']);
                          //  return '<img class="thumbnail img-responsive" src="' . S3_VIDEO_BUCKETABSOLUTE_PATH . $data['ImageName'] . '" width="100" height="100">';
                           if($data['ImageName']!=''){
                                return '<img class="thumbnail img-responsive" src="' .ImagesUrl($data)/* S3_VIDEO_BUCKETABSOLUTE_PATH . $data['ImageName'] */. '" width="100" height="100">';
                           }else{
                               return  Html::img('@web/images/thumbnail-default.jpg',['width'=>'100'], ['class' => 'thumbnail img-responsive']);
                                 }
                 },
                'format' => 'html',    
            ],
            
             [
                'header' => 'Title',
               // 'attribute' => 'Title',
                'value' => function ($data) {
                       // return $data['FirstName'].' '.$data['LastName'];
                          return $data['VideoTitle'];
                },
                'format' => 'html',    
            ],
                        
             [
              
                'value' => function ($data) {
                       
                        if($data["ApproveStatus"]=='1'){
                            //pending
                          //$button = '<button class="btn btn-success" type="button" onclick="getProcess(' . $data["ID"] . ',' . $data["MemberID"] . ')" >Process</button>';
                          $button = '<a href='.Url::to(['/video/create?svid='.$data["ID"]]).' class="btn btn-primary" type="button"  >Process</a>';
                  
						 $button2 = '<button class="btn btn-danger" type="button" onclick="getReject(' . $data["ID"] . ',' . $data["MemberID"] . ')" >Reject</button>';
                          //$button3 =  '<button class="btn btn-primary" type="button" onclick="getDownload(' . $data["ID"] . ')" >Download</button>';
                           $button3= '<a href='.Url::to(['/member/downloadvideo?pid='.$data["ID"].'&status='.$data["ApproveStatus"].'&id='.$_GET["id"]]).' class="btn btn-primary" type="button"  >Download</a>';
                            
                          return $button . " " . $button2. " " . $button3;
                            
                        }else if($data["ApproveStatus"]=='2'){
                             //published
                              $button = '<label class="btn btn-success" >Published</label>';
                              //$button2 = '<button class="btn btn-primary" type="button" onclick="getDownload(' . $data["ID"] . ')" >Download</button>';
                              $button2 = '<a href='.Url::to(['/member/downloadvideo?pid='.$data["ID"].'&status='.$data["ApproveStatus"].'&id='.$_GET["id"]]).' class="btn btn-primary" type="button"  >Download</a>';
                              return $button . " " . $button2;
                            
                        }else if($data["ApproveStatus"]=='3'){
                             //Rejected
                            $button =  '<label class="btn btn-danger" >Rejected</label>';
                           // $button2 =  '<button class="btn btn-primary" type="button" onclick="getDownload(' . $data["ID"] . ')" >Download</button>';
                            $button2 = '<a href='.Url::to(['/member/downloadvideo?pid='.$data["ID"].'&status='.$data["ApproveStatus"].'&id='.$_GET["id"]]).' class="btn btn-primary" type="button"  >Download</a>';
                            
                             return $button . " " . $button2;
                        }
       
                        
                        
               
                },
                'format' => 'raw',    
            ],           
          /* [
               'attribute' => 'Email',
                'value' => function ($data) {
                        return $data['Email'];
                },
                'format' => 'html',    
                 'filter'=>false,      
            ],
           
             [
                'header' => 'Gender',
                'attribute' => 'Gender',
                'filter'=>Html::activeDropDownList($model, 'Gender',array(""=>"All","1"=>"Male","2"=>"Female","3"=>"Not Specified"),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
            ],           
              'Age',
          
            [
                'header' => 'Registered Pit',
                'attribute' => 'SignupType',
                'filter'=>Html::activeDropDownList($model, 'SignupType',array(""=>"All","1"=>"Website","2"=>"Facebook","3"=>"Google"),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
            ],
            
            */
          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<script>
   function getProcess(id,memberid) {
      $("#spinnerLoader").show();
      var videoid = id;
      var mid = memberid;
      var datastring  = 'SID='+videoid+'&MemberID='+mid;
      	$.ajax({
               type : 'POST',
               url  :  '<?php echo Url::to(['/member/uploadvideoprocess']); ?>',
               data : datastring,
                success : function(msg) {
                            location.reload();
                             $("#spinnerLoader").hide();
                           }
          });
   }
         
   function getReject(id,memberid) {
     $("#spinnerLoader").show();
            var videoid = id;
            var mid = memberid;
            var datastring  = 'SID='+videoid+'&MemberID='+mid;
            	$.ajax({
                     type : 'POST',
                     url  :  '<?php echo Url::to(['/member/uploadvideoreject']); ?>',
                     data : datastring,
                      success : function(msg) {
                            
                                  location.reload();
                                  $("#spinnerLoader").hide();
                                 }
                });
         }
 </script>
