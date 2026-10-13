<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Member */

$this->title = $model->MemberID;
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
include 'tabs.php';
?>
<div class="member-view">
    <?php

     function getBdateCalculation($bdate) {
        if($bdate!= '0000-00-00' ){
        $result = date_diff(date_create($bdate), date_create('today'))->y;
        }else{
            $result='-';
        }
        return $result;
    }
    ?>
   <!-- <h2><?= Html::encode('Subscriber Detail') ?></h2>-->

   <!-- <p>
    <?= Html::a('Update', ['update', 'id' => $model->MemberID], ['class' => 'btn btn-primary']) ?>
    <?=
    Html::a('Delete', ['delete', 'id' => $model->MemberID], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ])
    ?>
      
    </p>-->
<?php //echo "<pre>"; print_r($model['Email']);die; ?>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'MemberID',
            [
                'label' => 'Name',
                'attribute' => 'FirstName',
                'value' => $model->FirstName . ' ' . $model->LastName,
            ],
			
			[
                'label' => 'Email',
                'attribute' => 'Email',
                'value' => $model->getAttribute('Email'),
			   // 'value'  => Lookup::item("Email", $model->Email),
				//'filter' => Lookup::items('Email'),
            ],
            
            [
                'label' => 'Registered Platform',
                'attribute' => 'SignupType',
                // 'value' => $model->SignupType,
                'value' => $model->getSignupType($model['SignupType']),
            // 'format' => 'html',     
            ],
            [
                'label' => 'Gender',
                'attribute' => 'Gender',
                'value' => $model->getGender($model['Gender']),
           
            // 'format' => 'html',     
            ],
            [
                'label' => 'Age',
                'attribute' => 'DOB',
                'value' => getBdateCalculation($model->DOB),
            // 'format' => 'html',     
            ],
             [
                'label' => 'Interest',
                'attribute' => 'Interest',
                'value' => $model->getIntersest($model['Interest']),
           
            // 'format' => 'html',     
            ],
             [
                'label' => 'Occupation',
                'attribute' => 'Occupation',
                'value' => $model->getOccupation($model['Occupation']),
           
            // 'format' => 'html',     
            ],
        //'FirstName',
        // 'LastName',
        /*
          'Email:email',
          'Password:ntext',
          'MobileNo',
          'DOB',
          'Gender',
          'DeviceType',
          'DeviceToken',
          'SignupType',
          'Status',
          'UserID',
          'ActivationCode',
          'ActivatedOn',
          'Created',
          'Updated',
          'CreatedBy',
          'UpdatedBy', */
        ],
    ])
    ?>

</div>
