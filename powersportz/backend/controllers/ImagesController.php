<?php

namespace backend\controllers;

use Yii;
use backend\models\Images;
use backend\models\ImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ImagesController implements the CRUD actions for Images model.
 */
class ImagesController extends \backend\components\BackendController
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
    }
*/
    /**
     * Lists all Images models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImagesSearch();
        if (isset($_GET['ImagesSearch'])) {
            $searchModel->attributes = $_GET['ImagesSearch'];
        }
        return $this->render('index', [
                    'model' => $searchModel,
        ]);
    }
    
    public function actionAdd() {
        if(isset($_POST['ImageID']) && $_POST['ImageID']=='') {
            $model = new Images();
            $model->Title = addslashes($_POST['Title']);
            $model->ImageName = $_POST['ImageName'];
            $model->ImageType = '3';
            Yii::$app->session->setFlash('success', 'Image has been added successfully');
        } else {
            $model = $this->findModel($_POST['ImageID']);
            $model->Title = addslashes($_POST['Title']);
            if(isset($_POST['ImageName']) && $_POST['ImageName']!='') {
                $model->ImageName = $_POST['ImageName'];
            }
            Yii::$app->session->setFlash('success', 'Image has been updated successfully');
        }    
        if($model->save()) {
            if(isset($_POST['ImageName']) && $_POST['ImageName']!= '') {
                $image = $_POST['ImageName'];
                $content = file_get_contents(S3_BUCKETABSOLUTE_PATH.'/'.THUMBNAILS.'/Thumb/mainvideo/'.$image);
                $commonthumb = '../../upload/images/'.$image;
                $createthumb = '../../upload/images/thumb/'.$image;
                $createmedium = '../../upload/images/medium/'.$image;
                file_put_contents($commonthumb, $content);

                /*===============Resize to Medium =================*/
                $mediumimage=Yii::$app->image->load($commonthumb);
                list($width,$height) = explode('x',SIZE_MEDIUM);
                $mediumimage->resize($width,$height,\yii\image\drivers\Image::NONE);    
                $mediumimage->save($createmedium);
                
                /*===============Resize to Thumb =================*/
                $thumbimage = Yii::$app->image->load($commonthumb);   
                list($width,$height) = explode('x',SIZE_THUMB);
                $thumbimage->resize($width,$height,\yii\image\drivers\Image::NONE);    
                $thumbimage->save($createthumb);

                /*===============Upload to Original =================*/
                \S3::putObjectFile($commonthumb,S3BUCKET,THUMBNAILS.'/'.$image,\S3::ACL_PUBLIC_READ);
                /*===============Upload to Medium =================*/
                \S3::putObjectFile($createmedium,S3BUCKET,THUMBNAILS.'/'.THUMBNAILS_MEDIUM.'/'.$image,\S3::ACL_PUBLIC_READ);
                /*===============Upload to Thumb =================*/
                \S3::putObjectFile($createthumb,S3BUCKET,THUMBNAILS.'/'.THUMBNAILS_THUMB.'/'.$image,\S3::ACL_PUBLIC_READ);
            }    
            echo json_encode(array('Status'=>'Ok'));
        } else {
            echo json_encode(array('Status'=>'Error'));
        }
        die;
    }

    /**
     * Displays a single Images model.
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
     * Creates a new Images model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Images();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ImageID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Images model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ImageID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Images model.
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
     * Finds the Images model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Images the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Images::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
