<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
//use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\videoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subscriber Uploded Video List';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/common.js',['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/video.js', ['depends' => [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ]]); 
?>
<style type="text/css">
    .btn.btn-success {
    padding: 8px 18px;
    border-radius: 0;
    width: 120px;
    font-size: 10px;
    background: #0b7ef4;
    border: none;
    text-transform: uppercase;
    margin: 0;
    float: left;
    margin-right: 9px !important;
    align-items: center;
    text-align: center;
    margin: 37px auto 0;
}

.btn.btn-success {
    width: auto;
}
</style>
<div class="video-index video-subscriber-video">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <span class="notification_count"><b>Subscriber has <?php echo \backend\models\Videouploadbysubscribers::find()->where(["DATE_FORMAT(created,'%y-%m-%d')"=>date("y-m-d")])->count(); ?> new video uploded today.</b></span>
    <h2><?php  //var_dump($dataProvider); ?></h2>

    <?php /*\yii\widgets\Pjax::begin(
            ['id' => 'VideoList', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]
        );*/ ?>
    <?= GridView::widget([
        'dataProvider' => $model->uploadvideo(),
        'filterModel' => $model,
        'layout'=>"{items}\n{pager}{summary}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header' => 'Thumbnail',
                'value' => function ($data) {
                           if($data['ImageName']!=''){
                                return '<img  src="' . ImagesUrl($data). '" width="100px" height="100px">';
                           }else{
                               return  Html::img('@web/images/thumbnail-default.jpg',['width'=>'100px'], ['class' => 'thumbnail img-responsive']);
                                 }
                 },
                'format' => 'html',    
            ],
            [
                'header' => 'Video Title',
                'filterInputOptions' => [
                        'class'=>'form-control',
                        'placeholder'=>'Video Title',
                ],
                'attribute'=>'video_title',
                'value' => function ($data) {
                          return $data['VideoTitle'];
                },
                'format' => 'html',    
                'filter'=>true,
            ],
            [
                    'header'=>'Uploded Date',
                    'attribute'=>'Created',
                    'value'=>function($data){
                        return $data['uploded_date']!= '0000-00-00 00:00:00'?ConvertDateTolocaltime($data['uploded_date'],"d M Y h:i A"):'';
                    },
                    'filter'=>false,
            ],
            [
                    'header'=>'Published Date',
                    'attribute'=>'PublishDate',
                    'value' => function($data) {
                        return (!empty($data['PublishDate'])) ? ConvertDateTolocaltime($data['PublishDate'],'d M Y h:i A') : "";
                       // return $data['PublishDate'];
                    },
                    'format'=>'raw',  
                    'filter' => false,
            ],
            /*[
                    'header'=>'Category',
                    'value' => function($data) {
                        return \backend\models\Video::GetVideoCategory($data['ID']);
                    },
                    'format'=>'html',  
                    'filter' => false,
            ],*/
            [
                    'header'=>'Author',
                    'attribute'=>'FirstName',
                    'filterInputOptions' => [
                        'class'=>'form-control',
                        'placeholder'=>'Enter Author',
                    ],
                    'value' => function($data) {
                        //echo '<pre>';
                        //print_r($data);
                        //die;
                        return $data['Author_name'];
                    },
                    'format'=>'html',  
            ],
            [
                'header' => 'Status',
                'attribute' => 'Status',
                'filter'=>Html::activeDropDownList($model, 'Status',array(""=>"All","1"=>"Pending Process","4"=>"Pending Approval",'3'=>'Rejected','2'=>'Processed'),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
            ],
            [
              'value' => function ($data) {
                        // $button = '<a href='.Url::to(['/video/create?svid='.$data["ID"]]).' class="btn btn-primary" type="button"  >Process</a>';
                        // $button2 = '<button class="btn btn-danger" type="button" onclick="getReject(' . $data["ID"] . ',' . $data["MemberID"] . ')" >Reject</button>';
                        $button='';
                        $button2='';
                        if($data["ApproveStatus"] == '1' ){
                              $button = '<button class="btn btn-success process" '.($data["ApproveStatus"] != '1'?'disabled':'').' type="button" style="color: #fff;background-color: #398439;border-color: #255625;" onclick="location.href=\''.Url::to(['/video/create?svid='.$data["ID"]]).'\'" >Process</button>';                            
                              $button2 = '<button class="btn btn-success reject" '.($data["ApproveStatus"] != '1'?'disabled':'').' type="button" style="background:#CC0000;" onclick="getReject(' . $data["ID"] . ',' . $data["MemberID"] . ')" >Reject</button>';
                        }
                         $button3= '<button onclick="location.href =\''.Url::to(['/member/downloadvideo?pid='.$data["ID"].'&status='.$data["ApproveStatus"].'&id='.$data["MemberID"]]).'\'" class="btn btn-success download" type="button" style="color: #fff;background-color: #5bc0de;border-color: #46b8da;" "data-pjax"="0" >Download</button>';
                         //$url = Url::toRoute('member/downloadvideo?pid='.$data["ID"].'&status='.$data["ApproveStatus"].'&id='.$data["MemberID"]);
                         //return Html::a($data['MemberName'],$url,['data-pjax'=>"0",'class'=>'btn btn-primary']);
                         return $button . " " . $button2. " " . $button3;
              },
              'format' => 'raw',    
            ],           
        ],
    ]); ?>
    <?php //\yii\widgets\Pjax::end(); ?>
</div>
