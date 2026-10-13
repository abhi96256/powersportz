<?php

namespace backend\controllers;

use Yii;
use backend\models\Member;
use backend\models\MemberSearch;
use backend\models\Video;
use backend\models\Videouploadbysubscribers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends \backend\components\BackendController {
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
      }
     */

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view', 'likedvideo', 'sharedvideo', 'uploadvideo', 'uploadvideoprocess', 'uploadvideoreject', 'index', 'downloadvideo','setvideouploadenable'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        if (\Yii::$app->getUser()->isGuest &&
                \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl)
        ) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MemberSearch();
        if (isset($_GET['MemberSearch'])) {
            $searchModel->attributes = $_GET['MemberSearch'];
        }

        return $this->render('index', [
                    'model' => $searchModel,
                        // 'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Member model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionLikedvideo() {
        $likemodel = new member();

        if (isset($_GET['id'])) {

            // $searchModel->attributes = $_GET['member'];
            $id = $_GET['id'];
            // $model  = $searchModel->getLikevideo($id);
            $sql = 'CALL Admin_Subscribers_Liked_Video (:id,"","","")';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":id", $id);
            $outlist = $command->queryAll();
            return $this->render('likevideo', [
                        'model' => $this->findModel($id),
                        'likemodel' => $outlist,
            ]);
        }
        /* return $this->render('likevideo', [            
          'model' => $model,
          ]); */
    }

    public function actionSharedvideo() {
        $likemodel = new member();

        if (isset($_GET['id'])) {

            // $searchModel->attributes = $_GET['member'];
            $id = $_GET['id'];
            // $model  = $searchModel->getLikevideo($id);
            $sql = 'CALL Admin_Subscribers_Shared_Video (:id,"","","")';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":id", $id);
            $outlist = $command->queryAll();
            return $this->render('sharedvideo', [
                        'model' => $this->findModel($id),
                        'likemodel' => $outlist,
            ]);
        }
    }

    public function actionUploadvideo() {
        $searchModel = new Member();

        if (isset($_GET['id'])) {
            $searchModel->attributes = $_GET['id'];
        }

        return $this->render('videoupload', [
                    'model' => $searchModel,
                        // 'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadvideo() { /* 1-Pending,2-Published,3-Rejected */
        $pid = $_GET['pid'];
		    $id = $_GET['id'];
        $status = $_GET['status'];
        //if ($status == '1' || $status == '3' || $status == '4') {
            $modellocalvideo = \backend\models\Videouploadbysubscribers::find()->where(['ID' => $pid])->one();
            $videofile = $modellocalvideo->VideoFile;
            //$backednPath = str_replace('backend','frontend',\Yii::$app->basePath);
           // $path = $backednPath.'/\web\uploads\/'.$videofile;
			      $path = S3_SUBSCRIBER_VIDEO_BUCKETABSOLUTE_PATH.$videofile;
            //$yourfile = "http://testvideoout.s3.amazonaws.com/Videos/Thumb/Thumb_Videos_23_1446208159801_00001.png";
            
            $fullPath = $path;
            if($fullPath) {
              $fsize = strlen(file_get_contents($fullPath));
              $path_parts = pathinfo($fullPath);
              $ext = strtolower($path_parts["extension"]);
              switch ($ext) {
                  case "pdf":
                  header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
                  header("Content-type: application/pdf"); // add here more headers for diff. extensions
                  break;
                  default;
                  header("Content-type: application/octet-stream");
                  header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
              }
              if($fsize) {//checking if file size exist
                header("Content-length: $fsize");
              }
              readfile($fullPath);
              exit;
          }

         /*   if (file_exists($fullPath)) {
              echo "tttt";die;

         */   
             // print_r($fullPath);
            /* header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($fullPath));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fullPath));
                ob_clean();
                flush();
                readfile($fullPath);*/
               header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; file=text.jpg');
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize(file_get_contents($fullPath)));
                ob_clean();
                flush();
                readfile($fullPath);
               die;
            /*} else {
                return $this->redirect('../member/uploadvideo?id='.$id);
            }*/
       /* } else if ($status == '2') {
            $modellocalvideo = \backend\models\Videouploadbysubscribers::find()->where(['ID' => $pid])->one();
            $videoid = $modellocalvideo->VideoID;
            $modelvideo = \backend\models\Video::find()->where(['ID' => $videoid])->one();
            $path = S3_VIDEO_BUCKETABSOLUTE_PATH . $modelvideo->VideoStreamURL;
            $Random_Number = rand(0, 9999999999); //Random number to be added to name.
            $time = time();
           $NewFileName = $Random_Number . $time . '.mp4'; //new file name
          // $downloadPAth = "../../frontend/web/uploads/test.mp4";
            $downloadPAth = "../../frontend/web/uploads/".$NewFileName;
            file_put_contents($downloadPAth,fopen($path, 'r'));
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($downloadPAth));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($downloadPAth));
            ob_clean();
            flush();
            readfile($downloadPAth);
            ignore_user_abort(true);
            unlink($downloadPAth);
            
            exit;
        }*/
    }

    public function actionUploadvideoprocess() {
        $sid = $_POST['SID'];
        $meberid = $_POST['MemberID'];
        $userid = Yii::$app->user->identity->UserID;

        $model = Videouploadbysubscribers::find($sid);
        $model = Videouploadbysubscribers::find()->where(['ID' => $sid, 'MemberID' => $meberid])->one();
        $model->ApproveStatus = '2';
        $model->UpdatedBy = $userid;
        $model->Updated = date('Y-m-d H:i:s');

        $model->save();
        if ($model->save()) {
            echo 'success';
            exit;
        } else {
            echo 'fail';
            exit;
        }
    }

    public function actionUploadvideoreject() {
        $sid = $_POST['SID'];
        $meberid = $_POST['MemberID'];
        $userid = Yii::$app->user->identity->UserID;

        $model = Videouploadbysubscribers::find($sid);
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
        }
    }

    public function actionView1($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Member();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->MemberID]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->MemberID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Member model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
     public function actionSetvideouploadenable() {
         
        //$fromdate =  date('Y-m-d H:i:s',strtotime($_POST['FromDate']));
        //$todate =  date('Y-m-d H:i:s',strtotime($_POST['ToDate']));
         $fromdate = ConvertDateToUTC(date("Y-m-d H:i:s",strtotime($_POST['FromDate'])));
         $todate =  ConvertDateToUTC(date("Y-m-d H:i:s",strtotime($_POST['ToDate'])));
        
      //  $modelvideoenable = \backend\models\Subscribervideosetting::find()->where(['SID' => '1'])->one();
          $modelvideoenable = \backend\models\Subscribervideosetting::find()->orderBy(['SID'=>SORT_DESC])->one();
        
        if($modelvideoenable['FromDate']!='' && $modelvideoenable['ToDate']!='' ){
            // $modelvideoenableupdate = \backend\models\Subscribervideosetting::find()->where(['SID' => '1'])->one();
             $modelvideoenableupdate = \backend\models\Subscribervideosetting::find()->orderBy(['SID'=>SORT_DESC])->one();
             $modelvideoenableupdate->FromDate = $fromdate;
             $modelvideoenableupdate->ToDate = $todate;
             $modelvideoenableupdate->Updated = date('Y-m-d H:i:s');
             $modelvideoenableupdate->UpdatedBy = Yii::$app->user->identity->UserID;
             $modelvideoenableupdate->save();
             if( $modelvideoenableupdate->save()){
                  Yii::$app->session->setFlash('success', 'Enable Subscriber video upload date set successfully');
                 echo "success";die;
             }else{
                Yii::$app->session->setFlash('error', 'Enable Subscriber video upload date not set ');
                 echo "fail"; die;
             }
             
        }else{
            
             $modelvideoenablesave = new \backend\models\Subscribervideosetting();
             $modelvideoenablesave->FromDate = $fromdate;
             $modelvideoenablesave->ToDate = $todate;
             $modelvideoenablesave->CreatedBy = Yii::$app->user->identity->UserID;
             $modelvideoenablesave->save();
             if( $modelvideoenablesave->save()){
                Yii::$app->session->setFlash('success', 'Enable Subscriber video upload date set successfully');
                  echo "success";die;
             }else{
                Yii::$app->session->setFlash('error', 'Enable Subscriber video upload date not set ');
                echo "fail"; die;
             }
        }
               // $modelvideo->delete();
        /* TYPE:  1-Like,2-Favourite,3-Watchlist */
       /* if (!Yii::$app->getUser()->isGuest) {
            $sid = $_POST['sid'];
            $type = $_POST['type'];
          
            if($type==''){
                $modelvideo = \backend\models\Videouploadbysubscribers::find()->where(['ID' => $sid])->one();
                $modelvideo->delete();
                if ($modelvideo->delete()) {
                    echo "success";
                    die;
                } else {
                    echo "fail";
                    die;
                }
     }}*/
        }
        
    protected function findModel($id) {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
