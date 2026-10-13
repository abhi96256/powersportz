<?php

namespace backend\controllers;

use Yii;
use backend\models\UserRole;
use backend\models\UserRoleSearch;
use backend\components\BackendController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UserRules;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

/**
 * UserRoleController implements the CRUD actions for UserRole model.
 */
class UserRoleController extends \backend\components\BackendController
{
   /* public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }*/


    /**
     * Lists all UserRole models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserRoleSearch();
        $arr['UserRoleSearch']['parent_id'] = '2';
        $arr = array_merge($arr,Yii::$app->request->queryParams);
        //print_r(Yii::$app->request->queryParams);die;
        $dataProvider = $searchModel->search(array_merge($arr,Yii::$app->request->queryParams));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserRole model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserRole();
        
        $selected = [];
        $model->parent_id = 2;
        if($model->load(Yii::$app->request->post()) && $model->save()){
            
//            $model->parent_id = (!empty($model->parent_id)) ? $model->parent_id : 0;
            $model->child_id = (!empty($model->child_id)) ? $model->child_id : 0;

            /*$ParentUserRulesModel = UserRules::find()->where(["role_id"=>$model->parent_id])->asArray()->One();
            if(!empty($ParentUserRulesModel)){
                //$model->child_id = ($ParentUserRulesModel['child_id'] == 0) ? $ParentUserRulesModel['id'] : $ParentUserRulesModel['child_id'];
                $model->child_id = $ParentUserRulesModel['parent_id'];
            }else{
                $model->child_id = $model->parent_id;
            }*/
            $model->save();
            if(!empty(Yii::$app->request->post('users_list'))){
               $this->AddOrRemoveRole(Yii::$app->request->post('users_list'),$model->id,$selected);
            }

            Yii::$app->session->setFlash('success', 'Staff role has been added successfully');
            return $this->redirect(['index']);
        }else {
            $controllers = UserRole::ControllerAction();
            return $this->render('create', compact('model','controllers','selected'));
        }

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
    }

    /**
     * Updates an existing UserRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
    */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        $userRulesModel = new UserRules;
        $userRulesModel = UserRules::find()->where(["role_id"=>$id])->asArray()->all();
        $model->parent_id = 2;
        //print_r($this->getAppRoutes());die;
        
        $selected = [];
        array_walk($userRulesModel, function($arr) use(&$selected){
            $selected[$arr['controller_name']]= explode(",", $arr['action_name']);
        });
        //$userruleModel = UserRules::find()->where(['role_id'=>$id])->all()->asArray();
        if($model->load(Yii::$app->request->post()) && $model->save()){

            $model->parent_id = (!empty($model->parent_id)) ? $model->parent_id : 0;
            $model->child_id = (!empty($model->child_id)) ? $model->child_id : 0;
            
            /*$ParentUserRulesModel = UserRole::find()->where(["id"=>$model->parent_id])->asArray()->One();
            if(!empty($ParentUserRulesModel)){
                //$model->child_id = ($ParentUserRulesModel['child_id'] == 0) ? $ParentUserRulesModel['parent_id'] : $ParentUserRulesModel['child_id'];
                $model->child_id = $ParentUserRulesModel['parent_id'];
            }else{
                $model->child_id = $model->parent_id;
            }*/
           // print_r($model->child_id);die;
            $model->save();
            if(!empty(Yii::$app->request->post('users_list'))){
               $this->AddOrRemoveRole(Yii::$app->request->post('users_list'),$model->id,$selected);
            }
            Yii::$app->session->setFlash('success', 'Staff role has been updated successfully');
            return $this->redirect(['index']);
        } else {
            $controllers = UserRole::ControllerAction();
            return $this->render('update', compact('model','controllers','selected'));
        }
    }
    public function AddOrRemoveRole($post,$id,$selected){
        $controller_ListArr = [];
         array_walk($post, function($arr) use(&$controller_ListArr) {
            $controller_name = strchr($arr,"@",true);
            $action_name = str_replace("@","",strchr($arr,"@",false));
            $controller_ListArr[$controller_name][] = $action_name;
            return $controller_ListArr;
        });
        $removeController = array_diff(array_keys($selected), array_keys($controller_ListArr));
        UserRules::deleteAll(['role_id'=>$id,'controller_name'=>$removeController]);
        foreach ($controller_ListArr as $key => $value) {
             if(($updatemodel = UserRules::findOne(['role_id'=>$id,'controller_name'=>$key])) === null){
                $updatemodel = new UserRules;
             }
            $updatemodel->role_id = $id;
            $updatemodel->controller_name = $key;
            $updatemodel->action_name = implode(",", $value);
            $updatemodel->save(false);
        }
    }

    /**
     * Deletes an existing UserRole model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserRole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     /**
     * Get list of application routes
     * @return array
     */
    public function getAppRoutes()
    {
        $key = __METHOD__;
       /* $cache = Configs::instance()->cache;
        if ($cache === null || ($result = $cache->get($key)) === false) {
            $result = [];*/
            echo "<pre>";
            $this->getRouteRecrusive(Yii::$app, $result);
print_r($result);die;
            /*if ($cache !== null) {
                $cache->set($key, $result, Configs::instance()->cacheDuration, new TagDependency([
                    'tags' => self::CACHE_TAG
                ]));
            }*/
       /* }*/

        return $result;
    }

    /**
     * Get route(s) recrusive
     * @param \yii\base\Module $module
     * @param array $result
     */
    private function getRouteRecrusive($module, &$result)
    {
        $token = "Get Route of '" . get_class($module) . "' with id '" . $module->uniqueId . "'";
        Yii::beginProfile($token, __METHOD__);
        try {
            foreach ($module->getModules() as $id => $child) {
                if (($child = $module->getModule($id)) !== null) {
                    $this->getRouteRecrusive($child, $result);
                }
            }

            foreach ($module->controllerMap as $id => $type) {
                $this->getControllerActions($type, $id, $module, $result);
            }

            $namespace = trim($module->controllerNamespace, '\\') . '\\';
            $this->getControllerFiles($module, $namespace, '', $result);
            $result[] = ($module->uniqueId === '' ? '' : '/' . $module->uniqueId) . '/*';
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get list controller under module
     * @param \yii\base\Module $module
     * @param string $namespace
     * @param string $prefix
     * @param mixed $result
     * @return mixed
     */
    private function getControllerFiles($module, $namespace, $prefix, &$result)
    {
        $path = @Yii::getAlias('@' . str_replace('\\', '/', $namespace));
        $token = "Get controllers from '$path'";
        Yii::beginProfile($token, __METHOD__);
        try {
            if (!is_dir($path)) {
                return;
            }
            foreach (scandir($path) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($path . '/' . $file)) {
                    $this->getControllerFiles($module, $namespace . $file . '\\', $prefix . $file . '/', $result);
                } elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
                    $id = Inflector::camel2id(substr(basename($file), 0, -14));
                    $className = $namespace . Inflector::id2camel($id) . 'Controller';
                    if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
                        $this->getControllerActions($className, $prefix . $id, $module, $result);
                    }
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }
    public function actionChildList(){
        $arr = [];
        $child_id = '';
        if (isset($_POST['depdrop_all_params']['userrole-parent_id'])) {
            $parents = $_POST['depdrop_all_params']['userrole-parent_id'];
            $child_id = $_POST['depdrop_all_params']['hiden_child_id_input'];
            $id= $_POST['depdrop_all_params']['userrole-id'];
            $model = UserRole::find()->where("parent_id = '".$parents."' && child_id = 0 && id != '".$id."'")->orderBy('role_name ASC')->asArray()->all();
            if(!empty($model)){
                foreach ($model as $key => $value) {
                    $arr[] = array('id'=>$value['id'],'name'=>$value['role_name']);
                }
               // $arr[] = \Yii\helpers\ArrayHelper::map($model,'id','role_name');
            }
         }
        echo json_encode(['output'=>$arr, 'selected'=>$child_id]);
        return;
    }

    /**
     * Get list action of controller
     * @param mixed $type
     * @param string $id
     * @param \yii\base\Module $module
     * @param string $result
     */
    private function getControllerActions($type, $id, $module, &$result)
    {
        $token = "Create controller with cofig=" . VarDumper::dumpAsString($type) . " and id='$id'";
        Yii::beginProfile($token, __METHOD__);
        try {
            /* @var $controller \yii\base\Controller */
            $controller = Yii::createObject($type, [$id, $module]);
            $this->getActionRoutes($controller, $result);
            $result[] = '/' . $controller->uniqueId . '/*';
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get route of action
     * @param \yii\base\Controller $controller
     * @param array $result all controller action.
     */
    private function getActionRoutes($controller, &$result)
    {
        $token = "Get actions of controller '" . $controller->uniqueId . "'";
        Yii::beginProfile($token, __METHOD__);
        try {
            $prefix = '/' . $controller->uniqueId . '/';
            foreach ($controller->actions() as $id => $value) {
                $result[] = $prefix . $id;
            }
            $class = new \ReflectionClass($controller);
            foreach ($class->getMethods() as $method) {
                $name = $method->getName();
                if ($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions') {
                    $result[] = $prefix . Inflector::camel2id(substr($name, 6));
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }
}
