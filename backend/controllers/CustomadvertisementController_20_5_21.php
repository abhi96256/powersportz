<?php

namespace backend\controllers;

use Yii;
use backend\models\Customadvertisement;
use backend\models\CustomadvertisementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomadvertisementController implements the CRUD actions for Customadvertisement model.
 */
class CustomadvertisementController extends \backend\components\BackendController {
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
   * Lists all Customadvertisement models.
   * @return mixed
   */
  public function actionIndex() {
    $searchModel = new CustomadvertisementSearch();
    if (isset($_GET['CustomadvertisementSearch'])) {
      $searchModel->attributes = $_GET['CustomadvertisementSearch'];
    }
    return $this->render('index', [
          'model' => $searchModel,
    ]);
  }

  /**
   * Displays a single Customadvertisement model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id) {
    return $this->render('view', [
          'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Customadvertisement model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
    $model = new Customadvertisement();
    $model->IsAll = '1';
    $model->IsExternal = '0';
    //Get main video and acccompny video list
    $type = '';
    $sql = 'CALL Admin_video_category ("",:IDType,"","","","")';
    $command = Yii::$app->db->createCommand($sql);
    $command->bindParam(":IDType", $type);
    $outlist = $command->queryAll();
    $playlist = array();
    $topics = array();
    $talkingData = [];

    $customVideo = array();
    if ($model->load(Yii::$app->request->post())) {
      if ($model->validate()) {

        return $this->redirect('index');
      } else {
        echo '<pre>';
        print_r($model->getErrors());
        die;
      }
    } else {
      return $this->render('create', [
            'model' => $model,
            'videooutlist' => $outlist,
            'playlistData' => $playlist,
            'categoryData' => array(),
            'topicsData' => $topics,
            'talkingData' => $talkingData,
            'customVideo' => $customVideo,
      ]);
    }
  }

  /**
   * Updates an existing Customadvertisement model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id) {
    $model = $this->findModel($id);
    if (isset($model->FromDate) && $model->FromDate != '') {
      $model->FromDate = ConvertDateTolocaltime($model->FromDate);
      // $model->FromDate = ConvertDateTolocaltime(date("m/d/Y H:i:s",strtotime($model->FromDate)));
    }
    if (isset($model->ToDate) && $model->ToDate != '') {
      $model->ToDate = ConvertDateTolocaltime($model->ToDate);
      // $model->ToDate = ConvertDateTolocaltime(date("m/d/Y H:i:s",strtotime($model->ToDate)));
    }
    $lastURL = $model->URL;
    $modelCustomPlaylist = new \backend\models\Customadplaylist();
    $modelCustomTopics = new \backend\models\Customadtopics();
    $modelCustomVideo = new \backend\models\Customadvideo();
    $playlistData = $modelCustomPlaylist->findAll(array('IsDelete' => '0', 'CustomAdvertiseID' => $id));
    $query = new yii\db\Query;
    $categoryData = $query->select(['*'])
        ->from('customadtopics')
        ->join('JOIN', 'category', 'category.ID = customadtopics.TopicsID'
        )->where(array('IsDelete' => '0', 'CustomAdvertiseID' => $id, 'category.Type' => 1))->createCommand()->queryAll();
    $query = new yii\db\Query;
    $topicsData = $query->select(['*'])
        ->from('customadtopics')
        ->join('JOIN', 'category', 'category.ID = customadtopics.TopicsID'
        )->where(array('IsDelete' => '0', 'CustomAdvertiseID' => $id, 'category.Type' => 2))->createCommand()->queryAll();
    $query = new yii\db\Query;
    $talkingData = $query->select(['*'])
        ->from('customadtopics')
        ->join('JOIN', 'category', 'category.ID = customadtopics.TopicsID'
        )->where(array('IsDelete' => '0', 'CustomAdvertiseID' => $id, 'category.Type' => 3))->createCommand()->queryAll();


    // $topicsData = $modelCustomTopics->findAll(array('IsDelete' => '0', 'CustomAdvertiseID' => $id));
    $customVideoData = $modelCustomVideo->findAll(array('IsDelete' => '0', 'CustomAdvertiseID' => $id));
    $playlist = array();
    $topics = array();
    $category = array();
    $talking = array();
    $customVideo = array();

    foreach ($playlistData as $key => $value) {
      $playlist[] = $value->PlaylistID;
    }
    foreach ($categoryData as $key => $value) {
      $category[] = $value['TopicsID'];
    }
    foreach ($topicsData as $key => $value) {
      $topics[] = $value['TopicsID'];
    }
    foreach ($talkingData as $key => $value) {
      $talking[] = $value['TopicsID'];
    }
    foreach ($customVideoData as $key => $value) {
      if (isset($value->VideoID) && $value->VideoID != '')
        $customVideo[] = $value->VideoID;
    }
    $model->VideosID = implode(",", $customVideo);
    $type = '';
    $sql = 'CALL Admin_video_category ("",:IDType,"",:sort,"","")';
    $sort = "v.Created DESC";
    $command = Yii::$app->db->createCommand($sql);
    $command->bindParam(":IDType", $type);
    $command->bindParam(":sort", $sort);
    $outlist = $command->queryAll();

    if ($model->load(Yii::$app->request->post())) {
      if (!empty($model->Type) && is_array($model->Type) && count($model->Type)) {
        $model->Type = implode(',', $model->Type);
      }
      if ($model->validate()) {
        return $this->redirect('index');
      } else {
        return $this->render('update', [
              'model' => $model,
              'playlistData' => $playlist,
              'categoryData' => $category,
              'topicsData' => $topics,
              'talkingData' => $talking,
              'videooutlist' => $outlist,
              'customVideo' => $customVideo,
        ]);
      }
    } else {
      return $this->render('update', [
            'model' => $model,
            'playlistData' => $playlist,
            'categoryData' => $category,
            'topicsData' => $topics,
            'talkingData' => $talking,
            'videooutlist' => $outlist,
            'customVideo' => $customVideo,
      ]);
    }
  }

  public function actionCreateajax() {

    $model = new Customadvertisement();
    // $model->scenario  = 'create';
    if ($model->load(Yii::$app->request->post())) {
      // $backednPath = str_replace('backend','frontend',\Yii::$app->basePath);
      // echo $backednPath.'/web/uploads/'.$model->VideoURL;die;
      //Video::upload_image(base64_encode(file_get_contents($backednPath.'/web/uploads/'.$model->VideoURL)));

      if ($model->validate()) {
        if (isset($_POST['Customadvertisement']['FromDate']) && $_POST['Customadvertisement']['FromDate'] != '') {
          $model->FromDate = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($_POST['Customadvertisement']['FromDate'])));
        } else {
          $model->FromDate = '';
        }
        if (isset($_POST['Customadvertisement']['ToDate']) && $_POST['Customadvertisement']['ToDate'] != '') {
          $model->ToDate = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($_POST['Customadvertisement']['ToDate'])));
        } else {
          $model->ToDate = '';
        }
        $URL = urldecode($_POST['Customadvertisement']['URL']);
        if ($_POST['Customadvertisement']['IsExternal'] == 1)
          $URL = urldecode(S3_THUMB_CLOUDFRONT . '/' . $_POST['Customadvertisement']['VideoURL']);
        $IsAll = $_POST['Customadvertisement']['IsAll'];
        $model->IsAll = $IsAll;
        $model->Type = $_POST['Customadvertisement']['Type'];
        $model->IsExternal = $_POST['Customadvertisement']['IsExternal'];
        $_type = $model->Type;
        if (!empty($model->Type) && is_array($model->Type) && count($model->Type)) {
          if (in_array(2, $model->Type)) {
            $model->MidTime = $_POST['Customadvertisement']['MidTime'];
          }
          $model->Type = implode(',', $model->Type);
        }
        // if($_POST['Customadvertisement']['Type'] == '2' || $_POST['Customadvertisement']['Type'] == '0') {
        //     $model->MidTime = $_POST['Customadvertisement']['MidTime'];
        // }
        if ($_POST['Customadvertisement']['IsSkip'] == '1') {
          $model->IsSkip = '1';
          $model->SkipTime = $_POST['Customadvertisement']['SkipTime'];
          $skipTimeString = 'skipoffset="00:00:' . $_POST['Customadvertisement']['SkipTime'] . '"';
        } else {
          $model->IsSkip = '';
          $model->SkipTime = '';
          $skipTimeString = '';
        }
        $model->save();
        $advertiseID = Yii::$app->db->getLastInsertID();
        $type = [];
        if (!empty($_type) && is_array($_type) && count($_type)) {
          foreach ($_type as $value) {
            $type[] = [
                'CusAdvertiseID' => $advertiseID,
                'Type_Id' => $value
            ];
          }
        }
        if (count($type)) {
          Yii::$app->db->createCommand()->batchInsert('customadvertisement_type', ['CusAdvertiseID', 'Type_Id'], $type)->execute();
        }
        if ($IsAll == '2') {
          $customCategory = array();
          $CustomPlaylist = array();
          $CustomTopics = array();
          $CustomTalkingPoints = array();
          $CustomVideos = array();
          if (isset($_POST['Customadvertisement']['customCategory']))
            $customCategory = $_POST['Customadvertisement']['customCategory'];
          if (isset($_POST['Customadvertisement']['CustomPlaylist']))
            $CustomPlaylist = $_POST['Customadvertisement']['CustomPlaylist'];
          if (isset($_POST['Customadvertisement']['CustomTopics']))
            $CustomTopics = $_POST['Customadvertisement']['CustomTopics'];
          if (isset($_POST['Customadvertisement']['CustomTalkingPoints']))
            $CustomTopics = $_POST['Customadvertisement']['CustomTalkingPoints'];
          if (isset($_POST['Customadvertisement']['VideosID']))
            $CustomVideos = explode(',', $_POST['Customadvertisement']['VideosID']);
          for ($n = 0; $n < count($CustomPlaylist); $n++) {
            $modelCustomPlaylist = new \backend\models\Customadplaylist();
            $modelCustomPlaylist->CustomAdvertiseID = $advertiseID;
            $modelCustomPlaylist->PlaylistID = $CustomPlaylist[$n];
            $modelCustomPlaylist->IsDelete = '0';
            $modelCustomPlaylist->save();
          }
          for ($n = 0; $n < count($customCategory); $n++) {
            $modelcustomCategory = new \backend\models\Customadtopics();
            $modelcustomCategory->CustomAdvertiseID = $advertiseID;
            $modelcustomCategory->TopicsID = $customCategory[$n];
            $modelcustomCategory->IsDelete = '0';
            $modelcustomCategory->save();
          }
          for ($n = 0; $n < count($CustomTopics); $n++) {
            $modelCustomTopics = new \backend\models\Customadtopics();
            $modelCustomTopics->CustomAdvertiseID = $advertiseID;
            $modelCustomTopics->TopicsID = $CustomTopics[$n];
            $modelCustomTopics->IsDelete = '0';
            $modelCustomTopics->save();
          }
          for ($n = 0; $n < count($CustomTalkingPoints); $n++) {
            $modelCustomTalkingPoints = new \backend\models\Customadtopics();
            $modelCustomTalkingPoints->CustomAdvertiseID = $advertiseID;
            $modelCustomTalkingPoints->TopicsID = $CustomTalkingPoints[$n];
            $modelCustomTalkingPoints->IsDelete = '0';
            $modelCustomTalkingPoints->save();
          }
          for ($n = 0; $n < count($CustomVideos); $n++) {
            $modelCustomVideo = new \backend\models\Customadvideo();
            $modelCustomVideo->CustomAdvertiseID = $advertiseID;
            $modelCustomVideo->VideoID = $CustomVideos[$n];
            $modelCustomVideo->IsDelete = '0';
            $modelCustomVideo->save();
          }
        }

        $xml = '<VAST version="2.0">
                <Ad id="static">
                <InLine>
                <AdSystem>Static VAST Template</AdSystem>
                <AdTitle>Static VAST Tag</AdTitle>
                <Creatives>
                <Creative>
                <Linear ' . $skipTimeString . '>
                <Duration>00:00:08</Duration>
                ';
        if (!empty($model->LandingLink)) {
          $xml .= '<VideoClicks>
                    <ClickThrough>' . $model->LandingLink . '</ClickThrough>
                    </VideoClicks>';
        }
        $xml .= '<MediaFiles>
                <MediaFile type="video/mp4" bitrate="300" width="480" height="270">
                ' . $URL . '
                </MediaFile>
                </MediaFiles>
                </Linear>
                </Creative>
                </Creatives>
                </InLine>
                </Ad>
                </VAST>';
        $xmlobj = new \SimpleXMLElement($xml);
        $fileName = "myStaticTag_" . $advertiseID;
        $xmlobj->asXML("upload/xml/" . $fileName . ".xml");
        \S3::putObjectFile('upload/xml/' . $fileName . '.xml', S3BUCKET, 'xml/' . $fileName . '.xml', \S3::ACL_PUBLIC_READ);
        $model->updateAll(array('XML' => $fileName), 'CustomAdvertiseID=' . $advertiseID);


        Yii::$app->session->setFlash('success', 'Advertisement has been added successfully');

        //echo json_encode(array("status"=>"ok","id"=>$videoID,'VideoURL'=>$model->VideoStreamURL,'thumbimage'=>S3_VIDEO_BUCKETABSOLUTE_PATH.$model->generateThumbnailImage->ImageName,'videoTitle'=>$model->Title,'shared_on_browser'=>$model->shared_on)); die;
        echo json_encode(array("status" => "ok", "UplodedVideoUrl" => $model->VideoURL, "id" => $advertiseID));
        die;
      } else {
        echo json_encode(array("status" => "error"));
        die;
      }
    }
  }

  public function actionUpdateajax() {
    $id = $_POST['id'];
    $model = $this->findModel($id);
    // $model->scenario = 'update';
    $exists_sharedon = empty($model->shared_on) ? [] : explode(",", $model->shared_on);
    if ($model->load(Yii::$app->request->post())) {
      $modelCustomPlaylist = new \backend\models\Customadplaylist();
      $modelCustomTopics = new \backend\models\Customadtopics();
      $modelCustomVideo = new \backend\models\Customadvideo();
      if ($model->validate()) {
        // echo '<pre>';print_r($model);exit;
        if (isset($_POST['Customadvertisement']['FromDate']) && $_POST['Customadvertisement']['FromDate'] != '') {
          $model->FromDate = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($_POST['Customadvertisement']['FromDate'])));
          // $model->FromDate = ConvertDateToUTC($_POST['Customadvertisement']['FromDate']);
        } else {
          $model->FromDate = '';
        }
        if (isset($_POST['Customadvertisement']['ToDate']) && $_POST['Customadvertisement']['ToDate'] != '') {
          $model->ToDate = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($_POST['Customadvertisement']['ToDate'])));
          //$model->ToDate = ConvertDateToUTC($_POST['Customadvertisement']['ToDate']);
        } else {
          $model->ToDate = '';
        }
        $URL = urldecode($_POST['Customadvertisement']['URL']);
        if ($_POST['Customadvertisement']['IsExternal'] == 0) {
          $URL = urldecode(S3_THUMB_CLOUDFRONT . '/' . $_POST['Customadvertisement']['VideoURL']);
        }
        $IsAll = $_POST['Customadvertisement']['IsAll'];
        $model->IsAll = $IsAll;
        $model->IsExternal = $_POST['Customadvertisement']['IsExternal'];
        // $model->Type = $_POST['Customadvertisement']['Type']; 
        // if($_POST['Customadvertisement']['Type'] == '2' || $_POST['Customadvertisement']['Type'] == '0') {
        //     $model->MidTime = $_POST['Customadvertisement']['MidTime'];
        // }
        $_type = $model->Type;
        if (!empty($model->Type) && is_array($model->Type) && count($model->Type)) {
          if (in_array(2, $model->Type)) {
            $model->MidTime = $_POST['Customadvertisement']['MidTime'];
          }
          $model->Type = implode(',', $model->Type);
        }
          $_AdActivePlatform = $model->AdActivePlatform;
        if (!empty($model->AdActivePlatform) && is_array($model->AdActivePlatform) && count($model->AdActivePlatform)) {
          
          $model->AdActivePlatform = implode(',', $model->AdActivePlatform);
        }

        if ($_POST['Customadvertisement']['IsSkip'] == '1') {
          $model->IsSkip = '1';
          $model->SkipTime = $_POST['Customadvertisement']['SkipTime'];
          $skipTimeString = 'skipoffset="00:00:' . $_POST['Customadvertisement']['SkipTime'] . '"';
        } else {
          $model->IsSkip = '';
          $model->SkipTime = '';
          $skipTimeString = '';
        }
        $model->Updated = date("Y-m-d H:i:s");
        $model->save();
        $type = [];
        if (!empty($_type) && is_array($_type) && count($_type)) {
          foreach ($_type as $value) {
            $type[] = [
                'CusAdvertiseID' => $id,
                'Type_Id' => $value
            ];
          }
        }
        Yii::$app->db->createCommand()
          ->delete('customadvertisement_type', 'CusAdvertiseID =' . $id)
          ->execute();
        if (count($type)) {
          Yii::$app->db->createCommand()->batchInsert('customadvertisement_type', ['CusAdvertiseID', 'Type_Id'], $type)->execute();
        }
        if ($IsAll == '2') {
          $modelCustomPlaylist->updateAll(array('IsDelete' => '1'), 'CustomAdvertiseID=' . $id);
          $modelCustomTopics->updateAll(array('IsDelete' => '1'), 'CustomAdvertiseID=' . $id);
          $modelCustomVideo->updateAll(array('IsDelete' => '1'), 'CustomAdvertiseID=' . $id);
          $CustomPlaylist = array();
          $CustomTopics = array();
          $CustomTalkingPoints = array();
          $CustomVideos = array();
          $customCategory = [];
          if (isset($_POST['Customadvertisement']['customCategory']))
            $customCategory = $_POST['Customadvertisement']['customCategory'];
          if (isset($_POST['Customadvertisement']['CustomPlaylist']))
            $CustomPlaylist = $_POST['Customadvertisement']['CustomPlaylist'];
          if (isset($_POST['Customadvertisement']['CustomTopics']))
            $CustomTopics = $_POST['Customadvertisement']['CustomTopics'];
          if (isset($_POST['Customadvertisement']['CustomTalkingPoints']))
            $CustomTalkingPoints = $_POST['Customadvertisement']['CustomTalkingPoints'];
          if (isset($_POST['Customadvertisement']['VideosID']))
            $CustomVideos = explode(',', $_POST['Customadvertisement']['VideosID']);
          for ($n = 0; $n < count($CustomPlaylist); $n++) {
            $modelCustomPlaylist = new \backend\models\Customadplaylist();
            $modelCustomPlaylist->CustomAdvertiseID = $id;
            $modelCustomPlaylist->PlaylistID = $CustomPlaylist[$n];
            $modelCustomPlaylist->IsDelete = '0';
            $modelCustomPlaylist->save();
          }
          for ($n = 0; $n < count($CustomTopics); $n++) {
            $modelCustomTopics = new \backend\models\Customadtopics();
            $modelCustomTopics->CustomAdvertiseID = $id;
            $modelCustomTopics->TopicsID = $CustomTopics[$n];
            $modelCustomTopics->IsDelete = '0';
            $modelCustomTopics->save();
          }
          for ($n = 0; $n < count($CustomTalkingPoints); $n++) {
            $modelCustomTalkingPoints = new \backend\models\Customadtopics();
            $modelCustomTalkingPoints->CustomAdvertiseID = $id;
            $modelCustomTalkingPoints->TopicsID = $CustomTalkingPoints[$n];
            $modelCustomTalkingPoints->IsDelete = '0';
            $modelCustomTalkingPoints->save();
          }
          for ($n = 0; $n < count($customCategory); $n++) {
            $modelcustomCategory = new \backend\models\Customadtopics();
            $modelcustomCategory->CustomAdvertiseID = $id;
            $modelcustomCategory->TopicsID = $customCategory[$n];
            $modelcustomCategory->IsDelete = '0';
            $modelcustomCategory->save();
          }
          for ($n = 0; $n < count($CustomVideos); $n++) {
            $modelCustomVideo = new \backend\models\Customadvideo();
            $modelCustomVideo->CustomAdvertiseID = $id;
            $modelCustomVideo->VideoID = $CustomVideos[$n];
            $modelCustomVideo->IsDelete = '0';
            $modelCustomVideo->save();
          }
        }

        $xml = '<VAST version="2.0">
                <Ad id="static">
                <InLine>
                <AdSystem>Static VAST Template</AdSystem>
                <AdTitle>Static VAST Tag</AdTitle>
                <Creatives>
                <Creative>
                <Linear ' . $skipTimeString . '>
                <Duration>00:00:08</Duration>
                ';
        if (!empty($model->LandingLink)) {
          $xml .= '<VideoClicks>
                    <ClickThrough>' . $model->LandingLink . '</ClickThrough>
                    </VideoClicks>';
        }
        $xml .= '<MediaFiles>
                <MediaFile type="video/mp4" bitrate="300" width="480" height="270">
                ' . $URL . '
                </MediaFile>
                </MediaFiles>
                </Linear>
                </Creative>
                </Creatives>
                </InLine>
                </Ad>
                </VAST>';
        $xmlobj = new \SimpleXMLElement($xml);
        $fileName = "myStaticTag_" . $id;
        $xmlobj->asXML("upload/xml/" . $fileName . ".xml");
        \S3::putObjectFile('upload/xml/' . $fileName . '.xml', S3BUCKET, 'xml/' . $fileName . '.xml', \S3::ACL_PUBLIC_READ);
        Yii::$app->session->setFlash('success', 'Advertisement has been updated successfully');
        //http://52.91.4.216/powersport/frontend/web/index.php/video?id=52
        //echo json_encode(array("status"=>"ok","id"=>$id,'VideoURL'=>$model->VideoStreamURL,'thumbimage'=>S3_VIDEO_BUCKETABSOLUTE_PATH.$model->generateThumbnailImage->ImageName,'videoTitle'=>$model->Title,'shared_on_browser'=>$model->shared_on)); die;
        echo json_encode(array("status" => "ok", "id" => $id));
        die;
      } else {
        echo json_encode($model->geterrors());
        die;
        // echo json_encode(array("status"=>"error")); die;
      }
    }
  }

  public function actionUpdatevideo() {
    $videoID = $_POST['id'];
    $modelUpdate = $this->findModel($videoID);
    if (isset($_POST['fullvideofile']) && $_POST['fullvideofile'] != '') {
      $modelUpdate->FullVideoURL = $_POST['fullvideofile'];
    }
    if (isset($_POST['filename']) && $_POST['filename'] != '') {
      $modelUpdate->VideoURL = $_POST['filename'];

      if ($modelUpdate->IsExternal == 0) {
        $URL = urldecode(S3_THUMB_CLOUDFRONT . '/' . $_POST['filename']);
      }
      $skipTimeString = '';
      if ($modelUpdate->IsSkip == '1') {
        $skipTimeString = 'skipoffset="00:00:' . $modelUpdate->SkipTime . '"';
      }

      $xml = '<VAST version="2.0">
            <Ad id="static">
            <InLine>
            <AdSystem>Static VAST Template</AdSystem>
            <AdTitle>Static VAST Tag</AdTitle>

            <Creatives>
            <Creative>
            <Linear ' . $skipTimeString . '>
            <Duration>00:00:08</Duration>
            <VideoClicks>
            <ClickThrough>http://www.jwplayer.com/</ClickThrough>
            </VideoClicks>
            <MediaFiles>
            <MediaFile type="video/mp4" bitrate="300" width="480" height="270">
            ' . $URL . '
            </MediaFile>
            </MediaFiles>
            </Linear>
            </Creative>
            </Creatives>
            </InLine>
            </Ad>
            </VAST>';
      $xmlobj = new \SimpleXMLElement($xml);
      $fileName = "myStaticTag_" . $videoID;
      $xmlobj->asXML("upload/xml/" . $fileName . ".xml");
      \S3::putObjectFile('upload/xml/' . $fileName . '.xml', S3BUCKET, 'xml/' . $fileName . '.xml', \S3::ACL_PUBLIC_READ);
    }
    $modelUpdate->save();
    echo json_encode(array("status" => "ok"));
    die;
  }

  /**
   * Deletes an existing Customadvertisement model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id) {
    if ($model = $this->findModel($id)) {
      Yii::$app->db->createCommand()
        ->delete('customadvertisement_type', 'CusAdvertiseID =' . $id)
        ->execute();
      $model->delete();
      Yii::$app->session->setFlash('success', 'Item has been deleted successfully');
    }

    return $this->redirect(['index']);
  }

  /**
   * Finds the Customadvertisement model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Customadvertisement the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = Customadvertisement::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

}
