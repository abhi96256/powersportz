<?php

namespace backend\controllers;

use Yii;
use backend\models\Breakingnews;
use backend\models\BreakingnewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * BreakingnewsController implements the CRUD actions for Breakingnews model.
 */
class BreakingnewsController extends \backend\components\BackendController
{
 /* public function behaviors()
    {
        return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['update','create','index'],
                            'roles' => ['@'],
                        ],
                    ],
                ],
        ];
    }*/
    
    public function beforeAction($action)
    {        
        if (\Yii::$app->getUser()->isGuest &&
            \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl)
        ) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Breakingnews models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BreakingnewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Breakingnews model.
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
     * Creates a new Breakingnews model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Breakingnews();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                /**  start : Add or update langauge translation fields **/
                if(isset($_POST['languageFields'])){
                        $_POST['languageFields']['from_table_id'] = $model->ID;
                        \backend\models\LangaugeFields::SaveLanguageFields($_POST['languageFields']);
                }
                /**  stop : Add or update langauge translation fields **/
                Yii::$app->session->setFlash('success', 'News  has been Created successfully');  
			   return $this->redirect('index');            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Breakingnews model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                /**  start : Add or update langauge translation fields **/
                    if(isset($_POST['languageFields'])){
                            $_POST['languageFields']['from_table_id'] = $model->ID;
                            \backend\models\LangaugeFields::SaveLanguageFields($_POST['languageFields']);
                    }
                /**  stop : Add or update langauge translation fields **/
                Yii::$app->session->setFlash('success', 'News  has been Updated successfully');  
			   return $this->redirect('index');                       
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Breakingnews model.
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
     * Finds the Breakingnews model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Breakingnews the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Breakingnews::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
