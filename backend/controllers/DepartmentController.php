<?php

namespace backend\controllers;

use Yii;
use backend\models\Department;
use backend\models\DepartmentSearch;
use backend\models\UserRole;
use backend\models\UserRoleSearch;
use backend\components\BackendController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UserRules;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

class DepartmentController extends \backend\components\BackendController
{

    public function actionIndex()
    {
        $searchModel = new \backend\models\DepartmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }
    
    public function actionCreate()
    {
        $model = new Department();
        $model->parent_id = 2;
        $model->child_id = 0;
        if($model->load(Yii::$app->request->post()) ){
            $model->role_name = $model->role_name;
            $model->save();
            Yii::$app->session->setFlash('success', 'Department has been added successfully');
            return $this->redirect(['index']);
        }else {
            //$controllers = UserRole::ControllerAction();
            return $this->render('create',['model' => $model]) ;
        }
    }
    
    public function actionUpdate($id)
    {
        $model = new Department();
        $model= $model->findOne($id);
        $procedure = "select *from `user_role` where id = :id";
        $connection = Yii::$app->db;
        $command = $connection->createCommand($procedure);
        $command->bindParam(':id', $id);
        $resultSet = $command->query();	
        $Departmentdata= $resultSet->readAll();
        $model->role_name =  $Departmentdata[0]['role_name'];
        
        if($model->load(Yii::$app->request->post()) ){
            $model->role_name = $model->role_name;
            $model->save();
            Yii::$app->session->setFlash('success', 'Department has been updated successfully');
            return $this->redirect(['index']);
        } else {
            //$controllers = UserRole::ControllerAction();
            return $this->render('update', ['model' => $model]);
        }
    }
}    