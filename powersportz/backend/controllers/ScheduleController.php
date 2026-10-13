<?php

namespace backend\controllers;

use Yii;
use backend\models\Schedule;
use backend\models\ScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * ScheduleController implements the CRUD actions for Schedule model.
 */
class ScheduleController extends \backend\components\BackendController {
    /* public function behaviors() {
      return [
      'verbs' => [
      'class' => VerbFilter::className(),
      'actions' => [
      'delete' => ['post'],
      ],
      ],
      ];
      }
     */

    /* public function behaviors() {
      return [
      'access' => [
      'class' => AccessControl::className(),
      'rules' => [
      [
      'allow' => true,
      'actions' => ['index', 'view', 'create', 'update', 'uploadvideo', 'uploadvideoprocess', 'uploadvideoreject', 'index','videosearchplaylist'],
      'roles' => ['@'],
      ],
      ],
      ],
      ];
      } */

    public function beforeAction($action) {
        if (\Yii::$app->getUser()->isGuest &&
                \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl)
        ) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Schedule models.
     * @return mixed
     */
    public function actionIndex()
      {
      $searchModel = new ScheduleSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      ]);
      }
  
   /* public function actionIndex() {
        $searchModel = new ScheduleSearch();
        // $_GET['ScheduleSearch']; 
        if (isset($_POST['ScheduleSearch'])) {
            $searchModel->attributes = $_POST['ScheduleSearch'];
        }



        return $this->render('index', [
                    'model' => $searchModel,
        ]);
    }
*/
    /**
     * Displays a single Schedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionScheduledelete() {
        $scheduleid = $_POST['scheduleid'];
        $sceduledate = $_POST['sceduledate'];
        $model = Schedule::find()->where(['ScheduleID' => $scheduleid])->one();
        // $model= Schedule::find($scheduleid);
        $model->delete();
        if ($model->delete()) {

            echo "success";
            die;
        } else {
            echo 'fail';
            die;
        }

        /* $model = Videouploadbysubscribers::find($sid);
          $model = Videouploadbysubscribers::find()->where(['ID' => $sid, 'MemberID' => $meberid])->one();
          $model->ApproveStatus = '3';
          $model->UpdatedBy = $userid;
          $model->Updated = date('Y-m-d H:i:s');

          $model->save();
          if ($model->save()) {
          echo 'success';
          exit;
          } else {
          echo 'fail';
          exit;
          } */
    }

    /**
     * Creates a new Schedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
      if ($post = Yii::$app->request->post()){
        $post = $post['Schedule'];
        $keys = array_keys($post);
        $count =0;
        foreach ($post['ProgramTitle']  as $key => $value) {
          $model = new Schedule();          
          foreach ($keys as $_value) {
            if(in_array($_value,['ScheduleFromTime','ScheduleTime'])){
              $model->{$_value} =  $post[$_value][0];
              $model->{$_value} = ConvertDateToUTC($model->{$_value});
            }else{
              $model->{$_value} =  $post[$_value][$key];
            }
          }
          $model->Status = 2;
          $model->CreatedBy = Yii::$app->user->identity->UserID;
          $model->ScheduleDate =  date("Y-m-d",strtotime($model->ScheduleFromTime));
          $model->save(false);
        }
        Yii::$app->session->setFlash('success', 'Schedule has been added successfully');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'status' => 200
        ];
        
      } else {
        return $this->render('create', [
          'model' => new Schedule(),
        ]);
      }
    }

    /**
     * Updates an existing Schedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionVideosearchplaylist() {
        $var_two = '';
        $videotitle = Yii::$app->request->post('videotitle');

        $sql = 'CALL Admin_All_Video_List (:videotitle,"","","")';
        $command = Yii::$app->db->createCommand($sql);

        $command->bindParam(":videotitle", $videotitle);
        $videodetils = $command->queryAll();
        if (!empty($videodetils)) {
            foreach ($videodetils as $videodetilssub) {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="radio" name="videothumb" class="videothumbchkbox" value="' . $videodetilssub['ID'] . '"><img class="thumbnail img-responsive" src="' . ImagesUrl($videodetilssub) . '"><p>' . $videodetilssub['Title'] . '</p></div>';
            }
        } else {
            echo 'No Records Found';
        }
    }

    public function actionUpdate($id) {
      $model = $this->findModel($id);
      $model->scenario = 'update';

      $model->ScheduleFromTime = date("d M Y h:i A",strtotime(ConvertDateTolocaltime($model->ScheduleFromTime))); 
      $model->ScheduleTime = date("d M Y h:i A",strtotime(ConvertDateTolocaltime($model->ScheduleTime))); 
      if ($model->load(Yii::$app->request->post()) && $model->validate()){
        $model->ScheduleFromTime = ConvertDateToUTC($model->ScheduleFromTime); 
        $model->ScheduleTime = ConvertDateToUTC($model->ScheduleTime); 
        $model->ScheduleDate =  date("Y-m-d",strtotime( $model->ScheduleFromTime));
        $model->save();
        Yii::$app->session->setFlash('success', 'Schedule has been added successfully');
        return $this->redirect(['index']);
      }
      return $this->render('update', [
        'model' =>$model
      ]);
    }

    /**
     * Deletes an existing Schedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Schedule has been deleted successfully');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Schedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Schedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetvideoname() {

        /* $videoid=Yii::$app->request->post('videoid'); 
          $modelvideo = \backend\models\Video::find()->where(['ID' => $videoid])->one();
          echo $modelvideo->Title; die;

         */
    }

}
