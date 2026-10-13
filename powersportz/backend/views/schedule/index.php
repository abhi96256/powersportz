<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-index video-form">

    <h1><?php echo "Schedule"; ?></h1>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group pull-right">
                <?= Html::a('Add Schedule', ['/schedule/create'], ['class' => 'btn btn-success']) ?>
            </div>
            <div class="form-group pull-left">
                <?= Html::a('Reset', ['/schedule/index'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'ProgramTitle',
                'format' => 'html',
                'value' =>function($data){
                    return Html::a(Html::encode($data['ProgramTitle']),['update','id'=>$data['ScheduleID']]);
                }
                
            ],
            [
                'header' => 'From Data & Time' ,
                'attribute'=>'ScheduleFromTime',
                'value'=>function($data){
                    return   ConvertDateTolocaltime($data['ScheduleFromTime'],'d M Y h:i A');
                },
                'filter' => DatePicker::widget([
                    'attribute' => 'ScheduleFromTime',
                    'model' => $searchModel,     
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose' => true, 
                    ]
                ]),
                'filterInputOptions' => [
                    'class' => 'form-control',
                ],
            ],
            [
                'header' => 'To Date & Time',
                'attribute'=>'ScheduleTime',
                'value'=>function($data){
                    return  ConvertDateTolocaltime($data['ScheduleTime'],'d M Y h:i A');
                },
                'filter' => DatePicker::widget([
                    'attribute' => 'ScheduleTime',
                    'model' => $searchModel,     
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'autoclose' => true, 
                    ]
                ]),
                'filterInputOptions' => [
                 'class' => 'form-control',
             ],
         ],
         [ 
          'class' => \yii\grid\ActionColumn::className(),
          'template'=>'{delete}',
          'buttons'=>[
            'delete'=>function($url,$model){
                return Html::a('<span class="glyphicon glyphicon-trash"></span>',['schedule/delete','id'=>$model['ScheduleID']],[
                    'title'=>"Delete",
                    'aria-label'=>"Delete",
                    'data-confirm'=>"Are you sure you want to delete this item?",
                    'data-method'=>"post",
                    'data-pjax'=>"0"
                ]);
            }
        ]
    ],
    // [

    //     'value' => function ($data) {

    //         return '<button class="btn btn-danger" type="button" onclick="getDelete(' . $data["ScheduleID"] . ')" >Delete</button>';
    //     },
    //     'format' => 'raw',
    // ],
]
]);
?>
</div>

<script>
    function getDelete(id) {
        $("#spinnerLoader").show();
        var r = confirm("Are you sure you want to delete schedule video?");
        if (r == true)
        {
            var scheduleid = id;
            var sceduledate = $('#schedulesearch-scheduledate').val();
            var datastring = 'scheduleid=' + scheduleid + '&sceduledate=' + sceduledate;
            $.ajax({
                type: 'POST',
                url: '<?php echo Url::to(['/schedule/scheduledelete']); ?>',
                data: datastring,
                success: function (msg) {

                    location.reload();
                    $("#spinnerLoader").hide();
                }
            });
        } else
        {
            location.reload();
            $("#spinnerLoader").hide();
        }
    }
</script>
