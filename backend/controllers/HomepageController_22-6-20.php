<?php

namespace backend\controllers;

use Yii;
use backend\models\Homepage;
use backend\models\HomepageSearch;
use backend\models\Video;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Images;

/**
 * HomepageController implements the CRUD actions for Homepage model.
 */
class HomepageController extends \backend\components\BackendController {
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
    } */

    /**
     * Lists all Homepage models.
     * @return mixed
     */
    public function actionIndex() {
      $searchModel = new HomepageSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
      ]);
    }

    /**
     * Displays a single Homepage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
      return $this->render('view', [
        'model' => $this->findModel($id),
      ]);
    }

    /**
     * Creates a new Homepage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
      $model = new Homepage();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->HomeID]);
      } else {
        return $this->render('create', [
          'model' => $model,
        ]);
      }
    }

    /**
     * Updates an existing Homepage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = '1') {
      $model = $this->findModel($id);
      $modelAdvertisement = new \backend\models\Advertisements();
      $modelHomePage = new \backend\models\Homepage();
      $categoryData = explode(',', $model->CategoryID);
      $category = array();
      foreach ($categoryData as $key => $value) {
        $category[] = $value;
      }
        //Get main video and acccompny video list
      $var_two = 1;
      $sort = 'v.Created DESC';
      $sql = 'CALL Admin_video_category ("",:IDType,"",:sort,"","")';
      $command = Yii::$app->db->createCommand($sql);
      $command->bindParam(":IDType", $var_two);
      $command->bindParam(":sort", $sort);
      $outlist = $command->queryAll();
        //Get Advertisement video list
      $sql = 'CALL Admin_advertisement_video_list ("","","","","")';
      $command = Yii::$app->db->createCommand($sql);
      $advertisementData = $command->queryAll();
        //$advertisementData =  $modelAdvertisement->findAll(array('Status'=>'1'));
      $recordedVideoImage = $mainVideoInfo = $scheduleVideoInfo = array();
      if (!empty($model->VideoID)) {
        $recordedVideoImage = array_shift(array_filter($outlist, function($arr)use($model) {
          return $arr['ID'] == $model->VideoID;
        }));

        if (isset($recordedVideoImage['ID'])) {
          $sql = 'CALL Video_GetDetail (:VideoId)';
          $command = Yii::$app->db->createCommand($sql);
          $command->bindParam(":VideoId", $recordedVideoImage['ID']);
          $mainVideoInfo = $command->queryAll();
        }
      }
      $recordedScheduleVideoImage = array();
      if (!empty($model->ScheduleVideoID)) {
        $recordedScheduleVideoImage = array_shift(array_filter($outlist, function($arr)use($model) {
          return $arr['ID'] == $model->ScheduleVideoID;
        }));
        if (isset($recordedScheduleVideoImage['ID'])) {
          $sql = 'CALL Video_GetDetail (:VideoId)';
          $command = Yii::$app->db->createCommand($sql);
          $command->bindParam(":VideoId", $recordedScheduleVideoImage['ID']);
          $scheduleVideoInfo = $command->queryAll();
        }
      }
//        if($_SERVER['REMOTE_ADDR'] == '202.131.115.250') {
//            echo '<pre>';
//            print_r($recordedScheduleVideoImage);
//            exit;
//        }
      $tagMessage = \backend\models\Homepage::findOne(['HomeID' => '1']);
      if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        $model->VideoID = ($model->MainVideoType == 1) ? $model->VideoID : "";
        $model->ExternalVideoURL = ($model->MainVideoType == 2) ? $model->ExternalVideoURL : "";
        $model->AccompanyingID = $model->AccompanyingID;
        $model->AdvertisementID = ($model->NewsOrAdd == 2) ? $model->AdvertisementID : "";
        $model->CategoryID = (!empty(Yii::$app->request->post()['Homepage']['CategoryID'])) ? implode(",", Yii::$app->request->post()['Homepage']['CategoryID']) : "";
        $model->save(false);
        $tagMessage->TagMessage = trim($model->TagMessage);
        $tagMessage->save();

        $country = array();
        if (isset($_POST['Homepage']['CountryRestrictions'])) {
          $country = $_POST['Homepage']['CountryRestrictions'];
        }

        $modelCountry = new \backend\models\Homepagegeographic();
        $modelCountry->deleteAll('VideoGeographicID > 0');
        if ($model->MainVideoType == 2) {
          for ($n = 0; $n < count($country); $n++) {
            $modelCountry = new \backend\models\Homepagegeographic();
            $modelCountry->CountryID = $country[$n];
            $modelCountry->CreatedBy = Yii::$app->user->identity->UserID;
            $modelCountry->save();
          }
        }


        Yii::$app->session->setFlash('success', 'Homepage configuration has been updated successfully');
        return $this->redirect(['update', 'id' => $model->HomeID]);
      }
      $country = array();
      $modelCountry = new \backend\models\Homepagegeographic();
      $countryData = $modelCountry->find()->all();
      foreach ($countryData as $key => $value) {
        $country[] = $value->CountryID;
      }
      return $this->render('update', [
        'model' => $model,
        'videooutlist' => $outlist,
        'tagMessage' => $tagMessage,
        'categoryData' => $category,
        'advertisementData' => $advertisementData,
        'recordedVideoImage' => $recordedVideoImage,
        'recordedScheduleVideoImage' => $recordedScheduleVideoImage,
        'mainVideoInfo' => $mainVideoInfo,
        'scheduleVideoInfo' => $scheduleVideoInfo,
        'countryData' => $country,
      ]);
    }

    /**
     * Change order for accompanying video
     */
    public function actionReorderAccompanyingVideos() {
      $AccompanyingVideoId = Yii::$app->request->post('AccompanyingVideoId');
        //Get Advertisement video list
      $AccompanyingVideoId = empty($AccompanyingVideoId) ? [] : explode(",", $AccompanyingVideoId);

      $command = Yii::$app->db->createCommand("select video.*,images.ImageName,images.ImageType from video left join images on VideoID = ID && ISThumb = 1 And ImageType = 1 where ID IN(" . implode(",", $AccompanyingVideoId) . ") ORDER BY FIELD( ID, " . implode(",", $AccompanyingVideoId) . ")");
      $command->bindParam(":AccompanyingVideoId", implode(",", $AccompanyingVideoId));
      $amVideo = $command->queryAll();
      echo $this->renderPartial('reorder_accompanying_video', compact('amVideo'));
    }

    /**
     * Deletes an existing Homepage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
    }

    /**
     * Finds the Homepage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Homepage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
      if (($model = Homepage::findOne($id)) !== null) {
        return $model;
      } else {
        throw new NotFoundHttpException('The requested page does not exist.');
      }
    }
    public function actionSaveFile()
    {   
      if ($file = Yii::$app->request->post()) {
        $model = new Images();
        $model->setAttributes([
          'ImageName'=>$file['filename'],
          'ImageType'=>4,
          'Created'=>  new \yii\db\Expression('NOW()'),
          'CreatedBy' => Yii::$app->user->identity->UserID
        ]);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($model->save(false)){
          return ['status'=>'200','id'=>$model->ImageID];    
        }else{
          return ['status'=>'500'];    
        }
      }
    }
    
      
      public function actionSaveFilefire()
    {   
      if ($file = Yii::$app->request->post()) {
        $model = new Images();
        $model->setAttributes([
          'ImageName'=>$file['filename'],
          'ImageType'=>5,
          'Created'=>  new \yii\db\Expression('NOW()'),
          'CreatedBy' => Yii::$app->user->identity->UserID
        ]);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($model->save(false)){
          return ['status'=>'200','id'=>$model->ImageID];    
        }else{
          return ['status'=>'500'];    
        }
      }
    }
    
    public function actionDeleteLivetvThumb()
    {   
      if ($file = Yii::$app->request->post()) {
         $model = Images::findOne($file['ImageID']);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($model->delete()){
          return ['status'=>'200','id'=>$model->ImageID];    
        }else{
          return ['status'=>'500'];    
        }
      }
    }

  }
