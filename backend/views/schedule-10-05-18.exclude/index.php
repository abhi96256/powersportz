<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-index">

    <h1><?php echo "Schedule"; ?></h1>
    <?php echo $this->render('_search', ['model' => $model]); ?>


    <?=
    GridView::widget([
        'dataProvider' => $model->search(),
        'filterModel' => $model,
        'layout' => "{items}\n{pager}{summary}",
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'header' => 'Program Title',
                'attribute' => 'ProgramTitle',
                'value' => function ($data) {
                    //return $data['ProgramTitle'];
                    return Html::a(Html::encode($data['ProgramTitle']), 'update?id=' . $data['ScheduleID']);
                },
                'format' => 'html',
                'filter' => false,
            ],
            /* [
              'header' => 'Video Title',
              'attribute' => 'Title',
              'value' => function ($data) {
              return $data['Title'];
              },
              'format' => 'html',
              'filter'=>false,
              ], */
            [
                'header' => 'Schedule From',
                'attribute' => 'ScheduleFromTime',
                'value' => function ($data) {
                    // return date("g:i a", strtotime($data['ScheduleTime'])); 
                    $date = $data['ScheduleDate'];
                    $time = date("H:i:s", strtotime($data['ScheduleFromTime']));
                    $sdatetime = $date . ' ' . $time;
                   return $date.' '.explode(' ',ConvertDateTolocaltime($sdatetime))[1];
                },
                'format' => 'html',
                'filter' => false,
            ],
            [
                'header' => 'Schedule To',
                'attribute' => 'ScheduleTime',
                'value' => function ($data) {
                    // return date("g:i a", strtotime($data['ScheduleTime'])); 
                    $date = $data['ScheduleDate'];
                    $time = date("H:i:s", strtotime($data['ScheduleTime']));
                    $sdatetime = $date . ' ' . $time;
                   // return $convertlocaldatetime = ConvertDateTolocaltime($sdatetime);
                    return $date.' '.explode(' ',ConvertDateTolocaltime($sdatetime))[1];
                },
                'format' => 'html',
                'filter' => false,
            ],
            [

                'value' => function ($data) {

                    return '<button class="btn btn-danger" type="button" onclick="getDelete(' . $data["ScheduleID"] . ')" >Delete</button>';
                },
                'format' => 'raw',
            ],
        //'ScheduleID',
        // 'VideoID',
        // 'ProgramTitle',
        // 'ScheduleDate',
        // 'ScheduleTime',
        // 'Status',
        // ['class' => 'yii\grid\ActionColumn'],
        ],
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
