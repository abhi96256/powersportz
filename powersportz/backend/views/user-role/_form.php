<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model backend\models\UserRole */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl.'/css/multiselect.css'; ?>">

<?php 
 $this->registerJsFile("http://www.jqueryscript.net/demo/jQuery-Plugin-For-Multi-Select-Checboxes-multiselect/js/jquery.multiselect.js",['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);
 $this->registerJsFile(Yii::$app->request->baseUrl.'/js/user_role.js',['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ]]);
?>
<div class="user-role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true])->label(false); ?>
    <?php /*if($model->isNewRecord){ ?>
		<?= $form->field($model, 'parent_id')->dropDownList(\backend\models\UserRole::getHeadRole(),['prompt'=>'Select User Type']); ?>
    <?php }else{ */ ?>
    	<?= $form->field($model, 'parent_id')->hiddenInput([])->label(false); ?>
    	<?= $form->field($model, 'child_id')->hiddenInput(['id'=>'hiden_child_id_input'])->label(false); ?>
    <?php // } ?>
    <?= $form->field($model, 'role_name')->textInput(['maxlength' => true]); ?>
    
	<?= $form->field($model, 'child_id')->widget(DepDrop::classname(), [
         	//'type' => DepDrop::TYPE_SELECT2,
		   // 'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions' => [
             	'initialize' => true,
                'depends' => ['userrole-parent_id'],
                'placeholder' => 'Select...',
                'url' => Yii::$app->urlManager->createUrl(['user-role/child-list']),
                'params'=>['userrole-id','hiden_child_id_input']
            ]
        ]); ?>
    <?php /*$form->field($model, 'status')->textInput(['maxlength' => true]) ?>

  

    <?php ActiveForm::end(); */ ?>
	<label> Modules</label>
 		<select id="users_list" class="form-control" size="30" multiple="multiple">

			<?php 
				foreach ($controllers as $controller_name => $actionArr) { 
                                    $controller_name = str_replace("Controller"," ",$controller_name);?>
			     	<optgroup label="<?= $controller_name; ?>">
						<?php foreach ($actionArr['not_selected'] as $key => $value) {  ?>
							  <?php $action_name = strtolower(preg_replace('/([a-z0-9])(?=[A-Z])/','$1-$2',str_replace("action", "", $value)));?>
							  <?php  
							  		$option_html = "<option value=".$controller_name.'@'.$action_name;
							  		if(!empty($selected[$controller_name])){
							  			//print_r($selected[$controller_name]);
							  			//$selected = in_array($action_name, $selected[$controller_name]) ? true : false; 
							  			$option_html .= in_array($action_name, $selected[$controller_name]) ? " selected " : "";
							  		}
                                                                         if($action_name == 'index'){
                                                                            $action_name = 'List';
                                                                        }
                                                                        else if($action_name == 'create'){
                                                                            $action_name = 'Add';
                                                                        }
                                                                        else if($action_name == 'update'){
                                                                             $action_name = 'Edit';
                                                                        }
                                                                        else if($action_name == 'delete'){
                                                                             $action_name = 'Delete';
                                                                        }
                                                                        else if($action_name == 'view'){
                                                                             $action_name = 'View';
                                                                        }
                                                                        
							  		$option_html .= ">".$action_name."</option>";
							  		echo $option_html;
							  ?>
						<?php }  ?>
					</optgroup>
			<?php } ?>

			 </select> 

		  <div class="form-group">
  	        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
		<?php ActiveForm::end(); ?>
		<!-- <div class="col-xs-2">
			    <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
			    <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
			    <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
			    <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
		</div>
		<div class="col-xs-5">
		    <select name="to" id="multiselect_to" class="form-control" size="8" multiple="multiple">
		    </select>
		</div> -->
   <!--  <div class="row">
		  <div class="col-xs-5">
		    <select name="from" id="multiselect" class="form-control" size="8" multiple="multiple">
		      <option value="1">C++</option>
		      <option value="2">C#</option>
		      <option value="3">Haskell</option>
		      <option value="4">Java</option>
		      <option value="5">JavaScript</option>
		      <option value="6">Lisp</option>
		      <option value="7">Lua</option>
		      <option value="8">MATLAB</option>
		      <option value="9">NewLISP</option>
		      <option value="10">PHP</option>
		      <option value="11">Perl</option>
		      <option value="12">SQL</option>
		      <option value="13">Unix shell</option>
		    </select>
		  </div>
			  <div class="col-xs-2">
			    <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
			    <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
			    <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
			    <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
			  </div>
			  <div class="col-xs-5">
			    <select name="to" id="multiselect_to" class="form-control" size="8" multiple="multiple">
			    </select>
			  </div>
		</div>
 -->
</div>
