<?php

namespace backend\controllers;

use Yii;
use backend\models\Category;
use backend\models\CategorySearch;
use backend\models\Categorygeographic;
use backend\components\BackendController;
use backend\models\Videocategory;
use backend\models\Country;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends \backend\components\BackendController {
    /* public function behaviors()
      {
      return [
      'access' => [
      'class' => AccessControl::className(),
      'rules' => [
      [
      'allow' => true,
      'actions' => ['view','addvideos','videosearch','remove','update','create','index'],
      'roles' => ['@'],
      ],
      ],
      ],
      ];
      }
     */

    public function beforeAction($action) {
        if (\Yii::$app->getUser()->isGuest &&
                \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl)
        ) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CategorySearch();
        if (isset($_GET['CategorySearch'])) {
            $searchModel->attributes = $_GET['CategorySearch'];
        }
        /**
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         */
        return $this->render('index', [
                    'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $searchvideoModel = new CategorySearch();
// build and execute the query
        $modelCountry = new \backend\models\Categorygeographic();
        $countryData = $modelCountry->findAll(array('CategID' => $id));
        $country = array();
        foreach ($countryData as $key => $value) {
            $country[] = $value->CountryID;
        }
        $sort = ' vc.DisplayIndex DESC'; 
        $sql = 'CALL Admin_Category_Topic_PlayList_Video_List (:id,:categType,"",:sort,"","")';
        $var_one = '1';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $id);
        $command->bindParam(":categType", $var_one);
        $command->bindParam(":sort", $sort);
        $inlist = $command->queryAll();

        /* - Get Video Not In Category- */
        $sort = ' v.Created DESC ';
        $sql = 'CALL Admin_video_category (:id,:IDType,"",:sort,"","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $id);
        $command->bindParam(":IDType", $var_one);
        $command->bindParam(":sort", $sort);
        $outlist = $command->queryAll();
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'searchvideoModel' => $searchvideoModel,
                    'videoinlist' => $inlist,
                    'videooutlist' => $outlist,
                    'selectedcountry' => $country
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Category();
        $model->CreatedBy = Yii::$app->user->identity->UserID;
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()) {
                $model->save();
                $insertedcntryary = Yii::$app->request->post('Country');
                if (!empty($insertedcntryary)) {

                    foreach ($insertedcntryary as $insertedcntry) {

                        $Categorygeographic = new Categorygeographic();
                        $Categorygeographic->CategID = $model->ID;
                        $Categorygeographic->CountryID = $insertedcntry;
                        $Categorygeographic->save();
                    }
                }

                /**  start : Add or update langauge translation fields **/
                if(isset($_POST['languageFields'])){
                        $_POST['languageFields']['from_table_id'] = $model->ID;
                        \backend\models\LangaugeFields::SaveLanguageFields($_POST['languageFields']);
                }
              /**  stop : Add or update langauge translation fields **/
                Yii::$app->session->setFlash('success', 'Category  has been added successfully');
                return $this->redirect('index');
            }
            else{
                return $this->render('create', [
                'model' => $model
            ]);
            }
        } else {

            return $this->render('create', [
                        'model' => $model
            ]);
        }
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddvideos() {
        if (Yii::$app->request->post()) {
            $videoidary = Yii::$app->request->post('videoid');
            $categoryid = Yii::$app->request->post('category');
            if (!empty($videoidary)) {

                foreach ($videoidary as $videoidarylp) {
                    $Videocategory = new Videocategory();
                    $Videocategory->CategID = $categoryid;
                    $Videocategory->VideoID = $videoidarylp;
                    $Videocategory->save();
                }
            }
            return $this->redirect(['view', 'id' => $categoryid]);
        } else {
            return $this->render('index', []);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $insertedcntryary = Yii::$app->request->post('Country');
        $model->Updated = date("Y-m-d H:i:s");
        $model->UpdatedBy = Yii::$app->user->identity->UserID;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!empty($insertedcntryary)) {
                        $insertedcntrystring = implode(",", $insertedcntryary);
                        Categorygeographic::deleteAll('CategID = :id  and CountryID NOT IN (:countryid)', ['id' => $id, ':countryid' => $insertedcntrystring]);
                foreach ($insertedcntryary as $insertedcntry) {
                    $categormodel = Categorygeographic::find()->where('CategID = :id  and CountryID = :cntryid', ['id' => $id, 'cntryid' => $insertedcntry])->one();
                    if (empty($categormodel)) {
                        $Categorygeographic = new Categorygeographic();
                        $Categorygeographic->CategID = $model->ID;
                        $Categorygeographic->CountryID = $insertedcntry;
                        $Categorygeographic->save();
                    }
                }
            }
            else{
              Categorygeographic::deleteAll('CategID = :id ', ['id' => $id]);  
            }
                    $arrayvideoin=json_decode(Yii::$app->request->post('arrayvideoin'),true);
                    $arrayvideoincount=count($arrayvideoin);
            if(!empty($arrayvideoin)){
                
            //$inlist = Videocategory::findAll(['CategID' => $id]);
            $inlist = Videocategory::find()->where(['CategID' => $id])->max('Displayindex');;

            $index = $inlist;
            if($index > 0){ $index++; }else{ $index = 1;}
            foreach($arrayvideoin as $arrayvideoinlist){
                    $categvideomodel = Videocategory::find()->where('CategID = :id  and VideoID = :videoid', ['id'=>$id,'videoid'=>$arrayvideoinlist])->one();
            if(empty($categvideomodel)){
                    $Videocategory = new Videocategory();
                    $Videocategory->CategID = $id;
                    $Videocategory->VideoID = $arrayvideoinlist;
                    $Videocategory->DisplayIndex = $index;
                    $Videocategory->save();
                    $index++;
                    }  
                }
            }
                    $arrayvideoout=json_decode(Yii::$app->request->post('arrayvideoout'),true);
            if(!empty($arrayvideoout)) {
            foreach($arrayvideoout as $arrayvideooutlist){
                
                     $catevideomodel = Videocategory::find()->where('CategID = :id  and VideoID = :videoid', ['id'=>$id,'videoid'=>$arrayvideooutlist])->one();   
            if(!empty($catevideomodel))
            {
                    $catevideomodel->delete();
                 } 
            }
        }

          if(isset($_POST['languageFields'])){
                        $_POST['languageFields']['from_table_id'] = $model->ID;
                        \backend\models\LangaugeFields::SaveLanguageFields($_POST['languageFields']);
                }
            Yii::$app->session->setFlash('success', 'Category  has been Updated successfully');
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Category  has been Deleted successfully');
        return $this->redirect(['index']);
    }

    /**
      Remove Video from category
     * */
    public function actionRemove() {
        $infoary = Yii::$app->request->post('info');
        $categoryid = Yii::$app->request->post('category');
        if (!empty($infoary)) {
            foreach ($infoary as $vidoid) {
                Videocategory::deleteAll('CategID = :categid AND VideoID=:videoid', [':categid' => $categoryid, ':videoid' => $vidoid]);
            }
        }
        Yii::$app->session->setFlash('success', 'Video Hase been removed Successfuilly');
        return $this->redirect(['view', 'id' => $categoryid]);
    }

    /**
     * Displays a Video by title.
     */
    public function actionVideosearch() {
        $var_one = '1';
        $videotitle = Yii::$app->request->post('videotitle');
        $categid = Yii::$app->request->post('categid');
        /* - Get Video Not In Category- */
        $sql = 'CALL Admin_video_category (:id,:IDType,:videotitle,"","","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $categid);
        $command->bindParam(":IDType", $var_one);
        $command->bindParam(":videotitle", $videotitle);
        $videodetils = $command->queryAll();
        if (!empty($videodetils)) {
            foreach ($videodetils as $videodetilssub) {
                //'.$videodetilssub['VideoThumb'].'
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumb" class="videothumbchkbox" value="' . $videodetilssub['ID'] . '"><img class="thumbnail img-responsive" src="' .ImagesUrl($videodetilssub) . '"><p>' . $videodetilssub['Title'] . '</p></div>';
            }
        } else {
            echo 'No Records Found';
        }
//echo $content;
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
