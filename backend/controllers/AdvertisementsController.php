<?php

namespace backend\controllers;

use Yii;
use backend\models\Advertisements;
use backend\models\AdvertisementsSearch;
use yii\web\Controller;
use backend\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * AdvertisementsController implements the CRUD actions for Advertisements model.
 */
class AdvertisementsController extends \backend\components\BackendController {

   /* public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update', 'create', 'index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }*/

    public function beforeAction($action) {
        if (\Yii::$app->getUser()->isGuest &&
                \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl)
        ) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Advertisements models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdvertisementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advertisements model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Advertisements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Advertisements();
        $sql = 'SELECT GetUniqueCode() as unique_key';
        $command = Yii::$app->db->createCommand($sql);
        $functionvlary = $command->queryAll();
        $unique_Id = $functionvlary[0]['unique_key'];
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
        if(isset($_FILES['Advertisements']['name']['ImagePath']) && $_FILES['Advertisements']['name']['ImagePath']!=''){
               list($width, $height, $type, $attr)= getimagesize($_FILES["Advertisements"]["tmp_name"]['ImagePath']);    
        if($width>1133 && $width>1123){
            
                                $model->addError('ImagePath','Please Upload Valid Image');
                                return $this->render('create', [
                                'model' => $model,
                            ]);     
        }
        elseif($height>73 && $height>63){
                                $model->addError('ImagePath','Please Upload Valid Image');
                                 return $this->render('create', [
                                'model' => $model,
                            ]);
        }
        }
        else{
                        $model->addError('ImagePath','Please Upload Image');
                        return $this->render('create', [
                        'model' => $model,
                         ]);
        }
                        $filesTempName = $_FILES['Advertisements']['tmp_name']['ImagePath'];
                        $fileName = $_FILES['Advertisements']['name']['ImagePath'];
                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                        $actualImageName = PREFIX_ADVERISEMENT . $unique_Id . '.' . $ext;
               
        if (\S3::putObjectFile($filesTempName, S3BUCKET, BUCKET_FOLDER . '/' .ADVERISEMENT . '/' . $actualImageName, \S3::ACL_PUBLIC_READ)) {
                    $model->ImagePath = $actualImageName;
       //BackendController::convertToUTCTimeZone($ReceiptDate,CONVERT_TIMEZONE,DEFAULT_TIMEZONE);
                    $model->FromDate = ConvertDateToUTC(date("Y-m-d H:i:s",strtotime($_POST['Advertisements']['FromDate'])));
                    $model->ToDate = ConvertDateToUTC(date("Y-m-d H:i:s",strtotime($_POST['Advertisements']['ToDate'])));
                    $model->CreatedBy = Yii::$app->user->identity->UserID;
                    $model->save();
                    return $this->redirect(['index']);
                }
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Advertisements model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->FromDate = ConvertDateTolocaltime($model->FromDate);
        $model->ToDate = ConvertDateTolocaltime($model->ToDate);
        if ($model->load(Yii::$app->request->post())) {
            $sql = 'SELECT GetUniqueCode() as unique_key';
            $command = Yii::$app->db->createCommand($sql);
            $functionvlary = $command->queryAll();
            $unique_Id = $functionvlary[0]['unique_key'];
            if ($model->validate()) {
                if (isset($_FILES) && !empty($_FILES)) {
                    if ($_FILES['Advertisements']['tmp_name']['ImagePath'] != '') {
                list($width, $height, $type, $attr)= getimagesize($_FILES["Advertisements"]["tmp_name"]['ImagePath']);    
        if($width>1133 && $width>1123){
                                $model->addError('ImagePath','Please Upload Valid Image');
                                return $this->render('update', [
                                'model' => $model,
                            ]);     
        }
        elseif($height>73 && $height>63){
                                $model->addError('ImagePath','Please Upload Valid Image');
                                 return $this->render('update', [
                                'model' => $model,
                            ]);
        }
                        $imageName = ADVERISEMENT . '/' . $model->ImagePath;
                        $deleteObject = \S3::deleteObject(S3BUCKET, $imageName);
                        $filesTempName = $_FILES['Advertisements']['tmp_name']['ImagePath'];
                        $fileName = $_FILES['Advertisements']['name']['ImagePath'];
                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                        $actualImageName = PREFIX_ADVERISEMENT . $unique_Id . '.' . $ext;
                        if (\S3::putObjectFile($filesTempName, S3BUCKET, BUCKET_FOLDER . '/' . ADVERISEMENT . '/' . $actualImageName, \S3::ACL_PUBLIC_READ)) {
                            $model->ImagePath = $actualImageName;
                        }
                    }
                }
                $model->FromDate = ConvertDateToUTC(date("Y-m-d H:i:s",strtotime($_POST['Advertisements']['FromDate'])));
                $model->ToDate = ConvertDateToUTC(date("Y-m-d H:i:s",strtotime($_POST['Advertisements']['ToDate'])));
                $model->Updated = ConvertDateToUTC(date("Y-m-d H:i:s"));
                $model->UpdatedBy = Yii::$app->user->identity->UserID;
                $model->save();
                return $this->redirect(['index']);
            } else {
                $errors = $model->errors;
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Advertisements model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model=$this->findModel($id);
        $imageName =ADVERISEMENT.'/'.$model->ImagePath;
        $deleteObject = \S3::deleteObject(S3BUCKET,$imageName);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Advertisements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advertisements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Advertisements::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
