<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Sports;
use frontend\models\SportsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * SportsController implements the CRUD actions for Sports model.
 */
class SportsController extends Controller {

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
   * Lists all Sports models.
   * @return mixed
   */
  public function actionIndex() {
    if (isset($_SESSION['language_id'])) {
      $lang_code = $_SESSION['language_id'];
      Yii::$app->language = $lang_code;
    }
    $country_code = GetIPDetails();
    $CountryData = \backend\models\Country::find()->where(['Code' => $country_code])->asArray()->one();
    if (!empty($CountryData)) {
      $countryid = $CountryData['ID'];
    } else {
      $countryid = '';
    }
    $searchModel = new SportsSearch();
    $sportslist = $searchModel->getSportsListWithSlug($countryid);
    // if (!empty($sportslist)) {
    //     if (Yii::$app->getRequest()->getQueryParam('id')) {
    //         $TopicId = Yii::$app->getRequest()->getQueryParam('id');
    //         foreach($sportslist as $key => $value){
    //             if($value['slug'] == $TopicId){
    //                 $TopicId =$key;
    //                 break;
    //             }
    //         }
    //     }
    //     //  else {
    //     //     foreach($sportslist as $key => $value){
    //     //             $TopicId = $key;
    //     //             break;
    //     //     }
    //     // }
    //     $sql = 'CALL Category_Get_List (:categID,:categType,:status,:sort,"","")';
    //     $var_one = '2';
    //     $var_status = '1';
    //     $sort = ' vc.DisplayIndex desc ';
    //     $command = Yii::$app->db->createCommand($sql);
    //     $command->bindParam(":categID", $TopicId);
    //     $command->bindParam(":categType", $var_one);
    //     $command->bindParam(":status", $var_status);
    //     $command->bindParam(":sort", $sort);
    //     $inlist = $command->queryAll();
    // } else {
    //     $inlist = array();
    // }
//meta description
    \Yii::$app->view->registerMetaTag([
        'name' => 'description',
        'content' => "PowerSportz TV is India's first popular digital sport news channel offering a glut of information containing live streaming, schedule, debates and analysis of sports. We deliver sports infotainments to our viewers the way no one ever did."
    ]);
    return $this->render('index', [
          // 'searchModel' => $inlist,
          'sportslist' => $sportslist,
    ]);
  }

  /**
   * Lists all Sports models.
   * @return mixed
   */
  public function actionPageData() {
    $TopicId = Yii::$app->request->get('TopicId');
    $sql = 'CALL Category_Get_List (:categID,:categType,:status,:sort,"","")';
    $var_one = '2';
    $var_status = '1';
    $sort = ' vc.DisplayIndex desc ';
    $command = Yii::$app->db->createCommand($sql);
    $command->bindParam(":categID", $TopicId);
    $command->bindParam(":categType", $var_one);
    $command->bindParam(":status", $var_status);
    $command->bindParam(":sort", $sort);
    $totalCount = $command->execute();
    if ($totalCount) {
      $page = '';
      $per_page = '';

      $sql = 'CALL Category_Get_List (:categID,:categType,:status,:sort,:offset,:limit)';
      $pagination = new Pagination(['totalCount' => $totalCount, 'page' => 2]);
      $page = $pagination->getPage(true);
      $offset = $page * $pagination->getPageSize();
      $command = Yii::$app->db->createCommand($sql);
      $command->bindParam(":categID", $TopicId);
      $command->bindParam(":categType", $var_one);
      $command->bindParam(":status", $var_status);
      $command->bindParam(":sort", $sort);
      $command->bindParam(":offset", $offset);
      $command->bindParam(":limit", $pagination->getPageSize());
      $inlist = $command->queryAll();
      $html = $this->renderPartial('items', ['items' => $inlist]);
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return ['totalCount' => $totalCount, 'html' => $html, 'status' => '200'];
    } else {
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return ['totalCount' => 0, 'data' => [], 'status' => '500'];
    }
  }

  /**
   * Finds the Sports model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Sports the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = Sports::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

}
