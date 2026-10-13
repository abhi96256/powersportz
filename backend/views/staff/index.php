<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="member-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php 

        $Designation = \backend\models\Member::getDesignation('2');
        $Designation['0'] = 'All';
        ksort($Designation);
       // print_r($Designation);die;
    ?>
    <?php \yii\widgets\Pjax::begin(
            ['id' => 'StaffList', 'timeout' => false, 'enablePushState' => true, 'clientOptions' => ['method' => 'GET']]
        ); ?>
    <?= GridView::widget([
        /*'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,*/
         'dataProvider' => $searchModel->search(),        
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}{summary}",
        'columns' => [
            [
                'attribute'=>'FirstName',
                'value' => function($data) {
                    $url = Url::toRoute('staff/update?id='.$data['MemberID']);
                    return Html::a($data['FirstName'],$url,['data-pjax'=>"0"]);
                },
                'format'=>'raw',        
            ],
            'LastName',
            [
                'attribute'=>'Designation',
              //  'name'=>'Designation',
                'attribute'=>'Designation',
                'value' => function($data) {
                    if(isset($data['Designation']) && $data['Designation']!='') {
                        $all = \backend\models\Member::getDesignation();
                        return !empty($all[$data['Designation']])? $all[$data['Designation']] : '-';
                    }    
                },
               'filter'=>Html::activeDropDownList($searchModel, 'Designation',$Designation,['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
            ],
             [
                'header' => 'Status',
                'attribute' => 'Status',
                'value' => function($data) {
                        if($data['Status'] == 1){
                            return 'Active';
                        }else if ($data['Status'] == 2) {
                            return 'Inactive';
                        }else{
                            return 'Pending';
                        }
                   //     return \backend\models\Video::GetVideoCategory($data['ID']);
                 },
                'filter'=>Html::activeDropDownList($searchModel, 'Status',array(""=>"All","1"=>"Active","2"=>"Inactive"),['class'=>'form-control','options' => [ "" => ['selected ' => true]]]),
            ], 
        ],
        
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
