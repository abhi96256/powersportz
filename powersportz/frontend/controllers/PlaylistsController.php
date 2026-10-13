<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Playlists;
use frontend\models\PlaylistsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * PlaylistsController implements the CRUD actions for Playlists model.
 */
class PlaylistsController extends Controller {

  public function behaviors() {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['post'],
            ],
        ],
    ];
  }

  /**
   * Lists all Playlists models.
   * @return mixed
   */
  public function actionIndex() {
//         $lang_code=Yii::$app->language;   
//         if(isset($_SESSION['language_id'])){
//             $lang_code = $_SESSION['language_id'];
//             Yii::$app->language = $lang_code;
//         }
//         $lang_data=\backend\models\Langauge::getLanguageId($lang_code);
//         if(!empty($lang_data)){
//             $lang_id=$lang_data['LanguageID'];
//         }else{
//             $lang_id='';
//         }
// //        $searchModel = new PlaylistsSearch();
// //        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//         $country_code=GetIPDetails();
//         $CountryData = \backend\models\Country::find()->where(['Code' => $country_code])->asArray()->one();
//         if(!empty($CountryData)){
//             $countryid=$CountryData['ID'];      
//         }
//         else{
//             $countryid='';    
//         }
//         $sql =  'CALL Video_Get_PlayList (:CountryID)';
//         $command = Yii::$app->db->createCommand($sql);
//         $command->bindParam(":CountryID",$countryid);
//         $playlistdetails = $command->queryAll();
//         if($lang_id!='' || $lang_id!='1'){
//             if(!empty($playlistdetails)){
//                 foreach($playlistdetails as $playkey=>$playlistdetailssub){
//                   $playlistid=$playlistdetailssub['ID'];          
//                   $sql = 'CALL Getdetails_by_lang(:lang_id,"playlist",:play_id)';
//                   $command = Yii::$app->db->createCommand($sql);
//                   $command->bindParam(":play_id", $playlistid);
//                   $command->bindParam(":lang_id", $lang_id);
//                   $translatedplaydata = $command->queryAll();
//                   print_r( $translatedplaydata );exit;
//                   if(!empty($translatedplaydata)){
//                     foreach($translatedplaydata as $translatedplaydatasub){
//                         if($translatedplaydatasub['value']!=''){
//                             $playlistdetails[$playkey][$translatedplaydatasub['field_name']]=$translatedplaydatasub['value'];
//                         }
//                     }
//                 }
//             }
//         }
//     } 
    return $this->render('index', [
        // 'playlistdetails'=>$playlistdetails
    ]);
  }

  /**
   * Lists all Sports models.
   * @return mixed
   */
  public function actionPageData() {
    $country_code = GetIPDetails();
    $CountryData = \backend\models\Country::find()->where(['Code' => $country_code])->asArray()->one();
    if (!empty($CountryData)) {
      $countryid = $CountryData['ID'];
    } else {
      $countryid = '';
    }
    $sql = 'CALL Video_Get_PlayList_Pagination(:CountryID,"","")';

    $command = Yii::$app->db->createCommand($sql);
    $command->bindParam(":CountryID", $countryid);
    $totalCount = $command->execute();
    if ($totalCount) {
      $page = '';
      $per_page = '';

      $sql = 'CALL Video_Get_PlayList_Pagination (:CountryID,:offset,:limit)';
      $pagination = new Pagination(['totalCount' => $totalCount, 'page' => 2]);
      $page = $pagination->getPage(true);
      $offset = $page * $pagination->getPageSize();
      $command = Yii::$app->db->createCommand($sql);
      $command->bindParam(":CountryID", $countryid);
      $command->bindParam(":offset", $offset);
      $command->bindParam(":limit", $pagination->getPageSize());
      $items = $command->queryAll();
      $html = $this->renderPartial('items', ['items' => $items]);
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return ['totalCount' => $totalCount, 'html' => $html, 'status' => '200'];
    } else {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return ['totalCount' => 0, 'data' => [], 'status' => '500'];
    }
  }

  /**
   * Displays a single Playlists model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id) {
    return $this->render('view', [
          'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Playlists model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
    $model = new Playlists();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->ID]);
    } else {
      return $this->render('create', [
            'model' => $model,
      ]);
    }
  }

  /**
   * Updates an existing Playlists model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id) {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->ID]);
    } else {
      return $this->render('update', [
            'model' => $model,
      ]);
    }
  }

  /**
   * Deletes an existing Playlists model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id) {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the Playlists model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Playlists the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = Playlists::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

}
