  <?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;
use dosamigos\datepicker\DatePicker;
//use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $this yii\web\View */
$this->title =Yii::t('frontend','myprofile');
$this->params['breadcrumbs'][] = $this->title;

//echo "<pre>"; print_r($videolistdetails);die;
?> 
<?php  $this->registerJs("
           
    ");?>
<div class="col-md-10 single-page">
      <div class="col-md-3 tab-menu">
      <div id="togglebtn"> Profile</div>
      <!--  <ul class="left-menu">
          <li> <a href="<?php //echo Url::toRoute(['member/mywatchlist'])?> "> <i class="my-wathc-list"></i> <span>My watchlist</span></a> </li>
          <li> <a href="<?php //echo Url::toRoute(['member/myfavourite'])?> "> <i class="my-favorites"></i> <span>My favorites</span></a> </li>
          <li> <a href="<?php //echo Url::toRoute(['member/myvideo'])?>"> <i class="my-videos"></i> <span>My videos</span></a> </li>
          <li class="active"> <a href="#"> <i class="profile"></i><span>Profile information</span></a></li>
          <li> <a href="<?php //echo Url::toRoute(['member/changepassword'])?>"> <i class="glyphicon glyphicon-cog" style="font-size: 25px;"></i> <span>Change Password</span></a> </li>
        </ul>-->
        <?php include('menu.php');?>
      </div>
      <div class="col-md-9 tab-content">
        <div class="tab-content">
          <div id="profile" class="tab-pane fade in active">
            <h3><?php echo Yii::t('frontend','editmyprofile'); ?></h3>
           <?php
        $form = ActiveForm::begin();
        ?>
              <div class="form-group">
 
                 <?php echo $form->field($model, 'FirstName')->textInput(['maxlength' => true])->label(Yii::t('frontend','firstname')) ?>
              </div>
              <div class="form-group">
             
                <?php echo $form->field($model, 'LastName')->textInput(['maxlength' => true])->label(Yii::t('frontend','lastname')) ?>
              </div>
              <div class="form-group">
           
                <?php echo $form->field($model, 'Email')->textInput(['maxlength' => true,'readonly' => true])->label(Yii::t('frontend','emailid')) ?>
              </div>
            
            <div class="form-inline">
                   <?php if($model->DOB == "0000-00-00"){
                       $model->DOB = "";
                   }; ?> 
                            <?= $form->field($model, 'DOB')->widget(
                   DatePicker::className(), [
                       // inline too, not bad 
                       'clientOptions' => [
                           'autoclose' => true,
                          //'format' => 'dd-mm-yyyy'
                         'format' => 'yyyy-mm-dd',
                         'endDate' => date('Y-m-d'),
						 
                       ]
               ])->error(false);?>

              </div>
             
             <div class="form-group">
                  <?= $form->field($model, 'Gender')->radioList(array('1'=>Yii::t('frontend','male'),2=>Yii::t('frontend','female'))); ?>

              </div>
            <!--  <div class="change-pass">
                  <a href="<?php //echo Url::toRoute(['member/changepassword']) ?>">  <h3>Change Password</h3></a>
                <div class="form-group" style="clear:both;">
                  <input type="password" class="form-control" id="exampleInputPassword1" name="oldpassword" placeholder="Old Password" >
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="exampleInputPassword1" name="newpassword"  placeholder="New Password" >
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="confirmpass" name="cnewpassword" placeholder="Confirm password" >
                </div>
              </div>-->
              <div class="submit-wrap">
                <input type="submit" class="btn btn-default" value="<?php echo Yii::t('frontend','savechanges');?>">
              </div>
              <?php ActiveForm::end(); ?>
          </div>
          <!---My Profile end--->
        </div>
      </div>
    </div>
